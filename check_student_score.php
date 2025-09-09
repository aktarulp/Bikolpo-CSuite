<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Student;
use App\Models\ExamResult;
use App\Models\Exam;
use App\Models\QuestionStat;

echo "=== Checking Exam Result for FAZILATUN JAHAN RIVEE on Exam 23 ===\n\n";

// Find the student
$student = Student::where('full_name', 'LIKE', '%FAZILATUN JAHAN RIVEE%')->first();

if (!$student) {
    echo "❌ Student 'FAZILATUN JAHAN RIVEE' not found in database.\n";
    echo "Searching for similar names...\n";
    
    $similarStudents = Student::where('full_name', 'LIKE', '%FAZILATUN%')
        ->orWhere('full_name', 'LIKE', '%JAHAN%')
        ->orWhere('full_name', 'LIKE', '%RIVEE%')
        ->get();
    
    if ($similarStudents->count() > 0) {
        echo "Found similar students:\n";
        foreach ($similarStudents as $s) {
            echo "- ID: {$s->id}, Name: {$s->full_name}\n";
        }
    }
    exit;
}

echo "✅ Student found: {$student->full_name} (ID: {$student->id})\n\n";

// Find exam 23
$exam = Exam::find(23);
if (!$exam) {
    echo "❌ Exam 23 not found in database.\n";
    exit;
}

echo "✅ Exam found: {$exam->title} (ID: {$exam->id})\n\n";

// Find the exam result
$result = ExamResult::where('student_id', $student->id)
    ->where('exam_id', 23)
    ->first();

if (!$result) {
    echo "❌ No exam result found for this student on exam 23.\n";
    exit;
}

echo "=== EXAM RESULT DETAILS ===\n";
echo "Student: {$student->full_name}\n";
echo "Exam: {$exam->title}\n";
echo "Final Score: {$result->score}\n";
echo "Percentage: {$result->percentage}%\n";
echo "Total Questions: {$result->total_questions}\n";
echo "Correct Answers: {$result->correct_answers}\n";
echo "Wrong Answers: {$result->wrong_answers}\n";
echo "Unanswered: {$result->unanswered}\n";
echo "Status: {$result->status}\n";
echo "Started At: {$result->started_at}\n";
echo "Completed At: {$result->completed_at}\n\n";

// Get detailed question statistics
$questionStats = QuestionStat::where('exam_result_id', $result->id)
    ->with('question')
    ->orderBy('question_order')
    ->get();

echo "=== QUESTION-BY-QUESTION BREAKDOWN ===\n";
$calculatedScore = 0;
$calculatedCorrect = 0;
$calculatedWrong = 0;
$calculatedUnanswered = 0;

foreach ($questionStats as $stat) {
    $question = $stat->question;
    $marks = $stat->marks ?? 1;
    
    echo "Q{$stat->question_order}: ";
    echo "Type: {$stat->question_type}, ";
    echo "Marks: {$marks}, ";
    echo "Correct: " . ($stat->is_correct ? 'Yes' : 'No') . ", ";
    echo "Answered: " . ($stat->is_answered ? 'Yes' : 'No') . ", ";
    echo "Skipped: " . ($stat->is_skipped ? 'Yes' : 'No');
    
    if ($stat->is_correct && $stat->is_answered) {
        $calculatedScore += $marks;
        $calculatedCorrect++;
        echo " → +{$marks} marks";
    } elseif ($stat->is_answered && !$stat->is_correct) {
        $calculatedWrong++;
        echo " → 0 marks (wrong)";
    } else {
        $calculatedUnanswered++;
        echo " → 0 marks (unanswered)";
    }
    
    if ($stat->answer_metadata) {
        $metadata = json_decode($stat->answer_metadata, true);
        if (isset($metadata['word_count'])) {
            echo " (Words: {$metadata['word_count']})";
        }
    }
    
    echo "\n";
}

echo "\n=== SCORE VERIFICATION ===\n";
echo "Stored Score: {$result->score}\n";
echo "Calculated Score: {$calculatedScore}\n";
echo "Stored Correct: {$result->correct_answers}\n";
echo "Calculated Correct: {$calculatedCorrect}\n";
echo "Stored Wrong: {$result->wrong_answers}\n";
echo "Calculated Wrong: {$calculatedWrong}\n";
echo "Stored Unanswered: {$result->unanswered}\n";
echo "Calculated Unanswered: {$calculatedUnanswered}\n\n";

if ($result->score == $calculatedScore) {
    echo "✅ SCORE IS CORRECT!\n";
} else {
    echo "❌ SCORE MISMATCH DETECTED!\n";
    echo "The stored score ({$result->score}) does not match the calculated score ({$calculatedScore}).\n";
}

// Check exam settings
echo "\n=== EXAM SETTINGS ===\n";
echo "Has Negative Marking: " . ($exam->has_negative_marking ? 'Yes' : 'No') . "\n";
if ($exam->has_negative_marking) {
    echo "Negative Marks per Question: {$exam->negative_marks_per_question}\n";
    echo "Expected Deduction for Wrong Answers: " . ($result->wrong_answers * $exam->negative_marks_per_question) . " marks\n";
}
echo "Passing Marks: {$exam->passing_marks}%\n";

echo "\n=== ANALYSIS COMPLETE ===\n";
