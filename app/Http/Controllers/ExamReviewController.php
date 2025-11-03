<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\QuestionStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\HasPartnerContext;

class ExamReviewController extends Controller
{
    use HasPartnerContext;

    /**
     * Show exam review page
     */
    public function showReview(Request $request, $examId, $resultId)
    {
        $partnerId = $this->getPartnerId();

        $exam = Exam::where('id', $examId)->where('partner_id', $partnerId)->first();
        $result = ExamResult::where('id', $resultId)->where('exam_id', $examId)->first();
        
        if (!$exam || !$result) {
            abort(404, 'Exam or result not found.');
        }
        
        // Check if user has permission to view this result
        $this->authorizeReview($result);
        
        // Get detailed question statistics for this result
        $questionStats = $result->questionStats()
            ->with(['question' => function($query) use ($partnerId) {
                $query->where('partner_id', $partnerId)->with(['course', 'subject', 'topic']);
            }])
            ->orderBy('question_order')
            ->get();
        
        // Get analytics for this result
        $analytics = $result->detailed_analytics;
        
        // Calculate student's rank
        $allResults = ExamResult::where('exam_id', $examId)
            ->where('status', 'completed')
            ->orderBy('percentage', 'desc')
            ->get();
        
        $studentRank = $allResults->search(function($item) use ($result) {
            return $item->id === $result->id;
        }) + 1;
        
        $totalStudents = $allResults->count();
        $percentile = $totalStudents > 0 ? round((($totalStudents - $studentRank + 1) / $totalStudents) * 100, 2) : 0;
        
        return view('public.quiz.review', compact('exam', 'result', 'questionStats', 'analytics', 'studentRank', 'totalStudents', 'percentile'));
    }

    /**
     * Get detailed review data for AJAX requests
     */
    public function getReviewData(Request $request, $examId, $resultId)
    {
        $partnerId = $this->getPartnerId();

        $exam = Exam::where('id', $examId)->where('partner_id', $partnerId)->first();
        $result = ExamResult::where('id', $resultId)->where('exam_id', $examId)->first();
        
        if (!$exam || !$result) {
            return response()->json([
                'success' => false,
                'message' => 'Exam or result not found.'
            ], 404);
        }
        
        // Check if user has permission to view this result
        $this->authorizeReview($result);
        
        // Get detailed question statistics
        $questionStats = $result->questionStats()
            ->with(['question' => function($query) use ($partnerId) {
                $query->where('partner_id', $partnerId)->with(['course', 'subject', 'topic']);
            }])
            ->orderBy('question_order')
            ->get();
        
        // Get analytics
        $analytics = $result->detailed_analytics;
        
        // Get correct, incorrect, and skipped questions separately
        $correctQuestions = $result->getCorrectQuestions();
        $incorrectQuestions = $result->getIncorrectQuestions();
        $skippedQuestions = $result->getSkippedQuestions();
        
        return response()->json([
            'success' => true,
            'data' => [
                'exam' => $exam,
                'result' => $result,
                'question_stats' => $questionStats,
                'analytics' => $analytics,
                'correct_questions' => $correctQuestions,
                'incorrect_questions' => $incorrectQuestions,
                'skipped_questions' => $skippedQuestions,
            ]
        ]);
    }

    /**
     * Get question-specific review data
     */
    public function getQuestionReview(Request $request, $examId, $resultId, $questionId)
    {
        $partnerId = $this->getPartnerId();

        $exam = Exam::where('id', $examId)->where('partner_id', $partnerId)->first();
        $result = ExamResult::where('id', $resultId)->where('exam_id', $examId)->first();
        
        if (!$exam || !$result) {
            return response()->json([
                'success' => false,
                'message' => 'Exam or result not found.'
            ], 404);
        }
        
        // Check if user has permission to view this result
        $this->authorizeReview($result);
        
        // Get question statistics for this specific question
        $questionStat = $result->questionStats()
            ->where('question_id', $questionId)
            ->with(['question' => function($query) use ($partnerId) {
                $query->where('partner_id', $partnerId)->with(['course', 'subject', 'topic']);
            }])
            ->first();
        
        if (!$questionStat) {
            return response()->json([
                'success' => false,
                'message' => 'Question not found in this exam result'
            ], 404);
        }
        
        // Get question analytics
        $questionAnalytics = QuestionStat::getQuestionDetailedAnalytics($questionId);
        
        return response()->json([
            'success' => true,
            'data' => [
                'question_stat' => $questionStat,
                'question_analytics' => $questionAnalytics,
            ]
        ]);
    }

