<?php

use Illuminate\Support\Facades\Route;

// Direct image serving route for teachers
Route::get('/teacher-photo/{filename}', function ($filename) {
    $filePath = public_path('uploads/teachers/' . $filename);
    
    if (!file_exists($filePath)) {
        abort(404, 'Teacher photo not found');
    }
    
    if (!is_readable($filePath)) {
        abort(403, 'Teacher photo not accessible');
    }
    
    $mimeType = mime_content_type($filePath);
    $fileSize = filesize($filePath);
    
    return response()->file($filePath, [
        'Content-Type' => $mimeType,
        'Content-Length' => $fileSize,
        'Cache-Control' => 'public, max-age=31536000', // Cache for 1 year
    ]);
})->name('teacher.photo.serve');

// Direct image serving route for students
Route::get('/student-photo/{filename}', function ($filename) {
    $filePath = public_path('uploads/student-photos/' . $filename);
    
    if (!file_exists($filePath)) {
        abort(404, 'Student photo not found');
    }
    
    if (!is_readable($filePath)) {
        abort(403, 'Student photo not accessible');
    }
    
    $mimeType = mime_content_type($filePath);
    $fileSize = filesize($filePath);
    
    return response()->file($filePath, [
        'Content-Type' => $mimeType,
        'Content-Length' => $fileSize,
        'Cache-Control' => 'public, max-age=31536000', // Cache for 1 year
    ]);
})->name('student.photo.serve');

// Direct image serving route for qcreators
Route::get('/qcreator-photo/{filename}', function ($filename) {
    $filePath = public_path('uploads/qcreators/' . $filename);
    
    if (!file_exists($filePath)) {
        abort(404, 'QCReator photo not found');
    }
    
    if (!is_readable($filePath)) {
        abort(403, 'QCReator photo not accessible');
    }
    
    $mimeType = mime_content_type($filePath);
    $fileSize = filesize($filePath);
    
    return response()->file($filePath, [
        'Content-Type' => $mimeType,
        'Content-Length' => $fileSize,
        'Cache-Control' => 'public, max-age=31536000', // Cache for 1 year
    ]);
})->name('qcreator.photo.serve');

