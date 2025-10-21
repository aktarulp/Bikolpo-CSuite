<?php

use App\Http\Controllers\Partner\StudentController;
use App\Http\Controllers\Partner\EnrollmentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Partner Student Routes
|--------------------------------------------------------------------------
|
| These routes demonstrate how to protect routes with permission middleware.
| Each route is protected by the appropriate permission.
|
*/

Route::middleware(['auth'])->group(function () {
    
    // Students index - requires menu permission
    Route::get('/students', [StudentController::class, 'index'])
        ->name('partner.students.index');
    
    // Create student routes
    Route::get('/students/create', [StudentController::class, 'create'])
        ->name('partner.students.create');
    Route::post('/students', [StudentController::class, 'store'])
        ->name('partner.students.store');
    
    // View student details
    Route::get('/students/{student}', [StudentController::class, 'show'])
        ->name('partner.students.show');
    
    // Edit student routes
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])
        ->name('partner.students.edit');
    Route::put('/students/{student}', [StudentController::class, 'update'])
        ->name('partner.students.update');
    
    // Delete student
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])
        ->name('partner.students.destroy');
    
    // Export students
    Route::get('/students/export', [StudentController::class, 'export'])
        ->name('partner.students.export');
    
    // Import students
    Route::post('/students/import', [StudentController::class, 'import'])
        ->name('partner.students.import');
    
    // Assign course to student
    Route::post('/students/{student}/assign-course', [StudentController::class, 'assignCourse'])
        ->name('partner.students.assign-course');
    
    // Manage student grades
    Route::get('/students/{student}/grades', [StudentController::class, 'manageGrades'])
        ->name('partner.students.grades');
    
    // =====================================================
    // ENROLLMENT ROUTES (Multi-Course Enrollment System)
    // =====================================================
    
    // Enrollment Index & Listing
    Route::get('/enrollments', [EnrollmentController::class, 'index'])
        ->name('partner.enrollments.index');
    
    // Create New Enrollment
    Route::get('/enrollments/create', [EnrollmentController::class, 'create'])
        ->name('partner.enrollments.create');
    Route::post('/enrollments', [EnrollmentController::class, 'store'])
        ->name('partner.enrollments.store');
    
    // View Enrollment Details
    Route::get('/enrollments/{enrollment}', [EnrollmentController::class, 'show'])
        ->name('partner.enrollments.show');
    
    // Edit Enrollment
    Route::get('/enrollments/{enrollment}/edit', [EnrollmentController::class, 'edit'])
        ->name('partner.enrollments.edit');
    Route::put('/enrollments/{enrollment}', [EnrollmentController::class, 'update'])
        ->name('partner.enrollments.update');
    
    // Delete Enrollment
    Route::delete('/enrollments/{enrollment}', [EnrollmentController::class, 'destroy'])
        ->name('partner.enrollments.destroy');
    
    // Enrollment Status Actions
    Route::patch('/enrollments/{enrollment}/complete', [EnrollmentController::class, 'complete'])
        ->name('partner.enrollments.complete');
    Route::patch('/enrollments/{enrollment}/drop', [EnrollmentController::class, 'drop'])
        ->name('partner.enrollments.drop');
    Route::patch('/enrollments/{enrollment}/suspend', [EnrollmentController::class, 'suspend'])
        ->name('partner.enrollments.suspend');
    Route::patch('/enrollments/{enrollment}/reactivate', [EnrollmentController::class, 'reactivate'])
        ->name('partner.enrollments.reactivate');
    
    // Student Enrollment History
    Route::get('/students/{student}/enrollments', [EnrollmentController::class, 'studentHistory'])
        ->name('partner.students.enrollment-history');
    
    // Course Enrollments
    Route::get('/courses/{course}/enrollments', [EnrollmentController::class, 'courseEnrollments'])
        ->name('partner.courses.enrollments');
    
    // Get batches by course (for AJAX)
    Route::get('/batches/by-course/{course}', [EnrollmentController::class, 'getBatchesByCourse'])
        ->name('partner.batches.by-course');
    
});
