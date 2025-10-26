<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartnerDashboardController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionHistoryController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\StudentExamController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Partner\AccessControlController;
use App\Http\Controllers\PartnerController; // Add this missing import
use App\Http\Controllers\SitemapController; // Add sitemap controller

// Include Auth Routes
require __DIR__.'/auth.php';

// Sitemap route
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

// Test logging route
Route::get('/test-log', function () {
    Log::info('Test log entry from /test-log route.');
    return 'Log entry attempted.';
});

// Debug partner profile data
Route::get('/debug-partner-profile', function () {
    $user = auth()->user();
    if (!$user) {
        return response()->json(['error' => 'Not authenticated']);
    }
    
    $partner = $user->partner;
    
    return response()->json([
        'user_id' => $user->id,
        'user_name' => $user->name,
        'user_partner_id' => $user->partner_id,
        'partner_exists' => $partner ? true : false,
        'partner_id' => $partner->id ?? null,
        'partner_data' => $partner ? $partner->toArray() : null,
        'partner_all_attributes' => $partner ? $partner->getAttributes() : null,
    ]);
})->middleware('auth');

// Test partner data directly
Route::get('/test-partner-data', function () {
    $partner = \App\Models\Partner::find(16);
    if (!$partner) {
        return response()->json(['error' => 'Partner not found']);
    }
    
    return response()->json([
        'partner_id' => $partner->id,
        'partner_name' => $partner->name,
        'total_fields' => count($partner->getAttributes()),
        'non_null_fields' => count(array_filter($partner->getAttributes(), fn($v) => !is_null($v))),
        'all_attributes' => $partner->getAttributes(),
    ]);
});

// Debug route to check user-role relationship
Route::get('/debug-user-role', function () {
    $users = \App\Models\EnhancedUser::with('role')->take(5)->get();
    $result = [];
    
    foreach ($users as $user) {
        $result[] = [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'role_id' => $user->role_id,
            'role_loaded' => $user->relationLoaded('role'),
            'role_exists' => $user->role ? true : false,
            'role_name' => $user->role ? $user->role->name : null,
            'role_display_name' => $user->role ? $user->role->display_name : null
        ];
    }
    
    return response()->json($result);
});

// Debug route to check raw database values
Route::get('/debug-db-role', function () {
    $users = DB::table('ac_users')->whereNotNull('role_id')->take(5)->get(['id', 'name', 'role_id']);
    $result = [];
    
    foreach ($users as $user) {
        $role = DB::table('ac_roles')->where('id', $user->role_id)->first();
        $result[] = [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'role_id' => $user->role_id,
            'role_exists' => $role ? true : false,
            'role_name' => $role ? $role->name : null,
            'role_display_name' => $role ? $role->display_name : null
        ];
    }
    
    return response()->json($result);
});

// Comprehensive debug route
Route::get('/debug-comprehensive', function () {
    // Check if roles exist
    $roles = \App\Models\EnhancedRole::all();
    $roleIds = $roles->pluck('id')->toArray();
    
    // Get users with role_id
    $users = \App\Models\EnhancedUser::whereNotNull('role_id')->with('role')->take(5)->get();
    
    $result = [
        'total_roles' => count($roleIds),
        'role_ids' => $roleIds,
        'users' => []
    ];
    
    foreach ($users as $user) {
        $result['users'][] = [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'role_id' => $user->role_id,
            'role_relation_loaded' => $user->relationLoaded('role'),
            'role_object_exists' => $user->role ? true : false,
            'role_name' => $user->role ? $user->role->name : null,
            'role_display_name' => $user->role ? $user->role->display_name : null,
            'role_id_valid' => in_array($user->role_id, $roleIds)
        ];
    }
    
    return response()->json($result);
});

// Debug route to test relationship directly
Route::get('/debug-relation', function () {
    $user = \App\Models\EnhancedUser::whereNotNull('role_id')->first();
    
    if (!$user) {
        return response()->json(['error' => 'No user with role_id found']);
    }
    
    // Test the relationship
    $role = $user->role;
    
    return response()->json([
        'user_id' => $user->id,
        'user_name' => $user->name,
        'role_id' => $user->role_id,
        'role_object' => $role ? [
            'id' => $role->id,
            'name' => $role->name,
            'display_name' => $role->display_name
        ] : null,
        'relation_loaded' => $user->relationLoaded('role'),
        'manual_lookup' => \App\Models\EnhancedRole::find($user->role_id) ? [
            'id' => \App\Models\EnhancedRole::find($user->role_id)->id,
            'name' => \App\Models\EnhancedRole::find($user->role_id)->name,
            'display_name' => \App\Models\EnhancedRole::find($user->role_id)->display_name
        ] : null
    ]);
});

// Test email route
Route::get('/test-email', function () {
    try {
        $user = new \App\Models\EnhancedUser(['email' => 'test@example.com', 'name' => 'Test User']);
        $user->notify(new \App\Notifications\OtpVerificationNotification('123456'));
        return 'Email sent successfully!';
    } catch (\Exception $e) {
        \Log::error('Email test failed: ' . $e->getMessage());
        return 'Email test failed: ' . $e->getMessage();
    }
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Landing page route - show the welcome page first
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'system-admin' || $user->role === 'system_administrator') {
            return redirect()->route('system-admin.system-admin-dashboard');
        } elseif ($user->role === 'student') {
            return redirect()->route('student.dashboard');
        } else {
            return redirect()->route('partner.dashboard');
        }
    }
    return view('welcome');
})->name('landing');

// Authenticated dashboards (fix missing named routes after login)
Route::middleware('auth')->group(function () {
    // Neutral Dashboard (auth-only, no role) for safe fallback
    Route::get('/dashboard', [PartnerDashboardController::class, 'index'])->name('dashboard');

    // Partner Dashboard
    Route::get('/partner/dashboard', [PartnerDashboardController::class, 'index'])->name('partner.dashboard');

    // Student Dashboard
    Route::get('/student/dashboard', [\App\Http\Controllers\StudentDashboardController::class, 'index'])->name('student.dashboard');

    

});

// Debug routes removed - partner context issue resolved

// Debug route to check user_id 18 data
Route::get('/debug-user-18', function () {
    $user18 = \App\Models\User::find(18);
    $user17 = \App\Models\User::find(17);
    $optEmail = \App\Models\User::where('email', 'opt@gg.com')->first();
    
    return response()->json([
        'user_18' => $user18 ? [
            'id' => $user18->id,
            'name' => $user18->name,
            'email' => $user18->email,
            'phone' => $user18->phone,
            'role' => $user18->role,
            'role_id' => $user18->role_id,
        ] : 'User 18 not found',
        'user_17' => $user17 ? [
            'id' => $user17->id,
            'name' => $user17->name,
            'email' => $user17->email,
            'phone' => $user17->phone,
            'role' => $user17->role,
            'role_id' => $user17->role_id,
        ] : 'User 17 not found',
        'opt_email_user' => $optEmail ? [
            'id' => $optEmail->id,
            'name' => $optEmail->name,
            'email' => $optEmail->email,
            'phone' => $optEmail->phone,
            'role' => $optEmail->role,
            'role_id' => $optEmail->role_id,
        ] : 'opt@gg.com not found',
    ]);
});

// Test login route to bypass all validation
Route::post('/test-login', function(\Illuminate\Http\Request $request) {
    dd([
        'message' => 'Test login route reached',
        'request_data' => $request->all(),
        'email_attempt' => $request->input('email'),
        'password_provided' => $request->has('password') ? 'Yes' : 'No',
    ]);
});

