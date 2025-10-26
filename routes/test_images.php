<?php

use Illuminate\Support\Facades\Route;

// Test route to check if images are accessible
Route::get('/test-image-access', function () {
    $teacher = App\Models\Teacher::whereNotNull('photo')->first();
    
    if (!$teacher) {
        return response()->json(['error' => 'No teacher with photo found']);
    }
    
    $filePath = public_path('uploads/' . $teacher->photo);
    $url = url('uploads/' . $teacher->photo);
    
    $data = [
        'teacher_name' => $teacher->full_name,
        'photo_db' => $teacher->photo,
        'photo_url' => $teacher->photo_url,
        'file_path' => $filePath,
        'file_exists' => file_exists($filePath),
        'is_readable' => is_readable($filePath),
        'file_size' => file_exists($filePath) ? filesize($filePath) : 0,
        'file_permissions' => file_exists($filePath) ? substr(sprintf('%o', fileperms($filePath)), -4) : 'N/A',
        'direct_url' => $url,
    ];
    
    return response()->json($data, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
})->name('test.image.access');

// Test route to serve image directly
Route::get('/test-image/{filename}', function ($filename) {
    $filePath = public_path('uploads/teachers/' . $filename);
    
    if (!file_exists($filePath)) {
        return response()->json(['error' => 'File not found: ' . $filePath], 404);
    }
    
    if (!is_readable($filePath)) {
        return response()->json(['error' => 'File not readable: ' . $filePath], 403);
    }
    
    $mimeType = mime_content_type($filePath);
    $fileSize = filesize($filePath);
    
    return response()->file($filePath, [
        'Content-Type' => $mimeType,
        'Content-Length' => $fileSize,
    ]);
})->name('test.image.serve');

