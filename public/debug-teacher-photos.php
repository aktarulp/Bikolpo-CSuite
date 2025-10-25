<?php
// Simple diagnostic page for teacher photos on Hostinger
// Access this via: https://yourdomain.com/debug-teacher-photos.php

echo "<h1>Teacher Photos Debug - Hostinger</h1>";
echo "<p>This page will help diagnose why teacher photos are not showing on Hostinger.</p>";

// Check if we're in Laravel context
if (file_exists('../vendor/autoload.php')) {
    require_once '../vendor/autoload.php';
    
    // Bootstrap Laravel
    $app = require_once '../bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    
    echo "<h2>Laravel Environment</h2>";
    echo "App URL: " . config('app.url') . "<br>";
    echo "Environment: " . app()->environment() . "<br>";
    
    // Get a teacher with photo
    $teacher = \App\Models\Teacher::whereNotNull('photo')->first();
    
    if ($teacher) {
        echo "<h2>Sample Teacher Data</h2>";
        echo "Teacher Name: " . $teacher->full_name . "<br>";
        echo "Photo Path: " . $teacher->photo . "<br>";
        echo "Photo URL: " . $teacher->photo_url . "<br>";
        
        // Check if photo file exists
        $photoPath = public_path('uploads/' . $teacher->photo);
        echo "Full Photo Path: " . $photoPath . "<br>";
        echo "Photo File Exists: " . (file_exists($photoPath) ? "YES" : "NO") . "<br>";
        
        if (file_exists($photoPath)) {
            echo "Photo File Size: " . filesize($photoPath) . " bytes<br>";
            echo "Photo File Permissions: " . substr(sprintf('%o', fileperms($photoPath)), -4) . "<br>";
        }
        
        // Test direct URL access
        echo "<h2>Direct URL Test</h2>";
        $directUrl = config('app.url') . '/uploads/' . $teacher->photo;
        echo "Direct URL: <a href='{$directUrl}' target='_blank'>{$directUrl}</a><br>";
        
        // Display the photo if it exists
        if (file_exists($photoPath)) {
            echo "<h2>Photo Preview</h2>";
            echo "<img src='{$directUrl}' style='max-width: 200px; max-height: 200px; border: 2px solid green;' alt='Teacher Photo'>";
        } else {
            echo "<h2>Photo Not Found</h2>";
            echo "<p style='color: red;'>The photo file does not exist at the expected location.</p>";
        }
        
    } else {
        echo "<h2>No Teachers with Photos Found</h2>";
        echo "<p>No teachers with photos found in the database.</p>";
    }
    
    // Check directory structure
    echo "<h2>Directory Structure Check</h2>";
    $directories = [
        'public/uploads',
        'public/uploads/teachers',
        'storage/app/public',
        'storage/app/public/teachers'
    ];
    
    foreach ($directories as $dir) {
        $fullPath = base_path($dir);
        echo "Directory: {$dir} - ";
        if (is_dir($fullPath)) {
            echo "EXISTS";
            $files = scandir($fullPath);
            $fileCount = count($files) - 2; // Subtract . and ..
            echo " ({$fileCount} files)";
        } else {
            echo "NOT EXISTS";
        }
        echo "<br>";
    }
    
    // Check file permissions
    echo "<h2>File Permissions Check</h2>";
    $uploadsDir = public_path('uploads');
    if (is_dir($uploadsDir)) {
        echo "Uploads directory permissions: " . substr(sprintf('%o', fileperms($uploadsDir)), -4) . "<br>";
        
        $teachersDir = public_path('uploads/teachers');
        if (is_dir($teachersDir)) {
            echo "Teachers directory permissions: " . substr(sprintf('%o', fileperms($teachersDir)), -4) . "<br>";
        }
    }
    
} else {
    echo "<p>Laravel not found. This script should be run from the Laravel root directory.</p>";
}

// Simple file system check
echo "<h2>Simple File System Check</h2>";
$currentDir = getcwd();
echo "Current Directory: {$currentDir}<br>";

// Check if we can create a test file
$testFile = 'public/uploads/test.txt';
if (is_dir('public/uploads')) {
    if (file_put_contents($testFile, 'test content')) {
        echo "✓ Can write to public/uploads/<br>";
        unlink($testFile); // Clean up
    } else {
        echo "✗ Cannot write to public/uploads/<br>";
    }
} else {
    echo "✗ public/uploads/ directory does not exist<br>";
}

echo "<h2>Next Steps</h2>";
echo "<p>Based on the information above:</p>";
echo "<ul>";
echo "<li>If 'Photo File Exists' shows NO, the photos need to be migrated</li>";
echo "<li>If 'Photo File Exists' shows YES but the image doesn't display, check file permissions</li>";
echo "<li>If the directory doesn't exist, create it with: mkdir -p public/uploads/teachers</li>";
echo "<li>If permissions are wrong, fix with: chmod -R 755 public/uploads/</li>";
echo "</ul>";
?>