// Test password verification for user_id 18
Route::get('/test-password', function() {
    $user18 = \App\Models\User::find(18);
    $testPassword = '12345678';
    
    if (!$user18) {
        return response()->json(['error' => 'User 18 not found']);
    }
    
    $passwordCheck = \Hash::check($testPassword, $user18->password);
    
    return response()->json([
        'user_id' => $user18->id,
        'email' => $user18->email,
        'role' => $user18->role,
        'password_hash' => $user18->password,
        'test_password' => $testPassword,
        'password_matches' => $passwordCheck,
        'hash_info' => password_get_info($user18->password),
    ]);
});

// Debug route for access code testing
Route::get('/debug-access/{accessCode}/{phone}', function($accessCode, $phone) {
    $normalizedPhone = preg_replace('/[^0-9]/', '', $phone);
    if (strlen($normalizedPhone) === 11 && str_starts_with($normalizedPhone, '01')) {
        $normalizedPhone = '0' . substr($normalizedPhone, 1);
    }
    
    $accessCodeRecord = \App\Models\ExamAccessCode::where('access_code', $accessCode)
        ->whereHas('student', function ($query) use ($normalizedPhone) {
            $query->where('phone', $normalizedPhone);
        })
        ->with(['student', 'exam'])
        ->first();
    
    if ($accessCodeRecord) {
        $exam = $accessCodeRecord->exam;
        return response()->json([
            'found' => true,
            'access_code' => $accessCodeRecord->access_code,
            'student' => $accessCodeRecord->student->full_name,
            'student_phone' => $accessCodeRecord->student->phone,
            'exam_id' => $exam->id,
            'exam_title' => $exam->title,
            'exam_status' => $exam->status,
            'exam_start_time' => $exam->start_time,
            'exam_end_time' => $exam->end_time,
            'is_active' => $exam->isActive,
            'is_scheduled' => $exam->isScheduled(),
            'has_submitted' => $accessCodeRecord->hasSubmittedExam(),
            'current_time' => now()->toDateTimeString()
        ]);
    } else {
        return response()->json([
            'found' => false,
            'access_code' => $accessCode,
            'phone_searched' => $normalizedPhone,
            'original_phone' => $phone
        ]);
    }
});

// Test route to check available students and access codes
Route::get('/test-quiz-data', function() {
    $students = \App\Models\Student::with('accessCodes.exam')->take(5)->get();
    $accessCodes = \App\Models\ExamAccessCode::with(['student', 'exam'])->take(5)->get();
    
    return response()->json([
        'students' => $students->map(function($student) {
            return [
                'id' => $student->id,
                'name' => $student->full_name,
                'phone' => $student->phone,
                'access_codes' => $student->accessCodes->map(function($ac) {
                    return [
                        'code' => $ac->access_code,
                        'exam_title' => $ac->exam->title,
                        'status' => $ac->status
                    ];
                })
            ];
        }),
        'access_codes' => $accessCodes->map(function($ac) {
            return [
                'code' => $ac->access_code,
                'student_name' => $ac->student->full_name,
                'student_phone' => $ac->student->phone,
                'exam_title' => $ac->exam->title,
                'status' => $ac->status
            ];
        })
    ]);
});

// Test route to simulate submitted exam access
Route::get('/test-submitted-exam/{accessCode}/{phone}', function($accessCode, $phone) {
    $normalizedPhone = preg_replace('/[^0-9]/', '', $phone);
    if (strlen($normalizedPhone) === 11 && str_starts_with($normalizedPhone, '01')) {
        $normalizedPhone = '0' . substr($normalizedPhone, 1);
    }
    
    $accessCodeRecord = \App\Models\ExamAccessCode::where('access_code', $accessCode)
        ->whereHas('student', function ($query) use ($normalizedPhone) {
            $query->where('phone', $normalizedPhone);
        })
        ->with(['student', 'exam'])
        ->first();
    
    if ($accessCodeRecord) {
        // Simulate the processAccess logic
        if ($accessCodeRecord->status === 'used') {
            return response()->json([
                'message' => 'Access code is submitted - should redirect to results',
                'access_code' => $accessCodeRecord->access_code,
                'student' => $accessCodeRecord->student->full_name,
                'exam_title' => $accessCodeRecord->exam->title,
                'status' => $accessCodeRecord->status,
                'redirect_to' => route('public.quiz.result', $accessCodeRecord->exam_id)
            ]);
        } else {
            return response()->json([
                'message' => 'Access code is active - should allow normal access',
                'access_code' => $accessCodeRecord->access_code,
                'student' => $accessCodeRecord->student->full_name,
                'exam_title' => $accessCodeRecord->exam->title,
                'status' => $accessCodeRecord->status
            ]);
        }
    } else {
        return response()->json([
            'message' => 'Access code not found',
            'access_code' => $accessCode,
            'phone_searched' => $normalizedPhone
        ]);
    }
});

// Comprehensive test route for multi-time exam access
Route::get('/test-multi-access/{accessCode}/{phone}', function($accessCode, $phone) {
    $normalizedPhone = preg_replace('/[^0-9]/', '', $phone);
    if (strlen($normalizedPhone) === 11 && str_starts_with($normalizedPhone, '01')) {
        $normalizedPhone = '0' . substr($normalizedPhone, 1);
    }
    
    $accessCodeRecord = \App\Models\ExamAccessCode::where('access_code', $accessCode)
        ->whereHas('student', function ($query) use ($normalizedPhone) {
            $query->where('phone', $normalizedPhone);
        })
        ->with(['student', 'exam'])
        ->first();
    
    if (!$accessCodeRecord) {
        return response()->json([
            'status' => 'error',
            'message' => 'Access code not found',
            'access_code' => $accessCode,
            'phone_searched' => $normalizedPhone
        ]);
    }

    $exam = $accessCodeRecord->exam;
    $student = $accessCodeRecord->student;
    
    // Check exam results
    $results = \App\Models\ExamResult::where('student_id', $student->id)
        ->where('exam_id', $exam->id)
        ->orderBy('created_at', 'desc')
        ->get();
    
    // Check if exam is expired
    $isExpired = $accessCodeRecord->isExpired();
    
    // Check exam status
    $examStatus = $exam->status;
    $isActive = $exam->isActive;
    
    return response()->json([
        'status' => 'success',
        'access_code' => [
            'code' => $accessCodeRecord->access_code,
            'status' => $accessCodeRecord->status,
            'is_expired' => $isExpired,
            'used_at' => $accessCodeRecord->used_at
        ],
        'student' => [
            'id' => $student->id,
            'name' => $student->full_name,
            'phone' => $student->phone
        ],
        'exam' => [
            'id' => $exam->id,
            'title' => $exam->title,
            'status' => $examStatus,
            'is_active' => $isActive,
            'start_time' => $exam->start_time,
            'end_time' => $exam->end_time,
            'show_results_immediately' => $exam->show_results_immediately
        ],
        'results' => $results->map(function($result) {
            return [
                'id' => $result->id,
                'status' => $result->status,
                'score' => $result->score,
                'percentage' => $result->percentage,
                'started_at' => $result->started_at,
                'completed_at' => $result->completed_at
            ];
        }),
        'expected_behavior' => [
            'if_status_used' => 'Should redirect to results page',
            'if_status_active' => 'Should allow normal exam access',
            'if_expired' => 'Should show exam expired message',
            'if_exam_not_published' => 'Should show exam not available message'
        ],
        'test_urls' => [
            'access_page' => route('public.quiz.access'),
            'result_page' => route('public.quiz.result', $exam->id),
            'direct_result' => route('public.quiz.result.direct', $exam->id) . '?access_code_id=' . $accessCodeRecord->id
        ]
    ]);
});

// Bulk Upload Route (accessible without authentication)
Route::get('/upload-questions', [App\Http\Controllers\QuestionController::class, 'showBulkUploadForm'])->name('questions.bulk-upload.public');
Route::post('/upload-questions', [App\Http\Controllers\QuestionController::class, 'bulkUpload'])->name('questions.bulk-upload.public.store');

// Contact page route (accessible without authentication)
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

