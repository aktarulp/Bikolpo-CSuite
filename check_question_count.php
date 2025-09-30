<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Question;
use App\Models\Partner;
use App\Models\User;

echo "=== Question Count Diagnostic ===\n\n";

// Get all partners
$partners = Partner::with('user')->get();

echo "Total Partners: " . $partners->count() . "\n\n";

foreach ($partners as $partner) {
    $questionCount = Question::where('partner_id', $partner->id)->count();
    $userName = $partner->user ? $partner->user->name : 'No User';
    
    echo "Partner ID: {$partner->id}\n";
    echo "Partner Name: {$partner->organization_name}\n";
    echo "User: {$userName}\n";
    echo "Question Count: {$questionCount}\n";
    
    if ($questionCount > 0) {
        // Show question type breakdown
        $mcqCount = Question::where('partner_id', $partner->id)->where('question_type', 'mcq')->count();
        $descriptiveCount = Question::where('partner_id', $partner->id)->where('question_type', 'descriptive')->count();
        $trueFalseCount = Question::where('partner_id', $partner->id)->where('question_type', 'true_false')->count();
        
        echo "  - MCQ: {$mcqCount}\n";
        echo "  - Descriptive: {$descriptiveCount}\n";
        echo "  - True/False: {$trueFalseCount}\n";
    }
    
    echo "\n";
}

// Check for questions without partner_id
$orphanedQuestions = Question::whereNull('partner_id')->count();
echo "Questions without partner_id: {$orphanedQuestions}\n\n";

// Total questions in database
$totalQuestions = Question::count();
echo "Total Questions in Database: {$totalQuestions}\n";
