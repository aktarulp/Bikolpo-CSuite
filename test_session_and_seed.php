<?php

/**
 * Simple test script to check session and seed MCQ questions
 * Run this from the Laravel project root directory
 */

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Bootstrap Laravel
$app = Application::configure(basePath: __DIR__)
    ->withRouting(
        web: __DIR__.'/routes/web.php',
        commands: __DIR__.'/bootstrap/commands.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Session Check & MCQ Seeding Test ===\n\n";

try {
    // Check if we can access the database
    echo "1. Testing database connection...\n";
    $db = DB::connection();
    $db->getPdo();
    echo "   ✓ Database connection successful\n\n";

    // Check session configuration
    echo "2. Checking session configuration...\n";
    echo "   Session Driver: " . config('session.driver') . "\n";
    echo "   Session Lifetime: " . config('session.lifetime') . " minutes\n";
    echo "   Session Table: " . config('session.table') . "\n\n";

    // Check if there are any users
    echo "3. Checking user accounts...\n";
    $userCount = \App\Models\User::count();
    echo "   Total Users: {$userCount}\n";
    
    if ($userCount > 0) {
        $partners = \App\Models\User::where('role', 'partner')->count();
        $students = \App\Models\User::where('role', 'student')->count();
        echo "   Partners: {$partners}\n";
        echo "   Students: {$students}\n";
    }
    echo "\n";

    // Check if there are any partners
    echo "4. Checking partner accounts...\n";
    $partnerCount = \App\Models\Partner::count();
    echo "   Total Partners: {$partnerCount}\n";
    
    if ($partnerCount > 0) {
        $activePartners = \App\Models\Partner::where('status', 'active')->count();
        echo "   Active Partners: {$activePartners}\n";
        
        $firstPartner = \App\Models\Partner::first();
        if ($firstPartner) {
            echo "   First Partner: {$firstPartner->name} (ID: {$firstPartner->id})\n";
        }
    }
    echo "\n";

    // Check question types
    echo "5. Checking question types...\n";
    $questionTypes = \App\Models\QuestionType::all();
    echo "   Total Question Types: " . $questionTypes->count() . "\n";
    
    foreach ($questionTypes as $type) {
        echo "   - {$type->q_type_name} ({$type->q_type_code})\n";
    }
    echo "\n";

    // Check courses, subjects, and topics
    echo "6. Checking educational structure...\n";
    $courseCount = \App\Models\Course::count();
    $subjectCount = \App\Models\Subject::count();
    $topicCount = \App\Models\Topic::count();
    
    echo "   Courses: {$courseCount}\n";
    echo "   Subjects: {$subjectCount}\n";
    echo "   Topics: {$topicCount}\n\n";

    // Check existing questions
    echo "7. Checking existing questions...\n";
    $questionCount = \App\Models\Question::count();
    $mcqCount = \App\Models\Question::where('question_type', 'mcq')->count();
    $descCount = \App\Models\Question::where('question_type', 'descriptive')->count();
    
    echo "   Total Questions: {$questionCount}\n";
    echo "   MCQ Questions: {$mcqCount}\n";
    echo "   Descriptive Questions: {$descCount}\n\n";

    // Test seeding functionality
    if ($partnerCount > 0 && $courseCount > 0 && $subjectCount > 0 && $topicCount > 0) {
        echo "8. Testing MCQ seeding...\n";
        echo "   This would normally seed questions for the first active partner.\n";
        echo "   To actually seed questions, use the web interface or artisan command:\n";
        echo "   - Web: Visit /partner/check-session\n";
        echo "   - Artisan: php artisan seed:mcq-questions\n\n";
    } else {
        echo "8. Cannot test seeding - missing required data:\n";
        if ($partnerCount == 0) echo "   - No partners found\n";
        if ($courseCount == 0) echo "   - No courses found\n";
        if ($subjectCount == 0) echo "   - No subjects found\n";
        if ($topicCount == 0) echo "   - No topics found\n";
        echo "\n";
    }

    echo "=== Test Complete ===\n";
    echo "To seed 100 MCQ questions:\n";
    echo "1. Visit: /partner/check-session (if logged in as partner)\n";
    echo "2. Or run: php artisan seed:mcq-questions\n";
    echo "3. Or use the existing route: /partner/questions/mcq/generate-samples\n\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