    /**
     * Get student's performance comparison with others
     */
    public function getPerformanceComparison(Request $request, $examId, $resultId)
    {
        // Check if this is a public user (no authentication) or partner user
        $accessInfo = session('quiz_access');
        
        if ($accessInfo && $accessInfo['exam_id'] == $examId) {
            // Public user access - verify the result belongs to this student
            $exam = Exam::where('id', $examId)->first();
            $result = ExamResult::where('id', $resultId)
                ->where('exam_id', $examId)
                ->where('student_id', $accessInfo['student_id'])
                ->first();
        } else {
            // Partner user access - require authentication
            $partnerId = $this->getPartnerId();
            $exam = Exam::where('id', $examId)->where('partner_id', $partnerId)->first();
            $result = ExamResult::where('id', $resultId)->where('exam_id', $examId)->first();
        }
        
        if (!$exam || !$result) {
            return response()->json([
                'success' => false,
                'message' => 'Exam or result not found.'
            ], 404);
        }
        
        // Get all results for this exam
        $allResults = ExamResult::where('exam_id', $examId)
            ->where('status', 'completed')
            ->orderBy('percentage', 'desc')
            ->get();
        
        // Find student's rank
        $studentRank = $allResults->search(function($item) use ($result) {
            return $item->id === $result->id;
        }) + 1;
        
        // Get percentile
        $totalStudents = $allResults->count();
        $percentile = $totalStudents > 0 ? round((($totalStudents - $studentRank + 1) / $totalStudents) * 100, 2) : 0;
        
        // Get average performance
        $averagePercentage = $allResults->avg('percentage');
        $averageScore = $allResults->avg('score');
        
        // Get performance distribution
        $distribution = [
            'excellent' => $allResults->where('percentage', '>=', 90)->count(),
            'good' => $allResults->where('percentage', '>=', 80)->where('percentage', '<', 90)->count(),
            'average' => $allResults->where('percentage', '>=', 70)->where('percentage', '<', 80)->count(),
            'below_average' => $allResults->where('percentage', '>=', 60)->where('percentage', '<', 70)->count(),
            'poor' => $allResults->where('percentage', '<', 60)->count(),
        ];
        
        return response()->json([
            'success' => true,
            'data' => [
                'student_rank' => $studentRank,
                'total_students' => $totalStudents,
                'percentile' => $percentile,
                'average_percentage' => $averagePercentage,
                'average_score' => $averageScore,
                'distribution' => $distribution,
            ]
        ]);
    }

    /**
     * Get detailed analytics for the exam
     */
    public function getExamAnalytics(Request $request, $examId, $resultId)
    {
        $partnerId = $this->getPartnerId();

        $exam = Exam::where('id', $examId)->where('partner_id', $partnerId)->first();
        $result = ExamResult::where('id', $resultId)->where('exam_id', $examId)->first();
        
        if (!$exam || !$result) {
            return response()->json([
                'success' => false,
                'message' => 'Exam or result not found.'
            ], 404);
        }
        
        // Check if user has permission to view this result
        $this->authorizeReview($result);
        
        // Get exam analytics
        $examAnalytics = QuestionStat::getExamQuestionAnalytics($examId);
        
        // Get question-wise analytics
        $questionAnalytics = [];
        $questions = $exam->questions;
        
        foreach ($questions as $question) {
            $questionAnalytics[] = [
                'question' => $question,
                'analytics' => QuestionStat::getQuestionDetailedAnalytics($question->id),
            ];
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'exam_analytics' => $examAnalytics,
                'question_analytics' => $questionAnalytics,
            ]
        ]);
    }

    /**
     * Get student's improvement suggestions
     */
    public function getImprovementSuggestions(Request $request, $examId, $resultId)
    {
        $partnerId = $this->getPartnerId();

        $exam = Exam::where('id', $examId)->where('partner_id', $partnerId)->first();
        $result = ExamResult::where('id', $resultId)->where('exam_id', $examId)->first();
        
        if (!$exam || !$result) {
            return response()->json([
                'success' => false,
                'message' => 'Exam or result not found.'
            ], 404);
        }
        
        // Check if user has permission to view this result
        $this->authorizeReview($result);
        
        $suggestions = [];
        
        // Get incorrect questions
        $incorrectQuestions = $result->getIncorrectQuestions();
        if ($incorrectQuestions->count() > 0) {
            $suggestions[] = [
                'type' => 'incorrect_answers',
                'title' => 'Review Incorrect Answers',
                'description' => "You answered {$incorrectQuestions->count()} questions incorrectly. Review these questions to understand the correct concepts.",
                'count' => $incorrectQuestions->count(),
                'questions' => $incorrectQuestions->take(5)->pluck('question'),
            ];
        }
        
        // Get skipped questions
        $skippedQuestions = $result->getSkippedQuestions();
        if ($skippedQuestions->count() > 0) {
            $suggestions[] = [
                'type' => 'skipped_questions',
                'title' => 'Complete Skipped Questions',
                'description' => "You skipped {$skippedQuestions->count()} questions. Try to answer all questions to maximize your score.",
                'count' => $skippedQuestions->count(),
                'questions' => $skippedQuestions->take(5)->pluck('question'),
            ];
        }
        
        // Get difficulty-based suggestions
        $analytics = $result->detailed_analytics;
        if (isset($analytics['difficulty_breakdown'])) {
            foreach ($analytics['difficulty_breakdown'] as $difficulty => $stats) {
                if ($stats['incorrect'] > 0) {
                    $suggestions[] = [
                        'type' => 'difficulty_focus',
                        'title' => "Focus on {$difficulty} Questions",
                        'description' => "You struggled with {$difficulty} questions. Consider practicing more {$difficulty} level questions.",
                        'difficulty' => $difficulty,
                        'incorrect_count' => $stats['incorrect'],
                    ];
                }
            }
        }
        
        // Get time-based suggestions
        $averageTime = $analytics['average_time_per_question'] ?? 0;
        if ($averageTime > 120) { // More than 2 minutes per question
            $suggestions[] = [
                'type' => 'time_management',
                'title' => 'Improve Time Management',
                'description' => "You spent an average of " . round($averageTime, 1) . " seconds per question. Try to answer questions more quickly.",
                'average_time' => $averageTime,
            ];
        }
        
        return response()->json([
            'success' => true,
            'data' => $suggestions
        ]);
    }

    /**
     * Authorize review access
     */
    private function authorizeReview(ExamResult $result)
    {
        // Check if the result belongs to the current user
        // This can be modified based on your authentication system
        $currentStudentId = session('quiz_access.student_id') ?? 1; // Default for public quiz
        
        if ($result->student_id != $currentStudentId) {
            abort(403, 'You are not authorized to view this exam result.');
        }
    }
}
