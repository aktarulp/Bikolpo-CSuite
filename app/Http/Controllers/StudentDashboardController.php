<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Exam;
use App\Models\StudentExamResult;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function index()
    {
        // Get the authenticated user
        $user = auth()->user();
        $student = $user->student;
        
        if (!$student) {
            // If no student record exists, redirect to profile completion
            return redirect()->route('student.profile.edit')
                ->with('error', 'Please complete your student profile first.');
        }
        
        $available_exams = Exam::where('status', 'published')
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->with('questionSet')
            ->get();

        $recent_results = StudentExamResult::where('student_id', $student->id)
            ->with('exam')
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total_exams_taken' => StudentExamResult::where('student_id', $student->id)->count(),
            'passed_exams' => StudentExamResult::where('student_id', $student->id)
                ->whereHas('exam', function($query) {
                    $query->whereColumn('passing_marks', '<=', 'student_exam_results.percentage');
                })->count(),
            'average_score' => StudentExamResult::where('student_id', $student->id)->avg('percentage') ?? 0,
        ];

        return view('student.dashboard.index', compact('student', 'available_exams', 'recent_results', 'stats'));
    }
}
