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

Route::middleware(['auth', 'permission:menu-students'])->group(function () {
    
    // Students index - requires menu permission
    Route::get('/students', [StudentController::class, 'index'])
        ->name('partner.students.index');
    
    // Create student routes - requires add permission
    Route::middleware(['permission:students-add'])->group(function () {
        Route::get('/students/create', [StudentController::class, 'create'])
            ->name('partner.students.create');
        Route::post('/students', [StudentController::class, 'store'])
            ->name('partner.students.store');
    });
    
    // View student details - requires view permission
    Route::middleware(['permission:students-view'])->group(function () {
        Route::get('/students/{student}', [StudentController::class, 'show'])
            ->name('partner.students.show');
    });
    
    // Edit student routes - requires edit permission
    Route::middleware(['permission:students-edit'])->group(function () {
        Route::get('/students/{student}/edit', [StudentController::class, 'edit'])
            ->name('partner.students.edit');
        Route::put('/students/{student}', [StudentController::class, 'update'])
            ->name('partner.students.update');
    });
    
    // Delete student - requires delete permission
    Route::middleware(['permission:students-delete'])->group(function () {
        Route::delete('/students/{student}', [StudentController::class, 'destroy'])
            ->name('partner.students.destroy');
    });
    
    // Export students - requires export permission
    Route::middleware(['permission:students-export'])->group(function () {
        Route::get('/students/export', [StudentController::class, 'export'])
            ->name('partner.students.export');
    });
    
    // Import students - requires import permission
    Route::middleware(['permission:students-import'])->group(function () {
        Route::post('/students/import', [StudentController::class, 'import'])
            ->name('partner.students.import');
    });
    
    // Assign course to student - requires assign-course permission
    Route::middleware(['permission:students-assign-course'])->group(function () {
        Route::post('/students/{student}/assign-course', [StudentController::class, 'assignCourse'])
            ->name('partner.students.assign-course');
    });
    
    // Manage student grades - requires manage-grades permission
    Route::middleware(['permission:students-manage-grades'])->group(function () {
        Route::get('/students/{student}/grades', [StudentController::class, 'manageGrades'])
            ->name('partner.students.grades');
    });
    
});
