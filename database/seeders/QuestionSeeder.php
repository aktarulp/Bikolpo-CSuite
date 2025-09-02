<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\Partner;
use App\Models\QuestionType;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a partner
        $partner = Partner::firstOrCreate(['id' => 1], [
            'name' => 'Test Partner',
            'email' => 'partner@test.com',
            'phone' => '1234567890',
            'address' => 'Test Address',
            'status' => 'active'
        ]);

        // Get or create a course
        $course = Course::firstOrCreate(['id' => 1], [
            'name' => 'Test Course',
            'code' => 'TC001',
            'description' => 'Test Course Description',
            'status' => 'active'
        ]);

        // Get or create a subject
        $subject = Subject::firstOrCreate(['id' => 1], [
            'course_id' => $course->id,
            'name' => 'Test Subject',
            'code' => 'TS001',
            'description' => 'Test Subject Description',
            'status' => 'active'
        ]);

        // Get or create a topic
        $topic = Topic::firstOrCreate(['id' => 1], [
            'subject_id' => $subject->id,
            'name' => 'Test Topic',
            'code' => 'TT001',
            'description' => 'Test Topic Description',
            'chapter_number' => 1,
            'status' => 'active'
        ]);

        // Get the MCQ question type
        $mcqType = QuestionType::where('q_type_code', 'MCQ')->first();

        // Create a test MCQ question
        Question::firstOrCreate(['id' => 1], [
            'question_type' => 'mcq',
            'q_type_id' => $mcqType ? $mcqType->q_type_id : null,
            'course_id' => $course->id,
            'subject_id' => $subject->id,
            'topic_id' => $topic->id,
            'partner_id' => $partner->id,
            'question_text' => 'What is the capital of Bangladesh?',
            'option_a' => 'Dhaka',
            'option_b' => 'Chittagong',
            'option_c' => 'Sylhet',
            'option_d' => 'Rajshahi',
            'correct_answer' => 'a',
            'explanation' => 'Dhaka is the capital and largest city of Bangladesh.',


            'status' => 'active'
        ]);
    }
}