// Admin route to view contact messages (you can add authentication later)
Route::get('/admin/contact-messages', function () {
    $messages = \App\Models\ContactMessage::orderBy('created_at', 'desc')->get();
    return view('admin.contact-messages', compact('messages'));
})->name('admin.contact-messages');

// Test email route (remove in production)
Route::get('/test-email', function () {
    try {
        \Mail::raw('This is a test email from Bikolpo Live contact form system.', function ($message) {
            $message->to('bikolpo247@gmail.com')
                    ->subject('Test Email - Contact Form System');
        });
        
        return response()->json([
            'success' => true,
            'message' => 'Test email sent successfully! Check your inbox.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to send test email: ' . $e->getMessage()
        ]);
    }
});

// Test role detection (remove in production)
Route::get('/test-role', function () {
    if (!auth()->check()) {
        return response()->json(['error' => 'Not authenticated']);
    }
    
    $user = auth()->user();
    return response()->json([
        'user_id' => $user->id,
        'email' => $user->email,
        'role' => $user->role,
        'role_id' => $user->role_id,
        'should_redirect_to' => $user->role === 'system-admin' ? 'system-admin-dashboard' : 'other'
    ]);
});

// System Admin Routes
Route::middleware(['auth', 'system_admin'])->prefix('system-admin')->name('system-admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\SystemAdminController::class, 'dashboard'])->name('system-admin-dashboard');
    Route::get('/students', [App\Http\Controllers\Admin\SystemAdminController::class, 'allStudents'])->name('all-students');
    Route::get('/students/{id}', [App\Http\Controllers\Admin\SystemAdminController::class, 'singleStudent'])->name('single-student');
    Route::get('/students/{id}/interactive-grid', [App\Http\Controllers\Admin\SystemAdminController::class, 'singleStudent'])->name('single-student-ig');
    Route::get('/partners', [App\Http\Controllers\Admin\SystemAdminController::class, 'allPartners'])->name('all-partners');
    Route::get('/subscription-plans', [App\Http\Controllers\Admin\SystemAdminController::class, 'subscriptionPlans'])->name('subscription-plans');
    Route::get('/subscription-plans/create', [App\Http\Controllers\Admin\SystemAdminController::class, 'createSubscriptionPlan'])->name('subscription-plans.create');
    Route::post('/subscription-plans', [App\Http\Controllers\Admin\SystemAdminController::class, 'storeSubscriptionPlan'])->name('subscription-plans.store');
    Route::get('/subscription-plans/{id}/edit', [App\Http\Controllers\Admin\SystemAdminController::class, 'editSubscriptionPlan'])->name('subscription-plans.edit');
    Route::put('/subscription-plans/{id}', [App\Http\Controllers\Admin\SystemAdminController::class, 'updateSubscriptionPlan'])->name('subscription-plans.update');
    Route::delete('/subscription-plans/{id}', [App\Http\Controllers\Admin\SystemAdminController::class, 'deleteSubscriptionPlan'])->name('subscription-plans.delete');
    Route::get('/subscription-overview', [App\Http\Controllers\Admin\SystemAdminController::class, 'subscriptionOverview'])->name('subscription-overview');
    Route::get('/subscription-usage', [App\Http\Controllers\Admin\SystemAdminController::class, 'subscriptionUsage'])->name('subscription-usage');
    Route::get('/subscription-billing', [App\Http\Controllers\Admin\SystemAdminController::class, 'subscriptionBilling'])->name('subscription-billing');
    Route::get('/plan-features', [App\Http\Controllers\Admin\SystemAdminController::class, 'planFeatures'])->name('plan-features');
    Route::get('/plan-features/create', [App\Http\Controllers\Admin\SystemAdminController::class, 'createPlanFeature'])->name('plan-features.create');
    Route::get('/plan-features/{id}/edit', [App\Http\Controllers\Admin\SystemAdminController::class, 'editPlanFeature'])->name('plan-features.edit');
    Route::post('/plan-features', [App\Http\Controllers\Admin\SystemAdminController::class, 'storePlanFeature'])->name('plan-features.store');
    Route::put('/plan-features/{id}', [App\Http\Controllers\Admin\SystemAdminController::class, 'updatePlanFeature'])->name('plan-features.update');
    Route::delete('/plan-features/{id}', [App\Http\Controllers\Admin\SystemAdminController::class, 'deletePlanFeature'])->name('plan-features.delete');
    Route::get('/payment-methods', [App\Http\Controllers\Admin\SystemAdminController::class, 'paymentMethods'])->name('payment-methods');
    Route::get('/payment-methods/create', [App\Http\Controllers\Admin\SystemAdminController::class, 'createPaymentMethod'])->name('payment-methods.create');
    Route::get('/payment-methods/{id}/edit', [App\Http\Controllers\Admin\SystemAdminController::class, 'editPaymentMethod'])->name('payment-methods.edit');
    Route::post('/payment-methods', [App\Http\Controllers\Admin\SystemAdminController::class, 'storePaymentMethod'])->name('payment-methods.store');
    Route::put('/payment-methods/{id}', [App\Http\Controllers\Admin\SystemAdminController::class, 'updatePaymentMethod'])->name('payment-methods.update');
    Route::post('/payment-methods/{id}/toggle-status', [App\Http\Controllers\Admin\SystemAdminController::class, 'togglePaymentMethodStatus'])->name('payment-methods.toggle-status');
    Route::delete('/payment-methods/{id}', [App\Http\Controllers\Admin\SystemAdminController::class, 'deletePaymentMethod'])->name('payment-methods.delete');
    Route::get('/user-stats', [App\Http\Controllers\Admin\SystemAdminController::class, 'userStats'])->name('user-stats');
});

// About page route (accessible without authentication)
Route::get('/about', function () {
    return view('about');
})->name('about');

// Partner Features page route (accessible without authentication)
Route::get('/partner-features', function () {
    return view('partner-features');
})->name('partner.features');

// Student Features page route (accessible without authentication)
Route::get('/student-features', function () {
    return view('student-features');
})->name('student.features');

// Feature Gallery page route (accessible without authentication)
Route::get('/feature-gallery', function () {
    return view('feature-gallery');
})->name('feature.gallery');

// Privacy Policy page route (accessible without authentication)
Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

// Terms of Service page route (accessible without authentication)
Route::get('/terms', function () {
    return view('terms');
})->name('terms');

// Cookies Policy page route (accessible without authentication)
Route::get('/cookies', function () {
    return view('cookies');
})->name('cookies');

