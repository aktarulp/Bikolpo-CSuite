<?php

use Illuminate\Support\Facades\Route;

// Debug route to check photo URLs
Route::get('/debug-teacher-photos', function () {
    $teachers = App\Models\Teacher::whereNotNull('photo')->take(5)->get();
    
    $data = [];
    foreach ($teachers as $teacher) {
        $data[] = [
            'id' => $teacher->id,
            'name' => $teacher->full_name,
            'photo_db' => $teacher->photo,
            'photo_url' => $teacher->photo_url,
            'file_exists' => file_exists(public_path('uploads/' . $teacher->photo)),
            'file_path' => public_path('uploads/' . $teacher->photo),
        ];
    }
    
    return response()->json([
        'teachers' => $data,
        'base_url' => config('app.url'),
        'public_path' => public_path(),
    ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
})->name('debug.teacher.photos');

Route::get('/debug-student-photos', function () {
    $students = App\Models\Student::whereNotNull('photo')->take(5)->get();
    
    $data = [];
    foreach ($students as $student) {
        $data[] = [
            'id' => $student->id,
            'name' => $student->full_name,
            'photo_db' => $student->photo,
            'photo_url' => $student->photo_url,
            'file_exists' => file_exists(public_path('uploads/' . $student->photo)),
            'file_path' => public_path('uploads/' . $student->photo),
        ];
    }
    
    return response()->json([
        'students' => $data,
        'base_url' => config('app.url'),
        'public_path' => public_path(),
    ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
})->name('debug.student.photos');

