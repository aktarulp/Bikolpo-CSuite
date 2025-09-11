<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionStat;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionAnalyticsController extends Controller
{
    /**
     * Display question analytics dashboard
     */
    public function index()
    {
        try {
            $totalQuestions = Question::count();
            $totalAttempts = QuestionStat::count();
            $totalCorrect = QuestionStat::correct()->count();
            $totalIncorrect = QuestionStat::incorrect()->count();
            $totalSkipped = QuestionStat::skipped()->count();
            
            $overallAccuracy = $totalAttempts > 0 ? round(($totalCorrect / $totalAttempts) * 100, 2) : 0;
            
            // Get top performing questions (with at least 1 attempt)
            $topQuestions = QuestionStat::select('question_id')
                ->selectRaw('COUNT(*) as total_attempts')
                ->selectRaw('SUM(CASE WHEN is_correct = 1 THEN 1 ELSE 0 END) as correct_attempts')
                ->selectRaw('ROUND((SUM(CASE WHEN is_correct = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as accuracy_percentage')
                ->groupBy('question_id')
                ->having('total_attempts', '>=', 1) // Lower threshold for demo
                ->orderBy('accuracy_percentage', 'desc')
                ->limit(10)
                ->with('question')
                ->get();
            
            // Get worst performing questions (with at least 1 attempt)
            $worstQuestions = QuestionStat::select('question_id')
                ->selectRaw('COUNT(*) as total_attempts')
                ->selectRaw('SUM(CASE WHEN is_correct = 1 THEN 1 ELSE 0 END) as correct_attempts')
                ->selectRaw('ROUND((SUM(CASE WHEN is_correct = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as accuracy_percentage')
                ->groupBy('question_id')
                ->having('total_attempts', '>=', 1) // Lower threshold for demo
                ->orderBy('accuracy_percentage', 'asc')
                ->limit(10)
                ->with('question')
                ->get();
        
            return view('analytics.questions.index', compact(
                'totalQuestions',
                'totalAttempts',
                'totalCorrect',
                'totalIncorrect',
                'totalSkipped',
                'overallAccuracy',
                'topQuestions',
                'worstQuestions'
            ));
        } catch (\Exception $e) {
            \Log::error('Question Analytics Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to load analytics data. Please try again.');
        }
    }
    
    /**
     * Show detailed analytics for a specific question
     */
    public function show(Question $question)
    {
        $analytics = QuestionStat::getQuestionAnalytics($question->id);
        
        // Get recent attempts
        $recentAttempts = QuestionStat::forQuestion($question->id)
            ->with(['student', 'exam'])
            ->latest()
            ->limit(20)
            ->get();
        
        // Get performance by exam
        $performanceByExam = QuestionStat::forQuestion($question->id)
            ->select('exam_id')
            ->selectRaw('COUNT(*) as total_attempts')
            ->selectRaw('SUM(CASE WHEN is_correct = 1 THEN 1 ELSE 0 END) as correct_attempts')
            ->selectRaw('ROUND((SUM(CASE WHEN is_correct = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as accuracy_percentage')
            ->groupBy('exam_id')
            ->with('exam')
            ->orderBy('total_attempts', 'desc')
            ->get();
        
        // Get answer distribution for MCQ questions
        $answerDistribution = [];
        if ($question->question_type === 'mcq') {
            $answerDistribution = QuestionStat::forQuestion($question->id)
                ->where('is_answered', true)
                ->select('student_answer')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('student_answer')
                ->orderBy('count', 'desc')
                ->get();
        }
        
        return view('analytics.questions.show', compact(
            'question',
            'analytics',
            'recentAttempts',
            'performanceByExam',
            'answerDistribution'
        ));
    }
    
    /**
     * Show analytics for a specific exam
     */
    public function examAnalytics(Exam $exam)
    {
        $analytics = QuestionStat::getExamQuestionAnalytics($exam->id);
        
        // Get question-wise performance
        $questionPerformance = QuestionStat::forExam($exam->id)
            ->select('question_id')
            ->selectRaw('COUNT(*) as total_attempts')
            ->selectRaw('SUM(CASE WHEN is_correct = 1 THEN 1 ELSE 0 END) as correct_attempts')
            ->selectRaw('SUM(CASE WHEN is_skipped = 1 THEN 1 ELSE 0 END) as skipped_attempts')
            ->selectRaw('ROUND((SUM(CASE WHEN is_correct = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as accuracy_percentage')
            ->groupBy('question_id')
            ->with('question')
            ->orderBy('question_id')
            ->get();
        
        // Get student performance
        $studentPerformance = QuestionStat::forExam($exam->id)
            ->select('student_id')
            ->selectRaw('COUNT(*) as total_questions')
            ->selectRaw('SUM(CASE WHEN is_correct = 1 THEN 1 ELSE 0 END) as correct_answers')
            ->selectRaw('SUM(CASE WHEN is_skipped = 1 THEN 1 ELSE 0 END) as skipped_questions')
            ->selectRaw('ROUND((SUM(CASE WHEN is_correct = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as accuracy_percentage')
            ->groupBy('student_id')
            ->with('student')
            ->orderBy('accuracy_percentage', 'desc')
            ->get();
        
        return view('analytics.exams.show', compact(
            'exam',
            'analytics',
            'questionPerformance',
            'studentPerformance'
        ));
    }
    
    /**
     * Show student analytics
     */
    public function studentAnalytics($studentId)
    {
        $student = \App\Models\Student::findOrFail($studentId);
        $analytics = QuestionStat::getStudentQuestionAnalytics($studentId);
        
        // Get comprehensive student analytics
        $comprehensiveAnalytics = $student->getComprehensiveAnalytics();
        
        // Get performance by question type
        $performanceByType = QuestionStat::where('student_id', $studentId)
            ->select('question_type')
            ->selectRaw('COUNT(*) as total_attempts')
            ->selectRaw('SUM(CASE WHEN is_correct = 1 THEN 1 ELSE 0 END) as correct_attempts')
            ->selectRaw('ROUND((SUM(CASE WHEN is_correct = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as accuracy_percentage')
            ->groupBy('question_type')
            ->get();
        
        // Get recent performance
        $recentPerformance = QuestionStat::where('student_id', $studentId)
            ->with(['question', 'exam'])
            ->latest()
            ->limit(20)
            ->get();
        
        // Get detailed exam results with question breakdown
        $examResults = $student->examResults()
            ->with(['exam', 'questionStats.question'])
            ->orderBy('completed_at', 'desc')
            ->get();
        
        // Get performance trends over time
        $performanceTrend = $this->getPerformanceTrend($studentId);
        
        // Get difficulty performance
        $difficultyPerformance = $student->getDifficultyPerformance();
        
        // Get question type performance
        $questionTypePerformance = $student->getQuestionTypePerformance();
        
        // Get exam performance
        $examPerformance = $student->getExamPerformance();
        
        // Get improvement trend
        $improvementTrend = $student->getImprovementTrend();
        
        // Get difficult questions
        $difficultQuestions = $student->getDifficultQuestions(10);
        
        // Get easy questions
        $easyQuestions = $student->getEasyQuestions(10);
        
        return view('analytics.students.show', compact(
            'student',
            'analytics',
            'comprehensiveAnalytics',
            'performanceByType',
            'recentPerformance',
            'examResults',
            'performanceTrend',
            'difficultyPerformance',
            'questionTypePerformance',
            'examPerformance',
            'improvementTrend',
            'difficultQuestions',
            'easyQuestions'
        ));
    }
    
    /**
     * Get performance trend over time
     */
    private function getPerformanceTrend($studentId)
    {
        $trends = QuestionStat::where('student_id', $studentId)
            ->selectRaw('DATE(created_at) as date')
            ->selectRaw('COUNT(*) as total_questions')
            ->selectRaw('SUM(CASE WHEN is_correct = 1 THEN 1 ELSE 0 END) as correct_answers')
            ->selectRaw('ROUND((SUM(CASE WHEN is_correct = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as accuracy_percentage')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->limit(30)
            ->get();
        
        return $trends;
    }
    
    /**
     * Get question statistics API endpoint
     */
    public function getQuestionStats(Request $request)
    {
        $questionId = $request->input('question_id');
        
        if (!$questionId) {
            return response()->json(['error' => 'Question ID is required'], 400);
        }
        
        $analytics = QuestionStat::getQuestionAnalytics($questionId);
        
        return response()->json($analytics);
    }
    
    /**
     * Get exam statistics API endpoint
     */
    public function getExamStats(Request $request)
    {
        $examId = $request->input('exam_id');
        
        if (!$examId) {
            return response()->json(['error' => 'Exam ID is required'], 400);
        }
        
        $analytics = QuestionStat::getExamQuestionAnalytics($examId);
        
        return response()->json($analytics);
    }
    
    /**
     * Get detailed exam result for a student
     */
    public function getExamResultDetails($studentId, $examResultId)
    {
        $student = \App\Models\Student::findOrFail($studentId);
        $examResult = $student->examResults()->with(['exam', 'questionStats.question'])->findOrFail($examResultId);
        
        $detailedAnalytics = $examResult->getDetailedAnalyticsAttribute();
        
        return response()->json([
            'exam_result' => $examResult,
            'detailed_analytics' => $detailedAnalytics,
            'correct_questions' => $examResult->getCorrectQuestions(),
            'incorrect_questions' => $examResult->getIncorrectQuestions(),
            'skipped_questions' => $examResult->getSkippedQuestions(),
        ]);
    }
    
    /**
     * Export question analytics to CSV
     */
    public function exportQuestionAnalytics(Question $question)
    {
        $analytics = QuestionStat::getQuestionAnalytics($question->id);
        $attempts = QuestionStat::forQuestion($question->id)
            ->with(['student', 'exam'])
            ->get();
        
        $filename = "question_{$question->id}_analytics_" . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];
        
        $callback = function() use ($analytics, $attempts, $question) {
            $file = fopen('php://output', 'w');
            
            // Write analytics summary
            fputcsv($file, ['Question Analytics Summary']);
            fputcsv($file, ['Question ID', $question->id]);
            fputcsv($file, ['Question Text', $question->question_text]);
            fputcsv($file, ['Total Appearances', $analytics['total_appearances']]);
            fputcsv($file, ['Total Answered', $analytics['total_answered']]);
            fputcsv($file, ['Total Correct', $analytics['total_correct']]);
            fputcsv($file, ['Total Incorrect', $analytics['total_incorrect']]);
            fputcsv($file, ['Total Skipped', $analytics['total_skipped']]);
            fputcsv($file, ['Correct Percentage', $analytics['correct_percentage'] . '%']);
            fputcsv($file, ['Answer Rate', $analytics['answer_rate'] . '%']);
            fputcsv($file, ['Average Time Spent', $analytics['average_time_spent'] . ' seconds']);
            fputcsv($file, []);
            
            // Write detailed attempts
            fputcsv($file, ['Detailed Attempts']);
            fputcsv($file, ['Student ID', 'Student Name', 'Exam ID', 'Exam Title', 'Student Answer', 'Correct Answer', 'Is Correct', 'Is Answered', 'Is Skipped', 'Time Spent (seconds)', 'Answered At']);
            
            foreach ($attempts as $attempt) {
                fputcsv($file, [
                    $attempt->student_id,
                    $attempt->student->full_name ?? 'N/A',
                    $attempt->exam_id,
                    $attempt->exam->title ?? 'N/A',
                    $attempt->student_answer,
                    $attempt->correct_answer,
                    $attempt->is_correct ? 'Yes' : 'No',
                    $attempt->is_answered ? 'Yes' : 'No',
                    $attempt->is_skipped ? 'Yes' : 'No',
                    $attempt->time_spent_seconds ?? 'N/A',
                    $attempt->question_answered_at ? $attempt->question_answered_at->format('Y-m-d H:i:s') : 'N/A',
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}