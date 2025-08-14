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
use App\Http\Controllers\QuestionSetController;
use App\Http\Controllers\QuestionHistoryController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\StudentExamController;

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

// Redirect root URL to the partner dashboard
Route::get('/', function () {
    return redirect()->route('partner.dashboard');
});

// Partner Routes (Coaching Center)
Route::prefix('partner')->name('partner.')->group(function () {
    Route::get('/', [PartnerDashboardController::class, 'index'])->name('dashboard');
    
    // Partner Management
    Route::resource('partners', PartnerController::class);
    
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
    
    // Question Management - Main Questions Index (must come first)
    Route::get('questions', [QuestionController::class, 'index'])->name('questions.index');
    Route::get('questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('questions/{question}', [QuestionController::class, 'show'])->name('questions.show');
    Route::get('questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::put('questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
    
    Route::post('questions/check-duplicate', [QuestionController::class, 'checkDuplicate'])->name('questions.check-duplicate');
    // Dependent dropdowns for Question create
    Route::get('questions/subjects', [QuestionController::class, 'getSubjects'])->name('questions.subjects');
    Route::get('questions/topics', [QuestionController::class, 'getTopics'])->name('questions.topics');
    
    // Question Types - MCQ, Descriptive, Comprehensive
    Route::prefix('questions/mcq')->name('questions.mcq.')->group(function () {
        Route::get('/', [QuestionController::class, 'mcqIndex'])->name('index');
        Route::get('/create', [QuestionController::class, 'mcqCreate'])->name('create');
        Route::post('/', [QuestionController::class, 'mcqStore'])->name('store');
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
    
    Route::prefix('questions/comprehensive')->name('questions.comprehensive.')->group(function () {
        Route::get('/', [QuestionController::class, 'comprehensiveIndex'])->name('index');
        Route::get('/create', [QuestionController::class, 'comprehensiveCreate'])->name('create');
        Route::post('/', [QuestionController::class, 'comprehensiveStore'])->name('store');
        Route::get('/{question}/edit', [QuestionController::class, 'comprehensiveEdit'])->name('edit');
        Route::put('/{question}', [QuestionController::class, 'comprehensiveUpdate'])->name('update');
        Route::delete('/{question}', [QuestionController::class, 'comprehensiveDestroy'])->name('destroy');
    });
    
    // Question Set Management
    Route::resource('question-sets', QuestionSetController::class);
    Route::post('question-sets/{questionSet}/add-questions', [QuestionSetController::class, 'addQuestions'])->name('question-sets.add-questions');
    Route::delete('question-sets/{questionSet}/remove-question/{question}', [QuestionSetController::class, 'removeQuestion'])->name('question-sets.remove-question');
    
    // Question History Management
    Route::resource('question-history', \App\Http\Controllers\QuestionHistoryController::class);
    Route::get('question-history/statistics', [\App\Http\Controllers\QuestionHistoryController::class, 'statistics'])->name('question-history.statistics');
    Route::post('question-history/bulk-verify', [\App\Http\Controllers\QuestionHistoryController::class, 'bulkVerify'])->name('question-history.bulk-verify');
    
    // Exam Management
    Route::resource('exams', ExamController::class);
    Route::post('exams/{exam}/publish', [ExamController::class, 'publish'])->name('exams.publish');
    Route::post('exams/{exam}/unpublish', [ExamController::class, 'unpublish'])->name('exams.unpublish');
    Route::get('exams/{exam}/results', [ExamController::class, 'results'])->name('exams.results');
    Route::get('exams/{exam}/export', [ExamController::class, 'export'])->name('exams.export');
    
    // Student Management
    Route::resource('students', StudentController::class);
});

// Student Routes
Route::prefix('student')->name('student.')->group(function () {
    Route::get('/', [StudentDashboardController::class, 'index'])->name('dashboard');
    
    // Student Profile
    Route::resource('profile', StudentController::class)->only(['show', 'edit', 'update']);
    
    // Available Exams
    Route::get('exams', [StudentExamController::class, 'availableExams'])->name('exams.available');
    Route::get('exams/{exam}', [StudentExamController::class, 'showExam'])->name('exams.show');
    
    // Take Exam
    Route::get('exams/{exam}/start', [StudentExamController::class, 'startExam'])->name('exams.start');
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