<?php

// Debug script to understand photo URL generation and file access
// Run this on Hostinger to debug the photo issue

echo "<h1>Photo Debug Information</h1>";

// Check if we're in Laravel context
if (file_exists('vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
    
    // Bootstrap Laravel
    $app = require_once 'bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    
    echo "<h2>Laravel Environment</h2>";
    echo "App URL: " . config('app.url') . "<br>";
    echo "Environment: " . app()->environment() . "<br>";
    
    // Check storage configuration
    echo "<h2>Storage Configuration</h2>";
    echo "Storage Path: " . storage_path() . "<br>";
    echo "Public Path: " . public_path() . "<br>";
    
    // Check if storage link exists
    $storageLink = public_path('storage');
    echo "Storage Link Exists: " . (is_link($storageLink) ? "Yes" : "No") . "<br>";
    if (is_link($storageLink)) {
        echo "Storage Link Target: " . readlink($storageLink) . "<br>";
    }
    
    // Check uploads directory
    echo "<h2>Uploads Directory</h2>";
    $uploadsDir = public_path('uploads');
    echo "Uploads Directory Exists: " . (is_dir($uploadsDir) ? "Yes" : "No") . "<br>";
    
    if (is_dir($uploadsDir)) {
        echo "Uploads Contents:<br>";
        $contents = scandir($uploadsDir);
        foreach ($contents as $item) {
            if ($item != '.' && $item != '..') {
                echo "- " . $item . "<br>";
            }
        }
    }
    
    // Check student photos
    echo "<h2>Student Photos</h2>";
    $studentPhotosDir = public_path('uploads/student-photos');
    echo "Student Photos Directory Exists: " . (is_dir($studentPhotosDir) ? "Yes" : "No") . "<br>";
    
    if (is_dir($studentPhotosDir)) {
        $studentPhotos = scandir($studentPhotosDir);
        echo "Student Photos Count: " . (count($studentPhotos) - 2) . "<br>";
        foreach ($studentPhotos as $photo) {
            if ($photo != '.' && $photo != '..') {
                echo "- " . $photo . "<br>";
            }
        }
    }
    
    // Check teacher photos
    echo "<h2>Teacher Photos</h2>";
    $teacherPhotosDir = public_path('uploads/teachers');
    echo "Teacher Photos Directory Exists: " . (is_dir($teacherPhotosDir) ? "Yes" : "No") . "<br>";
    
    if (is_dir($teacherPhotosDir)) {
        $teacherPhotos = scandir($teacherPhotosDir);
        echo "Teacher Photos Count: " . (count($teacherPhotos) - 2) . "<br>";
        foreach ($teacherPhotos as $photo) {
            if ($photo != '.' && $photo != '..') {
                echo "- " . $photo . "<br>";
            }
        }
    }
    
    // Check storage directory
    echo "<h2>Storage Directory</h2>";
    $storageDir = storage_path('app/public');
    echo "Storage Directory Exists: " . (is_dir($storageDir) ? "Yes" : "No") . "<br>";
    
    if (is_dir($storageDir)) {
        $storageContents = scandir($storageDir);
        echo "Storage Contents:<br>";
        foreach ($storageContents as $item) {
            if ($item != '.' && $item != '..') {
                echo "- " . $item . "<br>";
            }
        }
    }
    
    // Check storage subdirectories
    echo "<h2>Storage Subdirectories</h2>";
    $studentStorageDir = storage_path('app/public/student-photos');
    $teacherStorageDir = storage_path('app/public/teachers');
    
    echo "Student Storage Directory Exists: " . (is_dir($studentStorageDir) ? "Yes" : "No") . "<br>";
    if (is_dir($studentStorageDir)) {
        $studentStoragePhotos = scandir($studentStorageDir);
        echo "Student Storage Photos Count: " . (count($studentStoragePhotos) - 2) . "<br>";
    }
    
    echo "Teacher Storage Directory Exists: " . (is_dir($teacherStorageDir) ? "Yes" : "No") . "<br>";
    if (is_dir($teacherStorageDir)) {
        $teacherStoragePhotos = scandir($teacherStorageDir);
        echo "Teacher Storage Photos Count: " . (count($teacherStoragePhotos) - 2) . "<br>";
    }
    
    // Test URL generation
    echo "<h2>URL Generation Test</h2>";
    echo "Asset function test: " . asset('uploads/test.jpg') . "<br>";
    echo "Storage asset test: " . asset('storage/test.jpg') . "<br>";
    
} else {
    echo "<p>Laravel not found. This script should be run from the Laravel root directory.</p>";
}

echo "<h2>File System Check</h2>";
echo "Current Directory: " . getcwd() . "<br>";
echo "PHP Version: " . phpversion() . "<br>";

// Check if we can access files directly
echo "<h2>Direct File Access Test</h2>";
$testFiles = [
    'public/uploads/student-photos/',
    'public/uploads/teachers/',
    'storage/app/public/student-photos/',
    'storage/app/public/teachers/'
];

foreach ($testFiles as $testFile) {
    $fullPath = getcwd() . '/' . $testFile;
    echo "Path: {$testFile} - Exists: " . (file_exists($fullPath) ? "Yes" : "No") . "<br>";
    if (file_exists($fullPath) && is_dir($fullPath)) {
        $files = scandir($fullPath);
        echo "  Files: " . (count($files) - 2) . "<br>";
    }
}
