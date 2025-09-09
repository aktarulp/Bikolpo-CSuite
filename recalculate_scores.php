<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ExamResult;
use App\Models\Exam;
use App\Models\QuestionStat;
use Illuminate\Support\Facades\DB;

echo "=== Recalculating Exam Scores with Negative Marking ===\n\n";

// Get all exam results that need recalculation
$results = ExamResult::with(['exam', 'student'])
    ->whereHas('exam', function($query) {
        $query->where('has_negative_marking', true);
    })
    ->get();

echo "Found {$results->count()} exam results with negative marking enabled.\n\n";

$updatedCount = 0;
$errorCount = 0;

foreach ($results as $result) {
    try {
        echo "Processing: {$result->student->full_name} - {$result->exam->title} (ID: {$result->id})\n";
        
        // Get question statistics for this result
        $questionStats = QuestionStat::where('exam_result_id', $result->id)->get();
        
        if ($questionStats->isEmpty()) {
            echo "  ⚠️  No question statistics found, skipping...\n";
            continue;
        }
        
        // Recalculate score
        $newScore = 0;
        $totalMarks = 0;
        $correctAnswers = 0;
        $wrongAnswers = 0;
        $unanswered = 0;
        
        foreach ($questionStats as $stat) {
            $marks = $stat->marks ?? 1;
            $totalMarks += $marks;
            
            if ($stat->is_correct && $stat->is_answered) {
                $newScore += $marks;
                $correctAnswers++;
            } elseif ($stat->is_answered && !$stat->is_correct) {
                $wrongAnswers++;
                // Apply negative marking
                if ($result->exam->has_negative_marking) {
                    $negativeMarks = $result->exam->negative_marks_per_question ?? 0;
                    $newScore -= $negativeMarks;
                }
            } else {
                $unanswered++;
            }
        }
        
        // Ensure score doesn't go below 0
        $newScore = max(0, $newScore);
        
        // Calculate new percentage
        $newPercentage = $totalMarks > 0 ? ($newScore / $totalMarks) * 100 : 0;
        
        // Check if score needs updating
        $oldScore = $result->score;
        $oldPercentage = $result->percentage;
        
        if ($oldScore != $newScore || $oldPercentage != $newPercentage) {
            echo "  📊 Score Update: {$oldScore} → {$newScore} (Percentage: {$oldPercentage}% → {$newPercentage}%)\n";
            echo "  📈 Correct: {$correctAnswers}, Wrong: {$wrongAnswers}, Unanswered: {$unanswered}\n";
            
            // Update the result
            $result->update([
                'score' => $newScore,
                'percentage' => $newPercentage,
                'correct_answers' => $correctAnswers,
                'wrong_answers' => $wrongAnswers,
                'unanswered' => $unanswered,
            ]);
            
            $updatedCount++;
        } else {
            echo "  ✅ Score is already correct: {$newScore}\n";
        }
        
    } catch (Exception $e) {
        echo "  ❌ Error processing result ID {$result->id}: " . $e->getMessage() . "\n";
        $errorCount++;
    }
    
    echo "\n";
}

echo "=== RECALCULATION COMPLETE ===\n";
echo "✅ Updated: {$updatedCount} results\n";
echo "❌ Errors: {$errorCount} results\n";
echo "📊 Total processed: {$results->count()} results\n\n";

// Show summary of changes
if ($updatedCount > 0) {
    echo "=== SUMMARY OF CHANGES ===\n";
    echo "The following changes were made:\n";
    echo "- Applied negative marking for wrong answers\n";
    echo "- Recalculated percentages based on corrected scores\n";
    echo "- Updated correct/wrong/unanswered counts\n";
    echo "- Ensured scores don't go below 0\n\n";
    
    echo "⚠️  IMPORTANT: Please verify the results in your application to ensure accuracy.\n";
}

echo "=== SCRIPT COMPLETED ===\n";
