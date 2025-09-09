<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Quick Check: FAZILATUN JAHAN RIVEE - Exam 23 ===\n\n";

// Find student and exam result in one query
$result = DB::table('exam_results as er')
    ->join('students as s', 'er.student_id', '=', 's.id')
    ->join('exams as e', 'er.exam_id', '=', 'e.id')
    ->where('s.full_name', 'LIKE', '%FAZILATUN JAHAN RIVEE%')
    ->where('er.exam_id', 23)
    ->select(
        's.full_name',
        'e.title as exam_title',
        'er.score',
        'er.percentage',
        'er.total_questions',
        'er.correct_answers',
        'er.wrong_answers',
        'er.unanswered',
        'er.status',
        'er.started_at',
        'er.completed_at'
    )
    ->first();

if (!$result) {
    echo "❌ No result found. Let me search for the student first...\n\n";
    
    $student = DB::table('students')
        ->where('full_name', 'LIKE', '%FAZILATUN%')
        ->orWhere('full_name', 'LIKE', '%JAHAN%')
        ->orWhere('full_name', 'LIKE', '%RIVEE%')
        ->select('id', 'full_name')
        ->get();
    
    if ($student->count() > 0) {
        echo "Found students with similar names:\n";
        foreach ($student as $s) {
            echo "- ID: {$s->id}, Name: {$s->full_name}\n";
        }
    } else {
        echo "No students found with similar names.\n";
    }
    exit;
}

echo "✅ Found Result:\n";
echo "Student: {$result->full_name}\n";
echo "Exam: {$result->exam_title}\n";
echo "Final Score: {$result->score}\n";
echo "Percentage: {$result->percentage}%\n";
echo "Total Questions: {$result->total_questions}\n";
echo "Correct: {$result->correct_answers}\n";
echo "Wrong: {$result->wrong_answers}\n";
echo "Unanswered: {$result->unanswered}\n";
echo "Status: {$result->status}\n\n";

// Check question stats
$questionStats = DB::table('question_stats')
    ->where('exam_result_id', function($query) use ($result) {
        $query->select('id')
            ->from('exam_results')
            ->join('students', 'exam_results.student_id', '=', 'students.id')
            ->where('students.full_name', 'LIKE', '%FAZILATUN JAHAN RIVEE%')
            ->where('exam_results.exam_id', 23);
    })
    ->get();

echo "=== Question Statistics ===\n";
$calculatedScore = 0;
$calculatedCorrect = 0;

foreach ($questionStats as $stat) {
    if ($stat->is_correct && $stat->is_answered) {
        $calculatedScore += $stat->marks ?? 1;
        $calculatedCorrect++;
    }
    echo "Q{$stat->question_order}: " . 
         ($stat->is_correct ? 'Correct' : 'Wrong/Unanswered') . 
         " (Marks: " . ($stat->marks ?? 1) . ")\n";
}

echo "\n=== Score Verification ===\n";
echo "Stored Score: {$result->score}\n";
echo "Calculated Score: {$calculatedScore}\n";
echo "Stored Correct: {$result->correct_answers}\n";
echo "Calculated Correct: {$calculatedCorrect}\n\n";

if ($result->score == $calculatedScore) {
    echo "✅ SCORE APPEARS TO BE CORRECT\n";
} else {
    echo "❌ SCORE MISMATCH DETECTED!\n";
    echo "Difference: " . ($result->score - $calculatedScore) . " marks\n";
}

echo "\n=== Analysis Complete ===\n";
