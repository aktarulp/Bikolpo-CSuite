<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionStat;
use App\Models\Student;
use App\Models\ExamResult;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    /**
     * Get question analytics
     */
    public function getQuestionAnalytics(Request $request, $questionId)
    {
        $question = Question::findOrFail($questionId);
        $analytics = QuestionStat::getQuestionDetailedAnalytics($questionId);
        
        return response()->json([
            'success' => true,
            'data' => [
                'question' => $question,
                'analytics' => $analytics,
            ]
        ]);
    }

    /**
     * Get student analytics
     */
    public function getStudentAnalytics(Request $request, $studentId)
    {
        $student = Student::findOrFail($studentId);
        $analytics = $student->getComprehensiveAnalytics();
        
        return response()->json([
            'success' => true,
            'data' => [
                'student' => $student,
                'analytics' => $analytics,
            ]
        ]);
    }

    /**
     * Get exam analytics
     */
    public function getExamAnalytics(Request $request, $examId)
    {
        $exam = Exam::findOrFail($examId);
        $analytics = QuestionStat::getExamQuestionAnalytics($examId);
        
        // Get detailed question breakdown
        $questionBreakdown = [];
        $questions = $exam->questions;
        
        foreach ($questions as $question) {
            $questionAnalytics = QuestionStat::getQuestionDetailedAnalytics($question->id);
            $questionBreakdown[] = [
                'question' => $question,
                'analytics' => $questionAnalytics,
            ];
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'exam' => $exam,
                'overall_analytics' => $analytics,
                'question_breakdown' => $questionBreakdown,
            ]
        ]);
    }

    /**
     * Get student performance for a specific exam
     */
    public function getStudentExamPerformance(Request $request, $studentId, $examId)
    {
        $student = Student::findOrFail($studentId);
        $exam = Exam::findOrFail($examId);
        $analytics = QuestionStat::getStudentExamAnalytics($studentId, $examId);
        
        return response()->json([
            'success' => true,
            'data' => [
                'student' => $student,
                'exam' => $exam,
                'analytics' => $analytics,
            ]
        ]);
    }

    /**
     * Get difficulty level analytics
     */
    public function getDifficultyAnalytics(Request $request)
    {
        $difficultyStats = QuestionStat::selectRaw('
            CASE 
                WHEN (COUNT(CASE WHEN is_correct = 1 THEN 1 END) * 100.0 / COUNT(*)) >= 80 THEN "easy"
                WHEN (COUNT(CASE WHEN is_correct = 1 THEN 1 END) * 100.0 / COUNT(*)) >= 60 THEN "medium"
                ELSE "hard"
            END as difficulty_level,
            COUNT(*) as total_questions,
            COUNT(CASE WHEN is_correct = 1 THEN 1 END) as correct_answers,
            COUNT(CASE WHEN is_correct = 0 AND is_answered = 1 THEN 1 END) as incorrect_answers,
            COUNT(CASE WHEN is_skipped = 1 THEN 1 END) as skipped_questions
        ')
        ->join('questions', 'question_statistics.question_id', '=', 'questions.id')
        ->groupBy('difficulty_level')
        ->get();

        return response()->json([
            'success' => true,
            'data' => $difficultyStats
        ]);
    }

    /**
     * Get question type analytics
     */
    public function getQuestionTypeAnalytics(Request $request)
    {
        $typeStats = QuestionStat::selectRaw('
            question_type,
            COUNT(*) as total_questions,
            COUNT(CASE WHEN is_correct = 1 THEN 1 END) as correct_answers,
            COUNT(CASE WHEN is_correct = 0 AND is_answered = 1 THEN 1 END) as incorrect_answers,
            COUNT(CASE WHEN is_skipped = 1 THEN 1 END) as skipped_questions,
            AVG(time_spent_seconds) as average_time_spent
        ')
        ->groupBy('question_type')
        ->get();

        return response()->json([
            'success' => true,
            'data' => $typeStats
        ]);
    }

    /**
     * Get top performing students
     */
    public function getTopPerformingStudents(Request $request, $limit = 10)
    {
        $topStudents = Student::select('students.*')
            ->join('question_statistics', 'students.id', '=', 'question_statistics.student_id')
            ->selectRaw('
                students.*,
                COUNT(*) as total_questions,
                COUNT(CASE WHEN question_statistics.is_correct = 1 THEN 1 END) as correct_answers,
                ROUND((COUNT(CASE WHEN question_statistics.is_correct = 1 THEN 1 END) * 100.0 / COUNT(*)), 2) as accuracy_percentage
            ')
            ->groupBy('students.id')
            ->having('total_questions', '>', 0)
            ->orderBy('accuracy_percentage', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $topStudents
        ]);
    }

    /**
     * Get most difficult questions
     */
    public function getMostDifficultQuestions(Request $request, $limit = 10)
    {
        $difficultQuestions = Question::select('questions.*')
            ->join('question_statistics', 'questions.id', '=', 'question_statistics.question_id')
            ->selectRaw('
                questions.*,
                COUNT(*) as total_attempts,
                COUNT(CASE WHEN question_statistics.is_correct = 1 THEN 1 END) as correct_answers,
                ROUND((COUNT(CASE WHEN question_statistics.is_correct = 1 THEN 1 END) * 100.0 / COUNT(*)), 2) as correct_percentage
            ')
            ->groupBy('questions.id')
            ->having('total_attempts', '>', 0)
            ->orderBy('correct_percentage', 'asc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $difficultQuestions
        ]);
    }

    /**
     * Get answer distribution for a question
     */
    public function getAnswerDistribution(Request $request, $questionId)
    {
        $question = Question::findOrFail($questionId);
        $distribution = QuestionStat::getAnswerDistribution($questionId);
        
        return response()->json([
            'success' => true,
            'data' => [
                'question' => $question,
                'distribution' => $distribution,
            ]
        ]);
    }

    /**
     * Get students who answered correctly for a question
     */
    public function getStudentsWhoAnsweredCorrectly(Request $request, $questionId)
    {
        $students = QuestionStat::where('question_id', $questionId)
            ->where('is_correct', true)
            ->with('student')
            ->get()
            ->pluck('student');

        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }

    /**
     * Get students who answered incorrectly for a question
     */
    public function getStudentsWhoAnsweredIncorrectly(Request $request, $questionId)
    {
        $students = QuestionStat::where('question_id', $questionId)
            ->where('is_correct', false)
            ->where('is_answered', true)
            ->with('student')
            ->get()
            ->pluck('student');

        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }
}
