<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Partner;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\Question;
use App\Models\Student;
use App\Models\Batch;
use App\Models\Exam;

echo "=== Partner Data Isolation Verification ===\n\n";

// Get all partners
$partners = Partner::with('user')->get();

if ($partners->count() === 0) {
    echo "No partners found in the database.\n";
    exit;
}

echo "Total Partners: " . $partners->count() . "\n";
echo str_repeat("=", 80) . "\n\n";

foreach ($partners as $partner) {
    $userName = $partner->user ? $partner->user->name : 'No User';
    
    echo "Partner ID: {$partner->id}\n";
    echo "Organization: {$partner->organization_name}\n";
    echo "User: {$userName}\n";
    echo str_repeat("-", 80) . "\n";
    
    // Count all resources for this partner
    $courses = Course::where('partner_id', $partner->id)->count();
    $subjects = Subject::where('partner_id', $partner->id)->count();
    $topics = Topic::where('partner_id', $partner->id)->count();
    $questions = Question::where('partner_id', $partner->id)->count();
    $questionsWithValidCourse = Question::where('partner_id', $partner->id)
        ->whereHas('course', function($q) use ($partner) {
            $q->where('partner_id', $partner->id);
        })
        ->count();
    $students = Student::where('partner_id', $partner->id)->count();
    $batches = Batch::where('partner_id', $partner->id)->count();
    $exams = Exam::where('partner_id', $partner->id)->count();
    
    echo "Resources:\n";
    echo "  Courses:                    {$courses}\n";
    echo "  Subjects:                   {$subjects}\n";
    echo "  Topics:                     {$topics}\n";
    echo "  Questions (Total):          {$questions}\n";
    echo "  Questions (Valid Course):   {$questionsWithValidCourse}\n";
    echo "  Students:                   {$students}\n";
    echo "  Batches:                    {$batches}\n";
    echo "  Exams:                      {$exams}\n";
    
    // Check for data integrity issues
    $issues = [];
    
    // Check for subjects without valid course
    $orphanedSubjects = Subject::where('partner_id', $partner->id)
        ->whereDoesntHave('course', function($q) use ($partner) {
            $q->where('partner_id', $partner->id);
        })
        ->count();
    if ($orphanedSubjects > 0) {
        $issues[] = "{$orphanedSubjects} subjects linked to other partners' courses";
    }
    
    // Check for topics without valid subject
    $orphanedTopics = Topic::where('partner_id', $partner->id)
        ->whereDoesntHave('subject', function($q) use ($partner) {
            $q->where('partner_id', $partner->id);
        })
        ->count();
    if ($orphanedTopics > 0) {
        $issues[] = "{$orphanedTopics} topics linked to other partners' subjects";
    }
    
    // Check for questions without valid course
    $orphanedQuestions = $questions - $questionsWithValidCourse;
    if ($orphanedQuestions > 0) {
        $issues[] = "{$orphanedQuestions} questions without valid course links";
    }
    
    // Check for students without valid course/batch
    $studentsWithInvalidCourse = Student::where('partner_id', $partner->id)
        ->whereNotNull('course_id')
        ->whereDoesntHave('course', function($q) use ($partner) {
            $q->where('partner_id', $partner->id);
        })
        ->count();
    if ($studentsWithInvalidCourse > 0) {
        $issues[] = "{$studentsWithInvalidCourse} students linked to other partners' courses";
    }
    
    $studentsWithInvalidBatch = Student::where('partner_id', $partner->id)
        ->whereNotNull('batch_id')
        ->whereDoesntHave('batch', function($q) use ($partner) {
            $q->where('partner_id', $partner->id);
        })
        ->count();
    if ($studentsWithInvalidBatch > 0) {
        $issues[] = "{$studentsWithInvalidBatch} students linked to other partners' batches";
    }
    
    if (count($issues) > 0) {
        echo "\n⚠️  DATA INTEGRITY ISSUES:\n";
        foreach ($issues as $issue) {
            echo "  - {$issue}\n";
        }
    } else {
        echo "\n✅ No data integrity issues found\n";
    }
    
    echo "\n" . str_repeat("=", 80) . "\n\n";
}

// Summary
echo "SUMMARY\n";
echo str_repeat("=", 80) . "\n";

$totalCourses = Course::count();
$totalSubjects = Subject::count();
$totalTopics = Topic::count();
$totalQuestions = Question::count();
$totalStudents = Student::count();
$totalBatches = Batch::count();
$totalExams = Exam::count();

echo "Total Resources Across All Partners:\n";
echo "  Courses:    {$totalCourses}\n";
echo "  Subjects:   {$totalSubjects}\n";
echo "  Topics:     {$totalTopics}\n";
echo "  Questions:  {$totalQuestions}\n";
echo "  Students:   {$totalStudents}\n";
echo "  Batches:    {$totalBatches}\n";
echo "  Exams:      {$totalExams}\n";

// Check for resources without partner_id
echo "\nResources Without Partner ID (CRITICAL ISSUE):\n";
$coursesWithoutPartner = Course::whereNull('partner_id')->count();
$subjectsWithoutPartner = Subject::whereNull('partner_id')->count();
$topicsWithoutPartner = Topic::whereNull('partner_id')->count();
$questionsWithoutPartner = Question::whereNull('partner_id')->count();
$studentsWithoutPartner = Student::whereNull('partner_id')->count();
$batchesWithoutPartner = Batch::whereNull('partner_id')->count();
$examsWithoutPartner = Exam::whereNull('partner_id')->count();

if ($coursesWithoutPartner > 0) echo "  ⚠️  Courses: {$coursesWithoutPartner}\n";
if ($subjectsWithoutPartner > 0) echo "  ⚠️  Subjects: {$subjectsWithoutPartner}\n";
if ($topicsWithoutPartner > 0) echo "  ⚠️  Topics: {$topicsWithoutPartner}\n";
if ($questionsWithoutPartner > 0) echo "  ⚠️  Questions: {$questionsWithoutPartner}\n";
if ($studentsWithoutPartner > 0) echo "  ⚠️  Students: {$studentsWithoutPartner}\n";
if ($batchesWithoutPartner > 0) echo "  ⚠️  Batches: {$batchesWithoutPartner}\n";
if ($examsWithoutPartner > 0) echo "  ⚠️  Exams: {$examsWithoutPartner}\n";

if ($coursesWithoutPartner === 0 && $subjectsWithoutPartner === 0 && 
    $topicsWithoutPartner === 0 && $questionsWithoutPartner === 0 &&
    $studentsWithoutPartner === 0 && $batchesWithoutPartner === 0 &&
    $examsWithoutPartner === 0) {
    echo "  ✅ All resources have valid partner_id\n";
}

echo "\n" . str_repeat("=", 80) . "\n";
echo "Verification Complete!\n";
