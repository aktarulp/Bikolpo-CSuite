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

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get partner information if teacher belongs to a partner
        $partner = null;
        if ($user->partner_id) {
            $partner = Partner::find($user->partner_id);
        }
        
        // Get statistics for teacher's activities
        $stats = [
            'total_courses' => Course::where('created_by', $user->id)->count(),
            'total_subjects' => Subject::where('created_by', $user->id)->count(),
            'total_topics' => Topic::where('created_by', $user->id)->count(),
            'total_questions' => Question::where('created_by', $user->id)->count(),
            'total_exams' => Exam::where('created_by', $user->id)->count(),
            'total_students' => Student::where('partner_id', $user->partner_id)->count(),
        ];
        
        return view('teacher.dashboard', compact('user', 'partner', 'stats'));
    }
}
