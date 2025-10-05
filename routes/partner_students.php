<?php

use App\Http\Controllers\Partner\StudentController;
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
    
});
