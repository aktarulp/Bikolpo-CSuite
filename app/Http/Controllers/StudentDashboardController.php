<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        // Get the authenticated user's ID
        $studentId = auth()->id();
        
        $student = Student::find($studentId);
        
        $available_exams = Exam::where('status', 'published')
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            // ->with('questionSet')
            ->get();

        $recent_results = ExamResult::where('student_id', $studentId)
            ->with('exam')
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total_exams_taken' => ExamResult::where('student_id', $studentId)->count(),
            'passed_exams' => ExamResult::where('student_id', $studentId)
                ->whereHas('exam', function($query) {
                    $query->whereColumn('passing_marks', '<=', 'exam_results.percentage');
                })->count(),
            'average_score' => ExamResult::where('student_id', $studentId)->avg('percentage') ?? 0,
        ];

        return view('student.dashboard', compact('student', 'available_exams', 'recent_results', 'stats'));
    }
}
