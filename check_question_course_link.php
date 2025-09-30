<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Question;
use App\Models\Course;
use App\Models\Partner;

echo "=== Question-Course Link Diagnostic ===\n\n";

// Get all partners
$partners = Partner::with('user')->get();

foreach ($partners as $partner) {
    echo "Partner ID: {$partner->id} - {$partner->organization_name}\n";
    echo str_repeat("-", 60) . "\n";
    
    // Total questions for this partner
    $totalQuestions = Question::where('partner_id', $partner->id)->count();
    echo "Total Questions: {$totalQuestions}\n";
    
    // Questions with valid course link (course also belongs to partner)
    $questionsWithValidCourse = Question::where('partner_id', $partner->id)
        ->whereHas('course', function($q) use ($partner) {
            $q->where('partner_id', $partner->id);
        })
        ->count();
    echo "Questions with Valid Course Link: {$questionsWithValidCourse}\n";
    
    // Questions without course
    $questionsWithoutCourse = Question::where('partner_id', $partner->id)
        ->whereNull('course_id')
        ->count();
    echo "Questions without Course: {$questionsWithoutCourse}\n";
    
    // Questions with course but course belongs to different partner
    $questionsWithWrongCourse = Question::where('partner_id', $partner->id)
        ->whereNotNull('course_id')
        ->whereDoesntHave('course', function($q) use ($partner) {
            $q->where('partner_id', $partner->id);
        })
        ->count();
    echo "Questions with Wrong Course Link: {$questionsWithWrongCourse}\n";
    
    // Show sample of problematic questions
    if ($questionsWithWrongCourse > 0 || $questionsWithoutCourse > 0) {
        echo "\nSample Problematic Questions:\n";
        $problematic = Question::where('partner_id', $partner->id)
            ->where(function($q) use ($partner) {
                $q->whereNull('course_id')
                  ->orWhereDoesntHave('course', function($q2) use ($partner) {
                      $q2->where('partner_id', $partner->id);
                  });
            })
            ->limit(5)
            ->get(['id', 'question_text', 'course_id', 'partner_id']);
        
        foreach ($problematic as $q) {
            $courseInfo = $q->course_id ? "Course ID: {$q->course_id}" : "No Course";
            echo "  - Q#{$q->id}: " . substr($q->question_text, 0, 50) . "... ({$courseInfo})\n";
        }
    }
    
    echo "\n" . str_repeat("=", 60) . "\n\n";
}
