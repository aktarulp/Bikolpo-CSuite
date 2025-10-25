<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;
use App\Models\Partner;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\Student;
use App\Models\Teacher;
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
        // Custom route model binding for Teacher to use teacher_id or id
        Route::model('teacher', Teacher::class);
        Route::bind('teacher', function ($value) {
            // First try to find by teacher_id
            $teacher = Teacher::where('teacher_id', $value)->first();
            if ($teacher) {
                return $teacher;
            }
            // If not found by teacher_id, try by database id
            return Teacher::findOrFail($value);
        });

        // Auto-sync menu permissions from config to ac_permissions (idempotent)
        try {
            \App\Services\PermissionSyncService::syncMenus();
        } catch (\Throwable $e) {
            // swallow errors to not block app boot
        }

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
                    'total_teachers' => 0,
                    'total_questions' => 0,
                    'total_exams' => 0,
                    'total_question_attempts' => 0,
                ]);
                $view->with('partner', $view->getData()['partner'] ?? null);
                return;
            }
            
            // Get partner for the authenticated user
            $partner = Partner::find($user->partner_id);
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
                'total_teachers' => $existingStats['total_teachers'] ?? ($partnerId ? Teacher::where('partner_id', $partnerId)->count() : 0),
                'total_questions' => $existingStats['total_questions'] ?? ($partnerId ? Question::where('partner_id', $partnerId)->where('status', 'active')->count() : 0),
                'total_exams' => $existingStats['total_exams'] ?? ($partnerId ? Exam::where('partner_id', $partnerId)->count() : 0),
                'total_question_attempts' => $existingStats['total_question_attempts'] ?? 0,
            ];
            
            
            // Merge with any additional stats from controller
            $stats = array_merge($stats, $existingStats);
            
            $view->with('stats', $stats);
            // Always use the partner we fetched, don't fall back to existing data
            $view->with('partner', $partner);
        });
    }
}