Route::middleware('auth')->group(function () {

    // Partner Area Access Route
    Route::get('/partner-area', function () {
        return redirect()->route('partner.dashboard');
    })->name('partner.area')->middleware(['auth', 'partner']);
    
    // Test analytics route outside partner middleware
    Route::get('/test-analytics-simple', function() {
        try {
            $totalQuestions = \App\Models\Question::count();
            $totalAttempts = \App\Models\QuestionStat::count();
            $totalCorrect = \App\Models\QuestionStat::where('is_correct', true)->count();
            $overallAccuracy = $totalAttempts > 0 ? round(($totalCorrect / $totalAttempts) * 100, 2) : 0;
            
            return "Simple Analytics Test:\n" .
                   "Total Questions: {$totalQuestions}\n" .
                   "Total Attempts: {$totalAttempts}\n" .
                   "Total Correct: {$totalCorrect}\n" .
                   "Overall Accuracy: {$overallAccuracy}%";
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    })->name('test.analytics.simple');
    
    // Test route to check middleware
    Route::get('/test-middleware', function() {
        $user = auth()->user();
        return response()->json([
            'user_id' => $user->id,
            'user_role' => $user->role,
            'user_role_id' => $user->role_id,
            'middleware_working' => true
        ]);
    })->name('test.middleware')->middleware(['auth', 'partner']);
    
    // Analytics routes outside partner middleware for testing
    Route::prefix('analytics')->name('analytics.')->group(function () {
        Route::get('/questions', [\App\Http\Controllers\QuestionAnalyticsController::class, 'index'])->name('questions.index');
        Route::get('/questions/{question}', [\App\Http\Controllers\QuestionAnalyticsController::class, 'show'])->name('questions.show');
        Route::get('/questions/{question}/export', [\App\Http\Controllers\QuestionAnalyticsController::class, 'exportQuestionAnalytics'])->name('questions.export');
        Route::get('/exams/{exam}', [\App\Http\Controllers\QuestionAnalyticsController::class, 'examAnalytics'])->name('exams.show');
        Route::get('/students/{student}', [\App\Http\Controllers\QuestionAnalyticsController::class, 'studentAnalytics'])->name('students.show');
        
        // API endpoints
        Route::get('/api/question-stats', [\App\Http\Controllers\QuestionAnalyticsController::class, 'getQuestionStats'])->name('api.question-stats');
        Route::get('/api/exam-stats', [\App\Http\Controllers\QuestionAnalyticsController::class, 'getExamStats'])->name('api.exam-stats');
        Route::get('/api/students/{student}/exam-results/{examResult}', [\App\Http\Controllers\QuestionAnalyticsController::class, 'getExamResultDetails'])->name('api.student.exam-result-details');
    });

    // Student Area Access Route
    Route::get('/student-area', function () {
        return redirect()->route('student.dashboard');
    })->name('student.area');

// Partner Routes (Coaching Center)
Route::prefix('partner')->name('partner.')->middleware(['auth', 'partner'])->group(function () {
// Permission management removed
        Route::get('/', [PartnerDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [PartnerDashboardController::class, 'index'])->name('dashboard.main');
        
        // Partner Management
        
        // Course Management
        Route::resource('courses', CourseController::class);
        
        // Subject Management
        Route::resource('subjects', SubjectController::class)->except(['show']);
        
        // Topic Management
        Route::resource('topics', TopicController::class)->except(['show']);
        
        // Batch Management
        Route::resource('batches', \App\Http\Controllers\BatchController::class)->except(['show']);
        Route::get('batches/trashed', [\App\Http\Controllers\BatchController::class, 'trashed'])->name('batches.trashed');
        Route::post('batches/{id}/restore', [\App\Http\Controllers\BatchController::class, 'restore'])->name('batches.restore');
        
        // Teacher Management
        Route::resource('teachers', \App\Http\Controllers\TeacherController::class)->parameters([
            'teachers' => 'teacher'
        ]);
        Route::get('teachers/trashed', [\App\Http\Controllers\TeacherController::class, 'trashed'])->name('teachers.trashed');
        Route::post('teachers/{id}/restore', [\App\Http\Controllers\TeacherController::class, 'restore'])->name('teachers.restore');
        Route::delete('teachers/{id}/force-delete', [\App\Http\Controllers\TeacherController::class, 'forceDelete'])->name('teachers.force-delete');
        
        // Question Management - Main Questions Dashboard (must come first)
        Route::get('questions', [QuestionController::class, 'allQuestions'])->name('questions.index');
        Route::get('questions/all', [QuestionController::class, 'allQuestions'])->name('questions.all');
        Route::get('questions/list', [QuestionController::class, 'index'])->name('questions.list');
        Route::get('questions/subjects-for-course', [QuestionController::class, 'getSubjectsForCourse'])->name('questions.subjects-for-course');
        Route::get('questions/courses-for-filter', [QuestionController::class, 'getCoursesForFilter'])->name('questions.courses-for-filter');
        Route::get('questions/subjects-for-filter', [QuestionController::class, 'getSubjectsForFilter'])->name('questions.subjects-for-filter');
        Route::get('questions/topics-for-filter', [QuestionController::class, 'getTopicsForFilter'])->name('questions.topics-for-filter');
        Route::get('questions/question-types-for-filter', [QuestionController::class, 'getQuestionTypesForFilter'])->name('questions.question-types-for-filter');
        Route::get('questions/available-dates', [QuestionController::class, 'getAvailableDates'])->name('questions.available-dates');
        
        Route::get('questions/create', [QuestionController::class, 'create'])->name('questions.create');
        Route::post('questions', [QuestionController::class, 'store'])->name('questions.store');
        
        // Bulk Upload Routes (must come BEFORE the {question} route to avoid conflicts)
        Route::get('questions/bulk-upload', [QuestionController::class, 'showBulkUploadForm'])->name('questions.bulk-upload');
        Route::post('questions/bulk-upload', [QuestionController::class, 'bulkUpload'])->name('questions.bulk-upload.store');
        
        // Draft Management Routes
        Route::get('questions/drafts', [QuestionController::class, 'showDrafts'])->name('questions.drafts');
        Route::post('questions/drafts/update', [QuestionController::class, 'updateDrafts'])->name('questions.drafts.update');
        Route::post('questions/drafts/delete', [QuestionController::class, 'deleteDrafts'])->name('questions.drafts.delete');
        
        // Questions API for step 2
        Route::get('questions/api', [QuestionController::class, 'apiIndex'])->name('questions.api');
        
        // Test route for debugging
        Route::get('questions/test', function() {
            return response()->json([
                'message' => 'API test route working',
                'timestamp' => now(),
                'questions_count' => \App\Models\Question::where('status', 'active')->count()
            ]);
        })->name('questions.test');
        
        Route::post('questions/check-duplicate', [QuestionController::class, 'checkDuplicate'])->name('questions.check-duplicate');
        // Dependent dropdowns for Question create
        Route::get('questions/subjects', [QuestionController::class, 'getSubjects'])->name('questions.subjects');
        Route::get('questions/topics', [QuestionController::class, 'getTopics'])->name('questions.topics');
        
        // Common question view route (must come BEFORE individual question routes)
        Route::get('questions/{question}/view', [QuestionController::class, 'commonView'])->name('questions.common-view');
        
        // Individual question routes (must come AFTER specific routes to avoid conflicts)
        Route::get('questions/{question}', [QuestionController::class, 'show'])->name('questions.show');
        Route::get('questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
        Route::put('questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
        Route::delete('questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');

        // Question Types - MCQ, Descriptive
        Route::prefix('questions/mcq')->name('questions.mcq.')->group(function () {
            Route::get('/', [QuestionController::class, 'mcqAllQuestionView'])->name('all-question-view');
            Route::get('/create', [QuestionController::class, 'mcqCreate'])->name('create');
            Route::post('/', [QuestionController::class, 'mcqStore'])->name('store');
            Route::post('/generate-samples', [QuestionController::class, 'generateSampleMcqs'])->name('generate-samples');
            Route::get('/view', function() {
                return view('partner.questions.mcq.mcqview');
            })->name('view');
            Route::get('/{question}', [QuestionController::class, 'mcqShow'])->name('show');
            Route::get('/{question}/edit', [QuestionController::class, 'mcqEdit'])->name('edit');
            Route::put('/{question}', [QuestionController::class, 'mcqUpdate'])->name('update');
            Route::delete('/{question}', [QuestionController::class, 'mcqDestroy'])->name('destroy');
        });
        
        Route::prefix('questions/descriptive')->name('questions.descriptive.')->group(function () {
            Route::get('/', [QuestionController::class, 'descriptiveIndex'])->name('index');
            Route::get('/create', [QuestionController::class, 'descriptiveCreate'])->name('create');
            Route::post('/', [QuestionController::class, 'descriptiveStore'])->name('store');
            Route::get('/{question}/edit', [QuestionController::class, 'descriptiveEdit'])->name('edit');
            Route::put('/{question}', [QuestionController::class, 'descriptiveUpdate'])->name('update');
            Route::delete('/{question}', [QuestionController::class, 'descriptiveDestroy'])->name('destroy');
        });
        
        // True/False Questions Routes
        Route::prefix('questions/tf')->name('questions.tf.')->group(function () {
            Route::get('/', [QuestionController::class, 'tfIndex'])->name('index');
            Route::get('/create', [QuestionController::class, 'tfCreate'])->name('create');
            Route::post('/', [QuestionController::class, 'tfStore'])->name('store');
            Route::get('/{question}/edit', [QuestionController::class, 'tfEdit'])->name('edit');
            Route::put('/{question}', [QuestionController::class, 'tfUpdate'])->name('update');
            Route::delete('/{question}', [QuestionController::class, 'tfDestroy'])->name('destroy');
        });
        

        
        // Question History Management
        Route::resource('question-history', \App\Http\Controllers\QuestionHistoryController::class);
        Route::get('question-history/statistics', [\App\Http\Controllers\QuestionHistoryController::class, 'statistics'])->name('question-history.statistics');
        Route::post('question-history/bulk-verify', [\App\Http\Controllers\QuestionHistoryController::class, 'bulkVerify'])->name('question-history.bulk-verify');
        
        // Exam Management
        Route::resource('exams', ExamController::class);
        Route::post('exams/{exam}/publish', [ExamController::class, 'publish'])->name('exams.publish');
        Route::post('exams/{exam}/unpublish', [ExamController::class, 'unpublish'])->name('exams.unpublish');
        Route::get('exams/{exam}/debug', [ExamController::class, 'debug'])->name('exams.debug');
        Route::get('exams/deleted', [ExamController::class, 'deleted'])->name('exams.deleted');
        Route::post('exams/{exam}/restore', [ExamController::class, 'restore'])->name('exams.restore');
        Route::get('exams/{exam}/results', [ExamController::class, 'results'])->name('exams.results');
        Route::get('exams/{exam}/results/{result}/details', [ExamController::class, 'getResultDetails'])->name('exams.results.details');
        Route::post('exams/{exam}/results', [ExamController::class, 'storeResult'])->name('exams.results.store');
        Route::get('exams/{exam}/result-entry', [ExamController::class, 'resultEntry'])->name('exams.result-entry');
        Route::post('exams/{exam}/result-entry', [ExamController::class, 'storeDetailedResult'])->name('exams.result-entry.store');
        Route::get('exams/{exam}/results/{result}/edit', [ExamController::class, 'editResult'])->name('exams.result-edit');
        Route::put('exams/{exam}/results/{result}', [ExamController::class, 'updateResult'])->name('exams.result-update');
        Route::get('exams/{exam}/export', [ExamController::class, 'export'])->name('exams.export');
        Route::get('exams/{exam}/paper-parameters', [ExamController::class, 'paperParameters'])->name('exams.paper-parameters');
        Route::post('exams/{exam}/save-paper-settings', [ExamController::class, 'savePaperSettings'])->name('exams.save-paper-settings');
        Route::post('exams/{exam}/download-paper', [ExamController::class, 'downloadPaper'])->name('exams.download-paper');
        Route::post('exams/{exam}/print-paper-preview', [ExamController::class, 'printPaperPreview'])->name('exams.print-paper-preview');
        Route::get('exams/{exam}/test-pdf', [ExamController::class, 'testPDFGeneration'])->name('exams.test-pdf');
        Route::get('test-pdf-simple', [ExamController::class, 'simplePDFTest'])->name('test-pdf-simple');
        Route::get('exams/{exam}/assign-questions', [ExamController::class, 'assignQuestions'])->name('exams.assign-questions');
        Route::post('exams/{exam}/assign-questions', [ExamController::class, 'storeAssignedQuestions'])->name('exams.store-assigned-questions');
        
        // Public Quiz Management
        Route::get('exams/{exam}/assign', [\App\Http\Controllers\ExamAssignmentController::class, 'index'])->name('exams.assign');
        Route::post('exams/{exam}/assign', [\App\Http\Controllers\ExamAssignmentController::class, 'assignStudents'])->name('exams.assign-students');
        Route::delete('exams/{exam}/assign', [\App\Http\Controllers\ExamAssignmentController::class, 'removeAssignment'])->name('exams.remove-assignment');
        Route::post('exams/{exam}/regenerate-code', [\App\Http\Controllers\ExamAssignmentController::class, 'regenerateCode'])->name('exams.regenerate-code');
        Route::post('exams/{exam}/bulk-operations', [\App\Http\Controllers\ExamAssignmentController::class, 'bulkOperations'])->name('exams.bulk-operations');
        Route::get('exams/{exam}/export-assignments', [\App\Http\Controllers\ExamAssignmentController::class, 'exportAssignments'])->name('exams.export-assignments');
        
        
        // Student Management - Handled in partner_students.php
        // Route::resource('students', StudentController::class); // REMOVED: Duplicate routes with partner_students.php
        
        // Student Migration Management
        Route::prefix('students')->name('students.')->group(function () {
            Route::get('{student}/migrate', [\App\Http\Controllers\StudentMigrationController::class, 'showMigrationForm'])->name('migrate');
            Route::post('{student}/migrate', [\App\Http\Controllers\StudentMigrationController::class, 'migrateStudent'])->name('migrate.process');
            Route::get('{student}/migration-history', [\App\Http\Controllers\StudentMigrationController::class, 'getMigrationHistory'])->name('migration.history');
            Route::get('migrations/pending', [\App\Http\Controllers\StudentMigrationController::class, 'getPendingMigrations'])->name('migrations.pending');
        });
        
        // Course/Batch Migration Statistics
        Route::prefix('migrations')->name('migrations.')->group(function () {
            Route::get('courses/{course}/stats', [\App\Http\Controllers\StudentMigrationController::class, 'getCourseMigrationStats'])->name('course.stats');
            Route::get('batches/{batch}/stats', [\App\Http\Controllers\StudentMigrationController::class, 'getBatchMigrationStats'])->name('batch.stats');
        });
        
        // Partner Profile Management
        Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show-partnar');
        Route::get('profile/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit-partnar');
        Route::patch('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'updatePartner'])->name('profile.updatePartner');
        
        // AJAX routes for cascading dropdowns
        Route::get('divisions/{division}/districts', [\App\Http\Controllers\ProfileController::class, 'getDistrictsByDivision'])->name('divisions.districts');
        Route::get('districts/{district}/upazilas', [\App\Http\Controllers\ProfileController::class, 'getUpazilasByDistrict'])->name('districts.upazilas');
        Route::put('profile/partner', [\App\Http\Controllers\ProfileController::class, 'updatePartner'])->name('profile.updatePartner.alt');
        Route::put('profile/update-partner-details', [PartnerController::class, 'updateProfile'])->name('profile.update-details');
        
        // User Profile Management
        Route::get('profile/user', [\App\Http\Controllers\ProfileController::class, 'showUser'])->name('profile.show-user-profile');
        Route::get('profile/user/edit', [\App\Http\Controllers\ProfileController::class, 'editUser'])->name('profile.edit-user-profile');
        Route::put('profile/user', [\App\Http\Controllers\ProfileController::class, 'updateUser'])->name('profile.update-user');
        
        // Partner Settings
        Route::get('settings', [\App\Http\Controllers\Partner\PartnerSettingsController::class, 'index'])->name('settings.index');
        
        
        // Test Settings Route
        Route::get('test-settings', function () {
            try {
                $user = auth()->user();
                $partner = null;
                
                if ($user && $user->partner_id) {
                    $partner = \App\Models\Partner::find($user->partner_id);
                }
                
                if (!$partner) {
                    return redirect()->route('partner.dashboard')->with('error', 'Partner profile not found. Please complete your profile first.');
                }
                
                return view('partner.settings.test-settings', compact('partner'));
            } catch (\Exception $e) {
                \Log::error('Error in test settings route: ' . $e->getMessage());
                return redirect()->route('partner.dashboard')->with('error', 'An error occurred while loading test settings.');
            }
        })->name('test-settings.index');
        
        // Equation Tutorial Route
        Route::get('settings/equation-tutorial', function () {
            return view('partner.settings.equation-tutorial');
        })->name('settings.equation-tutorial');
        
        // Test route to verify user filtering
        Route::get('test-user-filter', function () {
            try {
                // Get the authenticated user with partner relationship
                $user = auth()->user();
                if (!$user) {
                    return response()->json(['error' => 'User not authenticated']);
                }
                
                // Check if user has a partner relationship
                if (!$user->partner) {
                    return response()->json(['error' => 'Please complete your partner profile first.']);
                }
                
                // Get the partner record
                $partner = $user->partner;
                
                // Get users from current partner only
                $partnerUsers = \App\Models\EnhancedUser::where('partner_id', $partner->id)
                    ->with(['role'])
                    ->orderByDesc('created_at')
                    ->limit(10)
                    ->get();
                
                // Get the partner owner user
                $partnerOwner = \App\Models\EnhancedUser::where('id', $partner->user_id)->first();
                
                // Combine results
                $users = collect();
                if ($partnerOwner) {
                    $users->push($partnerOwner);
                }
                $users = $users->merge($partnerUsers);
                
                return response()->json([
                    'success' => true,
                    'partner_id' => $partner->id,
                    'partner_name' => $partner->name,
                    'total_users' => $users->count(),
                    'users' => $users->map(function ($u) {
                        return [
                            'id' => $u->id,
                            'name' => $u->name,
                            'email' => $u->email,
                            'partner_id' => $u->partner_id,
                            'role' => $u->getRoleDisplayName(),
                            'is_partner_owner' => $u->id == $u->partner->user_id
                        ];
                    })
                ]);
            } catch (\Exception $e) {
                \Log::error('Error in test user filter route: ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred: ' . $e->getMessage()]);
            }
        })->name('test-user-filter');
        
        // Test route to verify partner-specific user filtering
        Route::get('test-partner-users', function () {
            try {
                // Get authenticated user
                $user = auth()->user();
                if (!$user) {
                    return response()->json(['error' => 'Not authenticated']);
                }
                
                // Get partner
                $partner = $user->partner;
                if (!$partner) {
                    return response()->json(['error' => 'No partner associated with user']);
                }
                
                // Get users that belong to this partner only
                $partnerUsers = \App\Models\EnhancedUser::where('partner_id', $partner->id)
                    ->with(['role'])
                    ->get();
                
                // Get the partner owner user
                $partnerOwner = \App\Models\EnhancedUser::where('id', $partner->user_id)->first();
                
                return response()->json([
                    'current_user_id' => $user->id,
                    'partner_id' => $partner->id,
                    'partner_name' => $partner->name,
                    'partner_owner' => $partnerOwner ? [
                        'id' => $partnerOwner->id,
                        'name' => $partnerOwner->name,
                        'email' => $partnerOwner->email
                    ] : null,
                    'partner_users_count' => $partnerUsers->count(),
                    'partner_users' => $partnerUsers->map(function ($u) {
                        return [
                            'id' => $u->id,
                            'name' => $u->name,
                            'email' => $u->email,
                            'partner_id' => $u->partner_id,
                            'role_id' => $u->role_id,
                            'role' => $u->role ? [
                                'id' => $u->role->id,
                                'name' => $u->role->name,
                                'display_name' => $u->role->display_name,
                                'level' => $u->role->level
                            ] : null,
                            'role_name_via_method' => $u->getRoleName(),
                            'role_display_name_via_method' => $u->getRoleDisplayName()
                        ];
                    })
                ]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()]);
            }
        })->name('test.partner.users');
        
        // Debug route to check users for partner settings
        Route::get('debug-partner-settings', function () {
            try {
                // Get the authenticated user with partner relationship
                $user = auth()->user();
                if (!$user) {
                    return response()->json(['error' => 'User not authenticated']);
                }
                
                // Check if user has a partner relationship
                if (!$user->partner) {
                    return response()->json(['error' => 'Please complete your partner profile first.']);
                }
                
                // Get the partner record with relationships
                $partner = $user->partner;
                
                // Get recent users
                $users = \App\Models\EnhancedUser::where('partner_id', $partner->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
                
                // Debug information for each user
                $debugUsers = [];
                foreach ($users as $u) {
                    // Try different ways to load the role
                    $roleViaRelationship = $u->role;
                    $roleViaMethod = null;
                    $roleViaDirectQuery = null;
                    
                    if ($u->role_id) {
                        $roleViaMethod = $u->getRoleDisplayName();
                        $roleViaDirectQuery = \App\Models\EnhancedRole::find($u->role_id);
                    }
                    
                    $debugUsers[] = [
                        'id' => $u->id,
                        'name' => $u->name,
                        'email' => $u->email,
                        'role_id' => $u->role_id,
                        'role_via_relationship' => $roleViaRelationship ? [
                            'id' => $roleViaRelationship->id,
                            'name' => $roleViaRelationship->name,
                            'display_name' => $roleViaRelationship->display_name
                        ] : null,
                        'role_via_method' => $roleViaMethod,
                        'role_via_direct_query' => $roleViaDirectQuery ? [
                            'id' => $roleViaDirectQuery->id,
                            'name' => $roleViaDirectQuery->name,
                            'display_name' => $roleViaDirectQuery->display_name
                        ] : null,
                        'is_role_object' => $u->role && is_object($u->role),
                    ];
                }
                
                return response()->json([
                    'partner_id' => $partner->id,
                    'partner_name' => $partner->name,
                    'users_count' => $users->count(),
                    'users' => $debugUsers
                ]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()]);
            }
        })->name('debug.partner.settings');
        
        // Backup & Restore Routes
        Route::get('backup-restore', [App\Http\Controllers\Partner\BackupRestoreController::class, 'index'])->name('settings.backup-restore');
        Route::post('backup/database', [App\Http\Controllers\Partner\BackupRestoreController::class, 'createDatabaseBackup'])->name('settings.backup.database');
        Route::post('backup/config', [App\Http\Controllers\Partner\BackupRestoreController::class, 'createConfigBackup'])->name('settings.backup.config');
        Route::post('backup/uploads', [App\Http\Controllers\Partner\BackupRestoreController::class, 'createUploadsBackup'])->name('settings.backup.uploads');
        Route::post('restore/database', [App\Http\Controllers\Partner\BackupRestoreController::class, 'restoreDatabase'])->name('settings.restore.database');
        Route::get('backup/history', [App\Http\Controllers\Partner\BackupRestoreController::class, 'getBackupHistory'])->name('settings.backup.history');
        Route::get('backup/download/{filename}', [App\Http\Controllers\Partner\BackupRestoreController::class, 'downloadBackup'])->name('settings.backup.download');
        Route::delete('backup/delete', [App\Http\Controllers\Partner\BackupRestoreController::class, 'deleteBackup'])->name('settings.backup.delete');
        
        // Demo Data Seeding
        Route::post('seed-demo-students', [\App\Http\Controllers\PartnerDashboardController::class, 'seedDemoStudents'])->name('seed-demo-students');
        Route::get('refresh-stats', [\App\Http\Controllers\PartnerDashboardController::class, 'refreshStats'])->name('refresh-stats');
        Route::get('student-count', [\App\Http\Controllers\PartnerDashboardController::class, 'getStudentCount'])->name('student-count');
        
        // MCQ Question Seeding
        Route::post('seed-mcq-questions', [\App\Http\Controllers\QuestionController::class, 'seedMcqQuestions'])->name('seed-mcq-questions');
        Route::get('check-session', [\App\Http\Controllers\QuestionController::class, 'checkSession'])->name('check-session');
        
        // Permission Management removed
        
        
        // User Management Routes
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('user-management', [\App\Http\Controllers\UserManagementController::class, 'index'])->name('user-management');
            Route::get('users', [\App\Http\Controllers\UserManagementController::class, 'index'])->name('users.index');
            Route::get('users/create', [\App\Http\Controllers\UserManagementController::class, 'create'])->name('users.create');
            Route::post('users', [\App\Http\Controllers\UserManagementController::class, 'store'])->name('users.store');
            Route::post('users', [\App\Http\Controllers\UserManagementController::class, 'store'])->name('users.store');
            Route::get('users/{user}', [\App\Http\Controllers\UserManagementController::class, 'show'])->name('users.show');
            Route::put('users/{user}', [\App\Http\Controllers\UserManagementController::class, 'update'])->name('users.update');
            Route::put('users/{user}/status', [\App\Http\Controllers\UserManagementController::class, 'updateStatus'])->name('users.update-status');
            Route::post('users/{user}/reset-password', [\App\Http\Controllers\UserManagementController::class, 'resetPassword'])->name('users.reset-password');
            Route::delete('users/{user}', [\App\Http\Controllers\UserManagementController::class, 'destroy'])->name('users.destroy');
            
            // Test route for debugging user status update
            Route::get('test-user-status/{user}', function(\App\Models\EnhancedUser $user) {
                try {
                    $controller = new \App\Http\Controllers\UserManagementController();
                    $partnerId = $controller->getPartnerId();
                    
                    return response()->json([
                        'success' => true,
                        'user_id' => $user->id,
                        'user_partner_id' => $user->partner_id,
                        'current_partner_id' => $partnerId,
                        'user_belongs_to_partner' => $user->partner_id == $partnerId,
                        'user_status' => $user->status,
                        'valid_statuses' => \App\Models\EnhancedUser::getStatuses()
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'success' => false,
                        'error' => $e->getMessage()
                    ], 500);
                }
            })->name('test.user-status');

            // Test user management route
            Route::get('test-user-management', function() {
                try {
                    $users = \App\Models\EnhancedUser::with(['role'])->take(5)->get();
                    $result = [];
                            
                    foreach ($users as $user) {
                        $result[] = [
                            'user_id' => $user->id,
                            'user_name' => $user->name,
                            'role_id' => $user->role_id,
                            'role_loaded' => $user->relationLoaded('role'),
                            'role_is_object' => is_object($user->role),
                            'role_name' => $user->role && is_object($user->role) ? $user->role->name : null,
                            'role_display_name' => $user->role && is_object($user->role) ? $user->role->display_name : null
                        ];
                    }
                            
                    return response()->json([
                        'success' => true,
                        'users' => $result
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'success' => false,
                        'error' => $e->getMessage()
                    ], 500);
                }
            })->name('test.user-management');
            
            // Test route to check available students for user creation
            Route::get('test-available-students', function () {
                try {
                    // Get authenticated user
                    $user = auth()->user();
                    if (!$user) {
                        return response()->json(['error' => 'Not authenticated']);
                    }
                    
                    // Get partner
                    $partner = $user->partner;
                    if (!$partner) {
                        return response()->json(['error' => 'No partner associated with user']);
                    }
                    
                    // Get students from current partner who don't have user accounts yet
                    $students = \App\Models\Student::where('partner_id', $partner->id)
                        ->whereNull('user_id') // Only students without user accounts
                        ->orderBy('full_name')
                        ->get();
                    
                    // Get students who already have user accounts
                    $studentsWithAccounts = \App\Models\Student::where('partner_id', $partner->id)
                        ->whereNotNull('user_id') // Students with user accounts
                        ->with('user')
                        ->orderBy('full_name')
                        ->get();
                    
                    return response()->json([
                        'partner_id' => $partner->id,
                        'partner_name' => $partner->name,
                        'students_without_accounts_count' => $students->count(),
                        'students_with_accounts_count' => $studentsWithAccounts->count(),
                        'students_without_accounts' => $students->map(function ($student) {
                            return [
                                'id' => $student->id,
                                'full_name' => $student->full_name,
                                'email' => $student->email,
                                'phone' => $student->phone
                            ];
                        }),
                        'students_with_accounts' => $studentsWithAccounts->map(function ($student) {
                            return [
                                'id' => $student->id,
                                'full_name' => $student->full_name,
                                'email' => $student->email,
                                'phone' => $student->phone,
                                'user_id' => $student->user_id,
                                'user_email' => $student->user ? $student->user->email : 'N/A'
                            ];
                        })
                    ]);
                } catch (\Exception $e) {
                    return response()->json(['error' => $e->getMessage()]);
                }
            })->name('test.available.students');
            
            // Test route to check students with user accounts
            Route::get('test-student-users', function () {
                try {
                    // Get authenticated user
                    $user = auth()->user();
                    if (!$user) {
                        return response()->json(['error' => 'Not authenticated']);
                    }
                    
                    // Get partner
                    $partner = $user->partner;
                    if (!$partner) {
                        return response()->json(['error' => 'No partner associated with user']);
                    }
                    
                    // Get students from current partner who don't have user accounts yet
                    $students = \App\Models\Student::where('partner_id', $partner->id)
                        ->whereDoesntHave('user')
                        ->with('user')
                        ->orderBy('full_name')
                        ->get();
                    
                    $debugInfo = [
                        'partner_id' => $partner->id,
                        'partner_name' => $partner->name,
                        'students_count' => $students->count(),
                        'students' => []
                    ];
                    
                    foreach ($students as $student) {
                        $debugInfo['students'][] = [
                            'id' => $student->id,
                            'full_name' => $student->full_name,
                            'user_id' => $student->user_id,
                            'user_exists' => $student->user ? true : false,
                            'user_data' => $student->user ? [
                                'id' => $student->user->id,
                                'name' => $student->user->name,
                                'email' => $student->user->email,
                                'flag' => $student->user->flag
                            ] : null
                        ];
                    }
                    
                    return response()->json($debugInfo);
                } catch (\Exception $e) {
                    return response()->json(['error' => $e->getMessage()]);
                }
            })->name('test.student.users');
        });

        // Access Control Routes - Disabled
        // Role and permission management completely removed
        
        // Analytics routes moved outside partner middleware for better access
    });

    



    // Student Routes
Route::prefix('student')->name('student.')->middleware(['auth'])->group(function () {
        Route::get('/', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard.main');
        
        // Student Profile - Custom routes for own profile
        Route::get('/profile', [StudentController::class, 'showProfile'])->name('profile.show');
        Route::get('/profile/edit', [StudentController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile', [StudentController::class, 'updateProfile'])->name('profile.update');
        
        // My Syllabus
        Route::get('/syllabus', [StudentDashboardController::class, 'syllabus'])->name('syllabus');
        Route::post('/syllabus/topic-progress', [StudentDashboardController::class, 'updateTopicProgress'])->name('syllabus.update-topic-progress');
        Route::post('/syllabus/multiple-topic-progress', [StudentDashboardController::class, 'updateMultipleTopicProgress'])->name('syllabus.update-multiple-topic-progress');
        
        // My Analytics
        Route::get('/analytics', [StudentDashboardController::class, 'analytics'])->name('analytics');
        
        // Available Exams (show Expired message)
        Route::get('exams', function() {
            return 'Expired';
        })->name('exams.available');
        Route::get('exams/{exam}', [StudentExamController::class, 'showExam'])->name('exams.show');
        
        // My Exams
        Route::get('my-exams', [StudentExamController::class, 'myExams'])->name('exams.my-exams');
        
        // Take Exam
        Route::get('exams/{exam}/start', [StudentExamController::class, 'startExam'])->name('exams.start');
        Route::get('exams/{exam}/take', [StudentExamController::class, 'takeExam'])->name('exams.take');
        Route::post('exams/{exam}/submit', [StudentExamController::class, 'submitExam'])->name('exams.submit');
        Route::get('exams/{exam}/result', [StudentExamController::class, 'showResult'])->name('exams.result');
        
        // Exam History
        Route::get('history', [StudentExamController::class, 'history'])->name('exams.history');
    });



    // Typing Test Routes
    Route::get('/typing-test', function () {
        return view('TypingTest.index');
    })->name('typing.test');
            
    Route::get('/typing-tutorial', function () {
        return view('TypingTest.tutorial');
    })->name('typing.tutorial');

    Route::get('/typing-speed-test', function () {
        return view('TypingTest.typing-test');
    })->name('typing.speed-test');

    // Typing Passage Management Routes
    Route::resource('typing-passages', \App\Http\Controllers\TypingPassageController::class);
    Route::get('/typing-passages/get/{language?}/{difficulty?}', [\App\Http\Controllers\TypingPassageController::class, 'getPassages'])->name('typing-passages.get');
    Route::post('/typing-passages/{typingPassage}/stats', [\App\Http\Controllers\TypingPassageController::class, 'updateStats'])->name('typing-passages.stats');
    Route::patch('/typing-passages/{typingPassage}/toggle', [\App\Http\Controllers\TypingPassageController::class, 'toggleStatus'])->name('typing-passages.toggle');
    
    // Font Test Route
    Route::get('/font-test', function () {
        return view('font-test');
    })->name('font.test');

});

// Public Quiz Routes (No Authentication Required)
Route::prefix('LiveExam')->name('public.quiz.')->group(function () {
    Route::get('/', [\App\Http\Controllers\PublicQuizController::class, 'showAccessPage'])->name('access');
    Route::post('/access', [\App\Http\Controllers\PublicQuizController::class, 'processAccess'])->middleware('refresh.csrf')->name('process-access');
    
    // Debug route for CSRF token
    Route::get('/debug-csrf', function() {
        return response()->json([
            'csrf_token' => csrf_token(),
            'session_id' => session()->getId(),
            'session_lifetime' => config('session.lifetime')
        ]);
    })->name('debug-csrf');
    Route::post('/multiple-exams', [\App\Http\Controllers\PublicQuizController::class, 'handleMultipleExams'])->name('multiple-exams');
    Route::get('/available', [\App\Http\Controllers\PublicQuizController::class, 'showAvailableExams'])->name('available');
    Route::get('/select/{accessCode}', [\App\Http\Controllers\PublicQuizController::class, 'selectExam'])->name('select');
    Route::get('/{exam}/start', [\App\Http\Controllers\PublicQuizController::class, 'showQuiz'])->name('start');
    Route::post('/{exam}/start', [\App\Http\Controllers\PublicQuizController::class, 'startQuiz'])->name('start-quiz');
    Route::get('/{exam}/take', [\App\Http\Controllers\PublicQuizController::class, 'takeQuiz'])->name('take');
    Route::post('/{exam}/submit', [\App\Http\Controllers\PublicQuizController::class, 'submitQuiz'])->name('submit');
    Route::get('/{exam}/result', [\App\Http\Controllers\PublicQuizController::class, 'showResult'])->name('result');
    Route::get('/{exam}/result/direct', [\App\Http\Controllers\PublicQuizController::class, 'directResultAccess'])->name('result.direct');
    Route::get('/{exam}/review/{result}', [\App\Http\Controllers\ExamReviewController::class, 'showReview'])->name('review');
    
});

// API Routes for Public Quiz (No Authentication Required)
Route::prefix('api/exam')->group(function () {
    Route::get('/{exam}/waiting-students', [\App\Http\Controllers\PublicQuizController::class, 'getWaitingStudentsApi'])->name('api.exam.waiting-students');
});

// API Routes for Analytics and Review
Route::prefix('api')->group(function () {
    // Analytics routes
    Route::get('/analytics/question/{questionId}', [\App\Http\Controllers\AnalyticsController::class, 'getQuestionAnalytics'])->name('api.analytics.question');
    Route::get('/analytics/student/{studentId}', [\App\Http\Controllers\AnalyticsController::class, 'getStudentAnalytics'])->name('api.analytics.student');
    Route::get('/analytics/exam/{examId}', [\App\Http\Controllers\AnalyticsController::class, 'getExamAnalytics'])->name('api.analytics.exam');
    Route::get('/analytics/student/{studentId}/exam/{examId}', [\App\Http\Controllers\AnalyticsController::class, 'getStudentExamPerformance'])->name('api.analytics.student-exam');
    Route::get('/analytics/difficulty', [\App\Http\Controllers\AnalyticsController::class, 'getDifficultyAnalytics'])->name('api.analytics.difficulty');
    Route::get('/analytics/question-types', [\App\Http\Controllers\AnalyticsController::class, 'getQuestionTypeAnalytics'])->name('api.analytics.question-types');
    Route::get('/analytics/top-students', [\App\Http\Controllers\AnalyticsController::class, 'getTopPerformingStudents'])->name('api.analytics.top-students');
    Route::get('/analytics/difficult-questions', [\App\Http\Controllers\AnalyticsController::class, 'getMostDifficultQuestions'])->name('api.analytics.difficult-questions');
    Route::get('/analytics/answer-distribution/{questionId}', [\App\Http\Controllers\AnalyticsController::class, 'getAnswerDistribution'])->name('api.analytics.answer-distribution');
    Route::get('/analytics/correct-students/{questionId}', [\App\Http\Controllers\AnalyticsController::class, 'getStudentsWhoAnsweredCorrectly'])->name('api.analytics.correct-students');
    Route::get('/analytics/incorrect-students/{questionId}', [\App\Http\Controllers\AnalyticsController::class, 'getStudentsWhoAnsweredIncorrectly'])->name('api.analytics.incorrect-students');
    
    // Review routes
    Route::get('/exam-review/{examId}/{resultId}/data', [\App\Http\Controllers\ExamReviewController::class, 'getReviewData'])->name('api.exam-review.data');
    Route::get('/exam-review/{examId}/{resultId}/question/{questionId}', [\App\Http\Controllers\ExamReviewController::class, 'getQuestionReview'])->name('api.exam-review.question');
    Route::get('/exam-review/{examId}/{resultId}/comparison', [\App\Http\Controllers\ExamReviewController::class, 'getPerformanceComparison'])->name('api.exam-review.comparison');
    Route::get('/exam-review/{examId}/{resultId}/analytics', [\App\Http\Controllers\ExamReviewController::class, 'getExamAnalytics'])->name('api.exam-review.analytics');
    Route::get('/exam-review/{examId}/{resultId}/suggestions', [\App\Http\Controllers\ExamReviewController::class, 'getImprovementSuggestions'])->name('api.exam-review.suggestions');
    
    // Role and permission API routes - All disabled
Route::middleware(['auth'])->group(function () {
        
        // User Management API routes
        Route::get('/users', [\App\Http\Controllers\UserManagementController::class, 'getUsers'])->name('api.users.index');
        Route::get('/users/{id}', [\App\Http\Controllers\UserManagementController::class, 'getUser'])->name('api.users.show');
        // Route removed: Route::get('/users/{id}/activities', [\App\Http\Controllers\UserManagementController::class, 'getActivities'])->name('api.users.activities');
        // Permission route removed
        Route::get('/users/export', [\App\Http\Controllers\UserManagementController::class, 'export'])->name('api.users.export');
        Route::get('/users/statistics', [\App\Http\Controllers\UserManagementController::class, 'getStatistics'])->name('api.users.statistics');
        // Permission route removed
        Route::get('/users/recent-activity', [\App\Http\Controllers\UserManagementController::class, 'getRecentActivity'])->name('api.users.recent-activity');
    });
});

// Direct image serving routes
require __DIR__.'/serve_images.php';
