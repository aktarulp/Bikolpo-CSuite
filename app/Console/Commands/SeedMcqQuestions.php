<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Question;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\QuestionType;
use App\Models\Partner;
use App\Models\User;

class SeedMcqQuestions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:mcq-questions {--user-id= : ID of the user to create questions for} {--partner-id= : ID of the partner to create questions for}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed 100 MCQ questions for a specific user and partner';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get user and partner IDs from command options or find them automatically
        $userId = $this->option('user-id');
        $partnerId = $this->option('partner-id');

        if (!$userId) {
            // Find the first user
            $user = User::first();
            if (!$user) {
                $this->error('No users found in the database. Please create a user first.');
                return 1;
            }
            $userId = $user->id;
        }

        if (!$partnerId) {
            // Find partner for the user
            $user = EnhancedUser::find($userId);
        if (!$user || !$user->partner_id) {
            $this->error("User or partner not found for user ID: {$userId}");
            return;
        }
        $partner = Partner::find($user->partner_id);
            if (!$partner) {
                $this->error("No partner found for user ID {$userId}. Please create a partner first.");
                return 1;
            }
            $partnerId = $partner->id;
        }

        $user = User::find($userId);
        $partner = Partner::find($partnerId);

        if (!$user) {
            $this->error("User with ID {$userId} not found.");
            return 1;
        }

        if (!$partner) {
            $this->error("Partner with ID {$partnerId} not found.");
            return 1;
        }

        $this->info("Creating MCQ questions for:");
        $this->info("User: {$user->name} (ID: {$user->id})");
        $this->info("Partner: {$partner->name} (ID: {$partner->id})");

        // Get or create MCQ question type
        $mcqType = QuestionType::firstOrCreate(
            ['q_type_code' => 'MCQ'],
            [
                'q_type_name' => 'Multiple Choice Question',
                'q_type_code' => 'MCQ',
                'description' => 'Multiple choice questions with 4 options',
                'status' => 'active',
                'sort_order' => 1,
                'has_options' => true,
                'has_explanation' => true,
                'has_image' => false,
                'has_marks' => true,
                'partner_id' => $partner->id,
            ]
        );

        // Get existing courses, subjects, and topics
        $courses = Course::where('partner_id', $partner->id)->get();
        $subjects = Subject::where('partner_id', $partner->id)->get();
        $topics = Topic::where('partner_id', $partner->id)->get();

        if ($courses->isEmpty()) {
            $this->error('No courses found for the partner. Please create courses first.');
            return 1;
        }

        if ($subjects->isEmpty()) {
            $this->error('No subjects found for the partner. Please create subjects first.');
            return 1;
        }

        if ($topics->isEmpty()) {
            $this->error('No topics found for the partner. Please create topics first.');
            return 1;
        }

        // Sample MCQ questions data
        $mcqQuestions = [
            [
                'question_text' => 'What is the capital of Bangladesh?',
                'option_a' => 'Dhaka',
                'option_b' => 'Chittagong',
                'option_c' => 'Sylhet',
                'option_d' => 'Rajshahi',
                'correct_answer' => 'a',
                'explanation' => 'Dhaka is the capital and largest city of Bangladesh.',
                'marks' => 1,
                'tags' => ['geography', 'bangladesh', 'capital'],
                'key_concepts' => ['capital city', 'bangladesh geography'],
                'time_allocation' => 60,
            ],
            [
                'question_text' => 'Which programming language is known as the "language of the web"?',
                'option_a' => 'Python',
                'option_b' => 'Java',
                'option_c' => 'JavaScript',
                'option_d' => 'C++',
                'correct_answer' => 'c',
                'explanation' => 'JavaScript is the primary language used for web development and is often called the "language of the web".',
                'marks' => 1,
                'tags' => ['programming', 'web development', 'javascript'],
                'key_concepts' => ['web development', 'programming languages'],
                'time_allocation' => 60,
            ],
            [
                'question_text' => 'What is the chemical symbol for gold?',
                'option_a' => 'Ag',
                'option_b' => 'Au',
                'option_c' => 'Fe',
                'option_d' => 'Cu',
                'correct_answer' => 'b',
                'explanation' => 'Au is the chemical symbol for gold, derived from the Latin word "aurum".',
                'marks' => 1,
                'tags' => ['chemistry', 'elements', 'gold'],
                'key_concepts' => ['chemical symbols', 'periodic table'],
                'time_allocation' => 60,
            ],
            [
                'question_text' => 'Which planet is known as the Red Planet?',
                'option_a' => 'Venus',
                'option_b' => 'Mars',
                'option_c' => 'Jupiter',
                'option_d' => 'Saturn',
                'correct_answer' => 'b',
                'explanation' => 'Mars is called the Red Planet due to its reddish appearance caused by iron oxide on its surface.',
                'marks' => 1,
                'tags' => ['astronomy', 'planets', 'mars'],
                'key_concepts' => ['solar system', 'planetary characteristics'],
                'time_allocation' => 60,
            ],
            [
                'question_text' => 'What is the largest ocean on Earth?',
                'option_a' => 'Atlantic Ocean',
                'option_b' => 'Indian Ocean',
                'option_c' => 'Arctic Ocean',
                'option_d' => 'Pacific Ocean',
                'correct_answer' => 'd',
                'explanation' => 'The Pacific Ocean is the largest and deepest ocean on Earth, covering about 46% of the Earth\'s water surface.',
                'marks' => 1,
                'tags' => ['geography', 'oceans', 'earth'],
                'key_concepts' => ['oceanography', 'earth geography'],
                'time_allocation' => 60,
            ],
            [
                'question_text' => 'Who wrote "Romeo and Juliet"?',
                'option_a' => 'Charles Dickens',
                'option_b' => 'William Shakespeare',
                'option_c' => 'Jane Austen',
                'option_d' => 'Mark Twain',
                'correct_answer' => 'b',
                'explanation' => 'William Shakespeare wrote the famous tragedy "Romeo and Juliet" in the late 16th century.',
                'marks' => 1,
                'tags' => ['literature', 'shakespeare', 'drama'],
                'key_concepts' => ['english literature', 'tragedy'],
                'time_allocation' => 60,
            ],
            [
                'question_text' => 'What is the square root of 144?',
                'option_a' => '10',
                'option_b' => '11',
                'option_c' => '12',
                'option_d' => '13',
                'correct_answer' => 'c',
                'explanation' => '12 × 12 = 144, so the square root of 144 is 12.',
                'marks' => 1,
                'tags' => ['mathematics', 'algebra', 'square roots'],
                'key_concepts' => ['square roots', 'basic arithmetic'],
                'time_allocation' => 60,
            ],
            [
                'question_text' => 'Which country is home to the kangaroo?',
                'option_a' => 'New Zealand',
                'option_b' => 'South Africa',
                'option_c' => 'Australia',
                'option_d' => 'Brazil',
                'correct_answer' => 'c',
                'explanation' => 'Kangaroos are native to Australia and are one of the country\'s most iconic animals.',
                'marks' => 1,
                'tags' => ['geography', 'australia', 'animals'],
                'key_concepts' => ['australian wildlife', 'marsupials'],
                'time_allocation' => 60,
            ],
            [
                'question_text' => 'What is the main component of the sun?',
                'option_a' => 'Liquid lava',
                'option_b' => 'Molten iron',
                'option_c' => 'Hydrogen gas',
                'option_d' => 'Solid rock',
                'correct_answer' => 'c',
                'explanation' => 'The sun is primarily composed of hydrogen gas (about 74%) and helium (about 24%).',
                'marks' => 1,
                'tags' => ['astronomy', 'sun', 'stars'],
                'key_concepts' => ['stellar composition', 'hydrogen fusion'],
                'time_allocation' => 60,
            ],
            [
                'question_text' => 'Which year did World War II end?',
                'option_a' => '1943',
                'option_b' => '1944',
                'option_c' => '1945',
                'option_d' => '1946',
                'correct_answer' => 'c',
                'explanation' => 'World War II ended in 1945 with the surrender of Germany in May and Japan in September.',
                'marks' => 1,
                'tags' => ['history', 'world war ii', '20th century'],
                'key_concepts' => ['world war ii', 'historical events'],
                'time_allocation' => 60,
            ],
        ];

        // Generate 100 MCQ questions
        $this->info('Generating 100 MCQ questions...');
        
        $bar = $this->output->createProgressBar(100);
        $bar->start();
        
        for ($i = 1; $i <= 100; $i++) {
            // Select random course, subject, and topic
            $course = $courses->random();
            $subject = $subjects->random();
            $topic = $topics->random();
            
            // Use existing question data or create variations
            $baseQuestion = $mcqQuestions[$i % count($mcqQuestions)];
            
            // Create question with slight variations
            $questionData = [
                'question_type' => 'mcq',
                'q_type_id' => $mcqType->q_type_id,
                'course_id' => $course->id,
                'subject_id' => $subject->id,
                'topic_id' => $topic->id,
                'partner_id' => $partner->id,
                'created_by' => $user->id,
                'question_text' => $baseQuestion['question_text'] . ' (Question #' . $i . ')',
                'option_a' => $baseQuestion['option_a'],
                'option_b' => $baseQuestion['option_b'],
                'option_c' => $baseQuestion['option_c'],
                'option_d' => $baseQuestion['option_d'],
                'correct_answer' => $baseQuestion['correct_answer'],
                'explanation' => $baseQuestion['explanation'],
                'expected_answer_points' => 1,
                'marks' => $baseQuestion['marks'],
                'status' => 'active',
                'tags' => $baseQuestion['tags'],
                'key_concepts' => $baseQuestion['key_concepts'],
                'time_allocation' => $baseQuestion['time_allocation'],
                'appearance_history' => [],
            ];

            Question::create($questionData);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info('Successfully created 100 MCQ questions!');
        $this->info("Partner ID: {$partner->id}");
        $this->info("Created by User ID: {$user->id}");
        
        return 0;
    }
}
