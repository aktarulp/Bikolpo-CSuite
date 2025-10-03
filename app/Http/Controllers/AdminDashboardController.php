<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Partner;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\Question;
use App\Models\Exam;
use App\Models\Student;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // System administrators can see all data
        $stats = [
            'total_partners' => Partner::count(),
            'total_users' => User::count(),
            'total_courses' => Course::count(),
            'total_subjects' => Subject::count(),
            'total_topics' => Topic::count(),
            'total_questions' => Question::count(),
            'total_exams' => Exam::count(),
            'total_students' => Student::count(),
        ];
        
        // Get recent activities or other admin-specific data
        $recentUsers = User::latest()->limit(5)->get();
        $recentPartners = Partner::latest()->limit(5)->get();
        
        return view('admin.dashboard', compact('user', 'stats', 'recentUsers', 'recentPartners'));
    }
}
