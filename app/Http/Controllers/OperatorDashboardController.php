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

class OperatorDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get partner information if operator belongs to a partner
        $partner = null;
        if ($user->partner_id) {
            $partner = Partner::find($user->partner_id);
        }
        
        // Get statistics for operator's activities
        $stats = [
            'total_courses' => Course::where('partner_id', $user->partner_id)->count(),
            'total_subjects' => Subject::where('partner_id', $user->partner_id)->count(),
            'total_topics' => Topic::where('partner_id', $user->partner_id)->count(),
            'total_questions' => Question::where('partner_id', $user->partner_id)->count(),
            'total_exams' => Exam::where('partner_id', $user->partner_id)->count(),
            'total_students' => Student::where('partner_id', $user->partner_id)->count(),
        ];
        
        return view('operator.dashboard', compact('user', 'partner', 'stats'));
    }
}
