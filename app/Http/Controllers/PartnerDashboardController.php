<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Question;
use App\Models\QuestionSet;
use App\Models\Exam;
use App\Models\StudentExamResult;
use Illuminate\Http\Request;

class PartnerDashboardController extends Controller
{
    public function index()
    {
        // Get the authenticated user's ID and find the corresponding partner
        $user = auth()->user();
        
        // Debug logging
        \Log::info('Dashboard accessed by user ID: ' . $user->id . ' with email: ' . $user->email);
        
        $partner = Partner::where('user_id', $user->id)->first();
        
        if ($partner) {
            \Log::info('Partner found: ID=' . $partner->id . ', Name=' . $partner->name . ', User ID=' . $partner->user_id);
        } else {
            \Log::info('No partner found for user ID: ' . $user->id);
        }
        
        if (!$partner) {
            // If no partner found, try to link to an existing partner or create a default one
            $existingPartner = Partner::first();
            if ($existingPartner) {
                // Link the existing partner to this user
                $existingPartner->update(['user_id' => $user->id]);
                $partner = $existingPartner;
                \Log::info('Linked existing partner to user: ' . $user->id);
            } else {
                // Create a default partner for this user
                $partner = Partner::create([
                    'user_id' => $user->id,
                    'name' => $user->name ?? 'Default Partner',
                    'status' => 'active',
                ]);
                \Log::info('Created default partner for user: ' . $user->id);
            }
        }
        
        $stats = [
            'total_questions' => Question::where('partner_id', $partner->id)->count(),
            'total_question_sets' => QuestionSet::where('partner_id', $partner->id)->count(),
            'total_exams' => Exam::where('partner_id', $partner->id)->count(),
            'total_students' => \App\Models\Student::whereHas('examResults.exam', function($query) use ($partner) {
                $query->where('partner_id', $partner->id);
            })->distinct()->count(),
        ];

        $recent_exams = Exam::where('partner_id', $partner->id)
            ->with('questionSet')
            ->latest()
            ->take(5)
            ->get();

        $recent_results = StudentExamResult::whereHas('exam', function($query) use ($partner) {
            $query->where('partner_id', $partner->id);
        })
        ->with(['student', 'exam'])
        ->latest()
        ->take(10)
        ->get();

        return view('partner.dashboard', compact('stats', 'recent_exams', 'recent_results', 'partner'));
    }
}
