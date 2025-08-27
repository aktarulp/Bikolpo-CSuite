<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Partner;
// use App\Models\QuestionSet;
use App\Models\Question;
use App\Models\Exam;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\QuestionType;
use Carbon\Carbon;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding demo exams...');

        // Get the first partner
        $partner = Partner::first();
        if (!$partner) {
            $this->command->error('No partner found. Please run PartnerSeeder first.');
            return;
        }

        // Get some questions to create question sets
        $questions = Question::where('partner_id', $partner->id)
            ->where('status', 'active')
            ->take(50)
            ->get();

        if ($questions->count() < 10) {
            $this->command->error('Not enough questions found. Please run QuestionSeeder first.');
            return;
        }

        // Create question sets
        // $questionSets = $this->createQuestionSets($partner, $questions);

        // Create exams
        $this->createExams($partner, []);

        $this->command->info('Demo exams seeded successfully!');
    }

    // private function createQuestionSets($partner, $questions)
    // {
    //     $questionSets = [];

    //     $setData = [
    //         [
    //             'name' => 'HSC Physics Mock Test 1',
    //         'description' => 'Comprehensive mock test covering HSC Physics syllabus',
    //         'language' => 'English',
    //         'number_of_question' => 25,
    //         'status' => 'published'
    //     ],
    //     [
    //         'name' => 'HSC Chemistry Practice Set',
    //         'description' => 'Practice questions for HSC Chemistry examination',
    //         'language' => 'English',
    //         'number_of_question' => 30,
    //         'status' => 'published'
    //     ],
    //     [
    //         'name' => 'HSC Mathematics Final Review',
    //         'description' => 'Final review questions for HSC Mathematics',
    //         'language' => 'language' => 'English',
    //         'number_of_question' => 35,
    //         'status' => 'published'
    //     ],
    //     [
    //         'name' => 'HSC Biology Sample Test',
    //         'description' => 'Sample test questions for HSC Biology',
    //         'language' => 'English',
    //         'number_of_question' => 20,
    //         'status' => 'published'
    //     ],
    //     [
    //         'name' => 'HSC English Grammar Test',
    //         'description' => 'Grammar and vocabulary test for HSC English',
    //         'language' => 'English',
    //         'number_of_question' => 25,
    //         'status' => 'published'
    //     ],
    //     [
    //         'name' => 'HSC Bangla Sahitya Test',
    //         'description' => 'Bangla literature and grammar test',
    //         'language' => 'Bangla',
    //         'number_of_question' => 30,
    //         'status' => 'published'
    //     ],
    //     [
    //         'name' => 'HSC ICT Practice Test',
    //         'description' => 'Information and Communication Technology practice test',
    //         'language' => 'English',
    //         'number_of_question' => 25,
    //         'status' => 'published'
    //     ],
    //     [
    //         'name' => 'HSC Economics Mock Test',
    //         'description' => 'Mock test for HSC Economics subject',
    //         'language' => 'English',
    //         'number_of_question' => 20,
    //         'status' => 'published'
    //     ]
    // ];

    // foreach ($setData as $setInfo) {
    //     $questionSet = QuestionSet::create([
    //         'partner_id' => $partner->id,
    //         'name' => $setInfo['name'],
    //         'description' => $setInfo['description'],
    //         'language' => $setInfo['language'],
    //         'number_of_question' => $setInfo['number_of_question'],
    //         'status' => $setInfo['status'],
    //         'total_questions' => 0,
    //         'total_marks' => 0,
    //         'time_limit' => rand(60, 180), // Random time limit between 1-3 hours
    //     ]);

    //     // Attach random questions to the question set
    //     $randomQuestions = $questions->random(min($setInfo['number_of_question'], $questions->count()));
    //     $questionAttachments = [];
        
    //     foreach ($randomQuestions as $index => $question) {
    //         $questionAttachments[$question->id] => [
    //         'order' => $index + 1,
    //         'marks' => rand(1, 5) // Random marks between 1-5
    //     ];
    // }

    // $questionSet->questions()->attach($questionAttachments);
    
    // // Update totals
    // $questionSet->updateTotals();
    
    // $questionSets[] = $questionSet;
    // }

    // return $questionSets;
    // }

    private function createExams($partner, $questionSets)
    {
        $examData = [
            [
                'title' => 'HSC Physics Final Mock Test',
                'description' => 'Final mock test for HSC Physics examination',
                'start_time' => Carbon::now()->addDays(7),
                'end_time' => Carbon::now()->addDays(30),
                'duration' => 180, // 3 hours
                'passing_marks' => 40,
                'status' => 'published',
                'allow_retake' => false,
                'show_results_immediately' => true
            ],
            [
                'title' => 'HSC Chemistry Practice Exam',
                'description' => 'Practice examination for HSC Chemistry',
                'start_time' => Carbon::now()->addDays(3),
                'end_time' => Carbon::now()->addDays(21),
                'duration' => 150, // 2.5 hours
                'passing_marks' => 35,
                'status' => 'published',
                'allow_retake' => true,
                'show_results_immediately' => false
            ],
            [
                'title' => 'HSC Mathematics Review Test',
                'description' => 'Comprehensive review test for HSC Mathematics',
                'start_time' => Carbon::now()->addDays(5),
                'end_time' => Carbon::now()->addDays(25),
                'duration' => 200, // 3.33 hours
                'passing_marks' => 45,
                'status' => 'published',
                'allow_retake' => false,
                'show_results_immediately' => true
            ],
            [
                'title' => 'HSC Biology Sample Exam',
                'description' => 'Sample examination for HSC Biology',
                'start_time' => Carbon::now()->addDays(2),
                'end_time' => Carbon::now()->addDays(20),
                'duration' => 120, // 2 hours
                'passing_marks' => 30,
                'status' => 'published',
                'allow_retake' => true,
                'show_results_immediately' => false
            ],
            [
                'title' => 'HSC English Grammar Test',
                'description' => 'Grammar and vocabulary test for HSC English',
                'start_time' => Carbon::now()->addDays(1),
                'end_time' => Carbon::now()->addDays(15),
                'duration' => 90, // 1.5 hours
                'passing_marks' => 25,
                'status' => 'published',
                'allow_retake' => true,
                'show_results_immediately' => true
            ],
            [
                'title' => 'HSC Bangla Sahitya Exam',
                'description' => 'Bangla literature and grammar examination',
                'start_time' => Carbon::now()->addDays(4),
                'end_time' => Carbon::now()->addDays(22),
                'duration' => 150, // 2.5 hours
                'passing_marks' => 35,
                'status' => 'published',
                'allow_retake' => false,
                'show_results_immediately' => false
            ],
            [
                'title' => 'HSC ICT Practice Exam',
                'description' => 'ICT practice examination for HSC students',
                'start_time' => Carbon::now()->addDays(6),
                'end_time' => Carbon::now()->addDays(28),
                'duration' => 120, // 2 hours
                'passing_marks' => 30,
                'status' => 'published',
                'allow_retake' => true,
                'show_results_immediately' => true
            ],
            [
                'title' => 'HSC Economics Mock Test',
                'description' => 'Mock test for HSC Economics subject',
                'start_time' => Carbon::now()->addDays(8),
                'end_time' => Carbon::now()->addDays(35),
                'duration' => 100, // 1.67 hours
                'passing_marks' => 25,
                'status' => 'published',
                'allow_retake' => false,
                'show_results_immediately' => true
            ]
        ];

        foreach ($examData as $index => $examInfo) {
            Exam::create([
                'partner_id' => $partner->id,

                'title' => $examInfo['title'],
                'description' => $examInfo['description'],
                'start_time' => $examInfo['start_time'],
                'end_time' => $examInfo['end_time'],
                'duration' => $examInfo['duration'],
                'passing_marks' => $examInfo['passing_marks'],
                'status' => $examInfo['status'],
                'allow_retake' => $examInfo['allow_retake'],
                'show_results_immediately' => $examInfo['show_results_immediately'],
            ]);
        }
    }
}
