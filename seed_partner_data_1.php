<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Partner;
use App\Models\Student;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Topic;
use App\Models\Subject;
use App\Models\Question;
use App\Models\QuestionType;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/bootstrap/app.php';

$app = require __DIR__.'/bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$targetPartnerId = 1;

echo "Seeding demo data for partner_id = {$targetPartnerId}...\n";

DB::beginTransaction();
try {
    // Ensure the target partner exists, or create it if not.
    $user = User::firstOrCreate(
        ['email' => "partner{$targetPartnerId}@example.com"],
        ['name' => "Partner {$targetPartnerId} User", 'password' => Hash::make('password'), 'role' => 'partner']
    );

    $partner = Partner::firstOrCreate(
        ['id' => $targetPartnerId],
        [
            'name' => "Demo Partner {$targetPartnerId}",
            'email' => "partner{$targetPartnerId}@example.com",
            'user_id' => $user->id,
            'status' => 'active',
            'flag' => 'active',
        ]
    );
    
    // Create Question Types
    $mcqType = QuestionType::firstOrCreate(
        ['q_type_code' => 'MCQ', 'partner_id' => $partner->id],
        ['q_type_name' => 'Multiple Choice Question (MCQ)', 'description' => 'MCQ description']
    );
    $descriptiveType = QuestionType::firstOrCreate(
        ['q_type_code' => 'Descriptive', 'partner_id' => $partner->id],
        ['q_type_name' => 'Descriptive Question', 'description' => 'Descriptive question description']
    );

    // Create Courses
    $course1 = Course::firstOrCreate(
        ['name' => 'Web Development', 'partner_id' => $partner->id],
        ['code' => 'WEBDEV', 'status' => 'active']
    );
    $course2 = Course::firstOrCreate(
        ['name' => 'Data Science', 'partner_id' => $partner->id],
        ['code' => 'DATASCI', 'status' => 'active']
    );

    // Create Subjects
    $subject1 = Subject::firstOrCreate(
        ['name' => 'HTML/CSS', 'course_id' => $course1->id, 'partner_id' => $partner->id],
        ['code' => 'HTMLCSS', 'status' => 'active']
    );
    $subject2 = Subject::firstOrCreate(
        ['name' => 'Python', 'course_id' => $course2->id, 'partner_id' => $partner->id],
        ['code' => 'PYTHON', 'status' => 'active']
    );

    // Create Topics
    $topic1 = Topic::firstOrCreate(
        ['name' => 'Flexbox', 'subject_id' => $subject1->id, 'partner_id' => $partner->id],
        ['code' => 'FLEX', 'chapter_number' => 1, 'status' => 'active']
    );
    $topic2 = Topic::firstOrCreate(
        ['name' => 'Pandas', 'subject_id' => $subject2->id, 'partner_id' => $partner->id],
        ['code' => 'PANDAS', 'chapter_number' => 1, 'status' => 'active']
    );

    // Create Batches
    $batch1 = Batch::firstOrCreate(
        ['name' => 'Summer 2025', 'course_id' => $course1->id, 'partner_id' => $partner->id],
        ['code' => 'SUM25', 'start_date' => '2025-06-01', 'end_date' => '2025-08-31', 'status' => 'active']
    );
    $batch2 = Batch::firstOrCreate(
        ['name' => 'Fall 2025', 'course_id' => $course2->id, 'partner_id' => $partner->id],
        ['code' => 'FALL25', 'start_date' => '2025-09-01', 'end_date' => '2025-11-30', 'status' => 'active']
    );

    // Create Students
    for ($i = 1; $i <= 5; $i++) {
        Student::firstOrCreate(
            ['email' => "student{$i}_partner{$targetPartnerId}@example.com"],
            [
                'partner_id' => $partner->id,
                'user_id' => $user->id, // Associate with the partner's user for simplicity
                'full_name' => "Student {$i} P{$targetPartnerId}",
                'student_id' => "P{$targetPartnerId}S" . str_pad($i, 3, '0', STR_PAD_LEFT),
                'date_of_birth' => '2000-01-01',
                'gender' => 'male',
                'phone' => "+88017" . rand(10000000, 99999999),
                'address' => "Address of Student {$i}",
                'city' => "City {$i}",
                'school_college' => "School {$i}",
                'class_grade' => '12',
                'course_id' => ($i % 2 == 0) ? $course1->id : $course2->id,
                'batch_id' => ($i % 2 == 0) ? $batch1->id : $batch2->id,
                'status' => 'active',
            ]
        );
    }

    // Create Questions
    for ($i = 1; $i <= 10; $i++) {
        Question::firstOrCreate(
            ['question_text' => "MCQ Question {$i} for Partner {$targetPartnerId}", 'partner_id' => $partner->id],
            [
                'q_type_id' => $mcqType->id,
                'course_id' => ($i % 2 == 0) ? $course1->id : $course2->id,
                'subject_id' => ($i % 2 == 0) ? $subject1->id : $subject2->id,
                'topic_id' => ($i % 2 == 0) ? $topic1->id : $topic2->id,
                'question_type' => 'mcq',
                'option_a' => 'Option A',
                'option_b' => 'Option B',
                'option_c' => 'Option C',
                'option_d' => 'Option D',
                'correct_answer' => 'a',
                'explanation' => 'Explanation for MCQ Question ' . $i,
                'difficulty_level' => rand(1, 3),
                'status' => 'active',
            ]
        );
        Question::firstOrCreate(
            ['question_text' => "Descriptive Question {$i} for Partner {$targetPartnerId}", 'partner_id' => $partner->id],
            [
                'q_type_id' => $descriptiveType->id,
                'course_id' => ($i % 2 == 0) ? $course1->id : $course2->id,
                'subject_id' => ($i % 2 == 0) ? $subject1->id : $subject2->id,
                'topic_id' => ($i % 2 == 0) ? $topic1->id : $topic2->id,
                'question_type' => 'descriptive',
                'correct_answer' => 'Sample answer for descriptive question ' . $i,
                'explanation' => 'Explanation for Descriptive Question ' . $i,
                'difficulty_level' => rand(1, 3),
                'status' => 'active',
            ]
        );
    }

    DB::commit();
    echo "Demo data for partner ID {$targetPartnerId} seeded successfully!\n";
} catch (\Exception $e) {
    DB::rollBack();
    echo "Error seeding demo data for partner ID {$targetPartnerId}: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
    exit(1);
}
