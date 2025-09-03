<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartnerDashboardController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\QuestionController;

use App\Http\Controllers\QuestionHistoryController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\StudentExamController;

// Include Auth Routes
require __DIR__.'/auth.php';

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
    return view('welcome');
})->name('landing');

// Bulk Upload Route (accessible without authentication)
Route::get('/upload-questions', [App\Http\Controllers\QuestionController::class, 'showBulkUploadForm'])->name('questions.bulk-upload.public');
Route::post('/upload-questions', [App\Http\Controllers\QuestionController::class, 'bulkUpload'])->name('questions.bulk-upload.public.store');

// Contact page route (accessible without authentication)
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

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
    })->name('partner.area');

    // Student Area Access Route
    Route::get('/student-area', function () {
        return redirect()->route('student.dashboard');
    })->name('student.area');

    // Redirect root URL to the partner dashboard
    // Route::get('/', function () {
    //     return redirect()->route('partner.dashboard');
    // });

    // Partner Routes (Coaching Center)
    Route::prefix('partner')->name('partner.')->middleware(['auth', 'role:partner'])->group(function () {
        Route::get('/', [PartnerDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [PartnerDashboardController::class, 'index'])->name('dashboard');
        
        // Partner Management
        Route::resource('partners', PartnerController::class);
        Route::get('partners/{partner}/assign', [PartnerController::class, 'assign'])->name('partners.assign');
        Route::patch('partners/{partner}/toggle-status', [PartnerController::class, 'toggleStatus'])->name('partners.toggle-status');
        
        // Course Management
        Route::resource('courses', CourseController::class);
        
        // Subject Management
        Route::resource('subjects', SubjectController::class);
        
        // Topic Management
        Route::resource('topics', TopicController::class);
        
        // Batch Management
        Route::resource('batches', \App\Http\Controllers\BatchController::class);
        Route::get('batches/trashed', [\App\Http\Controllers\BatchController::class, 'trashed'])->name('batches.trashed');
        Route::post('batches/{id}/restore', [\App\Http\Controllers\BatchController::class, 'restore'])->name('batches.restore');
        
        // Question Management - Main Questions Dashboard (must come first)
        Route::get('questions', [QuestionController::class, 'allQuestions'])->name('questions.index');
        Route::get('questions/all', [QuestionController::class, 'allQuestions'])->name('questions.all');
        Route::get('questions/list', [QuestionController::class, 'index'])->name('questions.list');
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
        Route::get('exams/{exam}/export', [ExamController::class, 'export'])->name('exams.export');
        Route::get('exams/{exam}/paper-parameters', [ExamController::class, 'paperParameters'])->name('exams.paper-parameters');
        Route::post('exams/{exam}/download-paper', [ExamController::class, 'downloadPaper'])->name('exams.download-paper');
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
        
        // Student Assignment Routes (must come BEFORE resource route)
        Route::match(['get', 'post', 'put'], 'students/assignment', [StudentController::class, 'assignment'])->name('students.assignment');
        Route::put('students/{student}/assignment', [StudentController::class, 'updateAssignment'])->name('students.update-assignment');
        Route::post('students/bulk-assignment', [StudentController::class, 'bulkAssignment'])->name('students.bulk-assignment');
        
        // Student Management
        Route::resource('students', StudentController::class);
        
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
        Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
        Route::put('profile/partner', [\App\Http\Controllers\ProfileController::class, 'updatePartner'])->name('profile.updatePartner');
        
        // User Profile Management
        Route::get('profile/user', [\App\Http\Controllers\ProfileController::class, 'showUser'])->name('profile.show-user-profile');
        Route::get('profile/user/edit', [\App\Http\Controllers\ProfileController::class, 'editUser'])->name('profile.edit-user-profile');
        Route::put('profile/user', [\App\Http\Controllers\ProfileController::class, 'updateUser'])->name('profile.update-user');
        
        // Additional profile routes for better naming consistency
        Route::put('profile/update', [\App\Http\Controllers\ProfileController::class, 'updatePartner'])->name('profile.update');
        
        // Partner profile update route (alias for consistency)
        Route::put('profile/update-partner', [\App\Http\Controllers\ProfileController::class, 'updatePartner'])->name('profile.updatePartner');
        
        // Partner Settings
        Route::get('settings', function () {
            try {
                $partner = \App\Models\Partner::where('user_id', auth()->id())->first();
                
                // If no partner found, create a default one or redirect with error
                if (!$partner) {
                    return redirect()->route('partner.dashboard')->with('error', 'Partner profile not found. Please complete your profile first.');
                }
                
                // Debug: Log the partner data
                \Log::info('Partner data for settings:', ['partner_id' => $partner->id, 'name' => $partner->name ?? 'No name']);
                
                return view('partner.Settings.partner-settings', compact('partner'));
            } catch (\Exception $e) {
                \Log::error('Error in partner settings route: ' . $e->getMessage());
                return redirect()->route('partner.dashboard')->with('error', 'An error occurred while loading settings.');
            }
        })->name('settings.index');
        
        // Test Settings Route
        Route::get('test-settings', function () {
            try {
                $partner = \App\Models\Partner::where('user_id', auth()->id())->first();
                
                if (!$partner) {
                    return redirect()->route('partner.dashboard')->with('error', 'Partner profile not found. Please complete your profile first.');
                }
                
                return view('partner.Settings.test-settings', compact('partner'));
            } catch (\Exception $e) {
                \Log::error('Error in test settings route: ' . $e->getMessage());
                return redirect()->route('partner.dashboard')->with('error', 'An error occurred while loading test settings.');
            }
        })->name('test-settings.index');
        
        // Demo Data Seeding
        Route::post('seed-demo-students', [\App\Http\Controllers\PartnerDashboardController::class, 'seedDemoStudents'])->name('seed-demo-students');
        Route::get('refresh-stats', [\App\Http\Controllers\PartnerDashboardController::class, 'refreshStats'])->name('refresh-stats');
        Route::get('student-count', [\App\Http\Controllers\PartnerDashboardController::class, 'getStudentCount'])->name('student-count');
        
        // MCQ Question Seeding
        Route::post('seed-mcq-questions', [\App\Http\Controllers\QuestionController::class, 'seedMcqQuestions'])->name('seed-mcq-questions');
        Route::get('check-session', [\App\Http\Controllers\QuestionController::class, 'checkSession'])->name('check-session');
        
        // Permission Management
        Route::prefix('permissions')->name('permissions.')->group(function () {
            Route::get('/', [\App\Http\Controllers\PermissionController::class, 'index'])->name('index');
            Route::post('/roles', [\App\Http\Controllers\PermissionController::class, 'storeRole'])->name('store-role');
            Route::put('/roles/{role}', [\App\Http\Controllers\PermissionController::class, 'updateRole'])->name('update-role');
            Route::delete('/roles/{role}', [\App\Http\Controllers\PermissionController::class, 'destroyRole'])->name('destroy-role');
            Route::post('/settings', [\App\Http\Controllers\PermissionController::class, 'saveSettings'])->name('save-settings');
            Route::post('/reset', [\App\Http\Controllers\PermissionController::class, 'resetToDefaults'])->name('reset');
            Route::get('/export', [\App\Http\Controllers\PermissionController::class, 'export'])->name('export');
            Route::post('/import', [\App\Http\Controllers\PermissionController::class, 'import'])->name('import');
        });
    });

    // Student Routes
    Route::prefix('student')->name('student.')->middleware(['auth', 'role:student'])->group(function () {
        Route::get('/', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        
        // Student Profile
        Route::resource('profile', StudentController::class)->only(['show', 'edit', 'update']);
        
        // Available Exams
        Route::get('exams', [StudentExamController::class, 'availableExams'])->name('exams.available');
        Route::get('exams/{exam}', [StudentExamController::class, 'showExam'])->name('exams.show');
        
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

});

// Public Quiz Routes (No Authentication Required)
Route::prefix('quiz')->name('public.quiz.')->group(function () {
    Route::get('/', [\App\Http\Controllers\PublicQuizController::class, 'showAccessPage'])->name('access');
    Route::post('/access', [\App\Http\Controllers\PublicQuizController::class, 'processAccess'])->name('process-access');
    Route::post('/multiple-exams', [\App\Http\Controllers\PublicQuizController::class, 'handleMultipleExams'])->name('multiple-exams');
    Route::get('/available', [\App\Http\Controllers\PublicQuizController::class, 'showAvailableExams'])->name('available');
    Route::get('/select/{accessCode}', [\App\Http\Controllers\PublicQuizController::class, 'selectExam'])->name('select');
    Route::get('/{exam}/start', [\App\Http\Controllers\PublicQuizController::class, 'showQuiz'])->name('start');
    Route::post('/{exam}/start', [\App\Http\Controllers\PublicQuizController::class, 'startQuiz'])->name('start-quiz');
    Route::get('/{exam}/take', [\App\Http\Controllers\PublicQuizController::class, 'takeQuiz'])->name('take');
    Route::post('/{exam}/submit', [\App\Http\Controllers\PublicQuizController::class, 'submitQuiz'])->name('submit');
    Route::get('/{exam}/result', [\App\Http\Controllers\PublicQuizController::class, 'showResult'])->name('result');
});

// API Routes for Public Quiz (No Authentication Required)
Route::prefix('api/exam')->group(function () {
    Route::get('/{exam}/waiting-students', [\App\Http\Controllers\PublicQuizController::class, 'getWaitingStudentsApi'])->name('api.exam.waiting-students');
});