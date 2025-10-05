<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $studentId = $user->id;
        
        // Get student profile
        $student = Student::where('user_id', $studentId)->first();
        
        // Get available exams
        $availableExams = Exam::where('status', 'published')
            ->where(function($query) {
                $query->where('start_time', '<=', now())
                      ->where('end_time', '>=', now())
                      ->orWhere('start_time', null)
                      ->orWhere('end_time', null);
            })
            ->latest()
            ->take(5)
            ->get();

        // Get recent exam results
        $recentResults = ExamResult::where('student_id', $studentId)
            ->with('exam')
            ->latest()
            ->take(5)
            ->get();

        // Calculate statistics
        $totalExamsTaken = ExamResult::where('student_id', $studentId)->count();
        $averageScore = round(ExamResult::where('student_id', $studentId)->avg('percentage') ?? 0, 1);
        
        $stats = [
            'available_exams' => $availableExams->count(),
            'completed_exams' => $totalExamsTaken,
            'average_score' => $averageScore,
            'study_streak' => $this->calculateStudyStreak($studentId),
        ];

        // Get subject performance
        $subjectPerformance = $this->getSubjectPerformance($studentId);

        return view('student.dashboard.student-dashboard', compact(
            'user', 
            'student', 
            'availableExams', 
            'recentResults', 
            'stats',
            'subjectPerformance'
        ));
    }

    /**
     * Calculate study streak for student
     */
    private function calculateStudyStreak($studentId)
    {
        $results = ExamResult::where('student_id', $studentId)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($results->isEmpty()) {
            return 0;
        }

        $streak = 0;
        $lastDate = null;

        foreach ($results as $result) {
            $currentDate = $result->created_at->format('Y-m-d');
            
            if ($lastDate === null) {
                $streak = 1;
                $lastDate = $currentDate;
            } elseif ($lastDate === $currentDate) {
                // Same day, continue
                continue;
            } else {
                $daysDiff = now()->parse($lastDate)->diffInDays(now()->parse($currentDate));
                if ($daysDiff === 1) {
                    $streak++;
                    $lastDate = $currentDate;
                } else {
                    break;
                }
            }
        }

        return $streak;
    }

    /**
     * Get subject-wise performance
     */
    private function getSubjectPerformance($studentId)
    {
        // Check if exams table has subject_id column, if not return empty collection
        try {
            return DB::table('exam_results')
                ->join('exams', 'exam_results.exam_id', '=', 'exams.id')
                ->join('subjects', 'exams.subject_id', '=', 'subjects.id')
                ->where('exam_results.student_id', $studentId)
                ->select(
                    'subjects.name',
                    DB::raw('AVG(exam_results.percentage) as average_score'),
                    DB::raw('COUNT(exam_results.id) as total_exams')
                )
                ->groupBy('subjects.id', 'subjects.name')
                ->orderBy('average_score', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    $item->average_score = round($item->average_score, 1);
                    return $item;
                });
        } catch (\Exception $e) {
            // If subject_id column doesn't exist, return empty collection
            \Log::warning('Subject performance query failed, likely missing subject_id column in exams table', [
                'error' => $e->getMessage(),
                'student_id' => $studentId
            ]);
            return collect([]);
        }
    }
}
