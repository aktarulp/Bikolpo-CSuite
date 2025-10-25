<?php
/**
 * Test script for Hostinger teacher photo upload
 * Upload this file to Hostinger and run: php test_hostinger_upload.php
 */

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== HOSTINGER TEACHER UPLOAD TEST\n";
echo "==================================\n\n";

// 1. Check directory structure
echo "1. DIRECTORY CHECKS:\n";
$uploadDir = public_path('uploads/teachers/');
echo "   Upload directory: " . $uploadDir . "\n";
echo "   Directory exists: " . (is_dir($uploadDir) ? 'Yes' : 'No') . "\n";
echo "   Directory writable: " . (is_writable($uploadDir) ? 'Yes' : 'No') . "\n";

if (!is_dir($uploadDir)) {
    echo "   Creating directory...\n";
    mkdir($uploadDir, 0755, true);
    echo "   Directory created: " . (is_dir($uploadDir) ? 'Yes' : 'No') . "\n";
}

// 2. Test file creation
echo "\n2. FILE CREATION TEST:\n";
$testFile = $uploadDir . 'test_' . time() . '.txt';
try {
    file_put_contents($testFile, 'test content');
    echo "   ✓ Test file created: " . $testFile . "\n";
    echo "   ✓ File exists: " . (file_exists($testFile) ? 'Yes' : 'No') . "\n";
    unlink($testFile);
    echo "   ✓ Test file cleaned up\n";
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// 3. Check Laravel paths
echo "\n3. LARAVEL PATHS:\n";
echo "   public_path(): " . public_path() . "\n";
echo "   base_path(): " . base_path() . "\n";
echo "   app_path(): " . app_path() . "\n";

// 4. Check if we're on Hostinger
echo "\n4. ENVIRONMENT CHECK:\n";
echo "   APP_URL: " . config('app.url') . "\n";
echo "   APP_ENV: " . config('app.env') . "\n";
echo "   FILESYSTEM_DISK: " . config('filesystems.default') . "\n";

// 5. Check existing teacher photos
echo "\n5. EXISTING TEACHER PHOTOS:\n";
try {
    $teachers = \App\Models\Teacher::whereNotNull('photo')->get();
    echo "   Teachers with photos: " . $teachers->count() . "\n";
    
    foreach ($teachers as $teacher) {
        $photoPath = public_path('uploads/' . $teacher->photo);
        echo "   - " . $teacher->full_name . ": " . (file_exists($photoPath) ? '✓' : '✗') . "\n";
        echo "     Path: " . $teacher->photo . "\n";
        echo "     URL: " . $teacher->photo_url . "\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error checking teachers: " . $e->getMessage() . "\n";
}

// 6. Test photo URL generation
echo "\n6. PHOTO URL GENERATION TEST:\n";
try {
    $testPhoto = 'teachers/test_photo.jpg';
    $testUrl = asset('uploads/' . $testPhoto);
    echo "   Test photo path: " . $testPhoto . "\n";
    echo "   Generated URL: " . $testUrl . "\n";
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n=== TEST COMPLETE ===\n";
echo "If all tests pass, the upload functionality should work correctly.\n";
echo "If any test fails, check the error messages above.\n";
