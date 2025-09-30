<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Partner;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\Student;
use App\Models\Question;
use App\Models\Exam;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share stats with partner layout
        View::composer('layouts.partner-layout', function ($view) {
            $user = Auth::user();
            
            // If no user is authenticated, provide empty stats
            if (!$user) {
                $view->with('stats', $view->getData()['stats'] ?? [
                    'total_courses' => 0,
                    'total_batches' => 0,
                    'total_subjects' => 0,
                    'total_topics' => 0,
                    'total_students' => 0,
                    'total_questions' => 0,
                    'total_exams' => 0,
                    'total_question_attempts' => 0,
                    'total_sms' => 0,
                ]);
                $view->with('partner', $view->getData()['partner'] ?? null);
                return;
            }
            
            // Get partner for the authenticated user
            $partner = Partner::where('user_id', $user->id)->first();
            $partnerId = $partner?->id;
            
            // If stats are already provided by the controller, merge with defaults
            $existingStats = $view->getData()['stats'] ?? [];
            
            // Only compute stats if not already provided
            $stats = [
                'total_courses' => $existingStats['total_courses'] ?? ($partnerId ? Course::where('partner_id', $partnerId)->count() : 0),
                'total_batches' => $existingStats['total_batches'] ?? ($partnerId ? Batch::where('partner_id', $partnerId)->count() : 0),
                'total_subjects' => $existingStats['total_subjects'] ?? ($partnerId ? Subject::where('partner_id', $partnerId)->count() : 0),
                'total_topics' => $existingStats['total_topics'] ?? ($partnerId ? Topic::where('partner_id', $partnerId)->count() : 0),
                'total_students' => $existingStats['total_students'] ?? ($partnerId ? Student::where('partner_id', $partnerId)->count() : 0),
                'total_questions' => $existingStats['total_questions'] ?? ($partnerId ? Question::where('partner_id', $partnerId)->where('status', 'active')->count() : 0),
                'total_exams' => $existingStats['total_exams'] ?? ($partnerId ? Exam::where('partner_id', $partnerId)->count() : 0),
                'total_question_attempts' => $existingStats['total_question_attempts'] ?? 0,
                'total_sms' => $existingStats['total_sms'] ?? 0,
            ];
            
            // Merge with any additional stats from controller
            $stats = array_merge($stats, $existingStats);
            
            $view->with('stats', $stats);
            $view->with('partner', $view->getData()['partner'] ?? $partner);
        });
    }
}
