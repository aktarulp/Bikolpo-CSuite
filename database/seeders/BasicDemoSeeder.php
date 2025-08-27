<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Partner;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\QuestionType;
use App\Models\Question;
// use App\Models\QuestionSet;
use App\Models\Exam;
use App\Models\Student;
use Carbon\Carbon;

class BasicDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding basic demo data...');

        // Get or create a partner user
        $partnerUser = User::firstOrCreate(
            ['email' => 'partner@demo.com'],
            [
                'name' => 'Demo Partner',
                'password' => bcrypt('password'),
                'role' => 'partner',
            ]
        );

        // Get or create a partner
        $partner = Partner::firstOrCreate(
            ['email' => 'info@demo.com'],
            [
                'name' => 'Demo Coaching Center',
                'phone' => '+880 1234567890',
                'user_id' => $partnerUser->id,
                'address' => 'Dhaka, Bangladesh',
                'city' => 'Dhaka',
                'description' => 'A demo coaching center for testing purposes',
                'status' => 'active',
            ]
        );

        // Get or create question types
        $mcqType = QuestionType::firstOrCreate(
            ['q_type_name' => 'Multiple Choice Question (MCQ)'],
            [
                'q_type_code' => 'MCQ',
                'description' => 'Questions with multiple choice answers',
                'has_options' => true,
                'has_explanation' => true,
                'has_image' => true,
                'has_marks' => true,
                'has_difficulty' => true,
                'sort_order' => 1,
                'partner_id' => $partner->id,
            ]
        );

        $descType = QuestionType::firstOrCreate(
            ['q_type_name' => 'Descriptive Question'],
            [
                'q_type_code' => 'CQ',
                'description' => 'Questions requiring detailed written answers',
                'has_options' => false,
                'has_explanation' => true,
                'has_image' => true,
                'has_marks' => true,
                'has_difficulty' => true,
                'sort_order' => 2,
                'partner_id' => $partner->id,
            ]
        );

        // Get or create courses
        $physics = Course::firstOrCreate(
            ['code' => 'PHY', 'partner_id' => $partner->id],
            [
                'name' => 'Physics',
                'description' => 'HSC Physics course',
                'status' => 'active',
            ]
        );

        $chemistry = Course::firstOrCreate(
            ['code' => 'CHEM', 'partner_id' => $partner->id],
            [
                'name' => 'Chemistry',
                'description' => 'HSC Chemistry course',
                'status' => 'active',
            ]
        );

        $math = Course::firstOrCreate(
            ['code' => 'MATH', 'partner_id' => $partner->id],
            [
                'name' => 'Mathematics',
                'description' => 'HSC Mathematics course',
                'status' => 'active',
            ]
        );

        // Get or create subjects
        $physicsSubject = Subject::firstOrCreate(
            ['code' => 'PHY-HSC', 'partner_id' => $partner->id],
            [
                'course_id' => $physics->id,
                'name' => 'HSC Physics',
                'description' => 'Higher Secondary Physics',
                'status' => 'active',
            ]
        );

        $chemistrySubject = Subject::firstOrCreate(
            ['code' => 'CHEM-HSC', 'partner_id' => $partner->id],
            [
                'course_id' => $chemistry->id,
                'name' => 'HSC Chemistry',
                'description' => 'Higher Secondary Chemistry',
                'status' => 'active',
            ]
        );

        $mathSubject = Subject::firstOrCreate(
            ['code' => 'MATH-HSC', 'partner_id' => $partner->id],
            [
                'course_id' => $math->id,
                'name' => 'HSC Mathematics',
                'description' => 'Higher Secondary Mathematics',
                'status' => 'active',
            ]
        );

        // Get or create topics
        $mechanics = Topic::firstOrCreate(
            ['code' => 'MECH', 'partner_id' => $partner->id],
            [
                'subject_id' => $physicsSubject->id,
                'name' => 'Mechanics',
                'description' => 'Mechanics and motion',
                'chapter_number' => 1,
                'status' => 'active',
            ]
        );

        $thermodynamics = Topic::firstOrCreate(
            ['code' => 'THERMO', 'partner_id' => $partner->id],
            [
                'subject_id' => $physicsSubject->id,
                'name' => 'Thermodynamics',
                'description' => 'Heat and thermodynamics',
                'chapter_number' => 2,
                'status' => 'active',
            ]
        );

        $organic = Topic::firstOrCreate(
            ['code' => 'ORG', 'partner_id' => $partner->id],
            [
                'subject_id' => $chemistrySubject->id,
                'name' => 'Organic Chemistry',
                'description' => 'Organic compounds and reactions',
                'chapter_number' => 1,
                'status' => 'active',
            ]
        );

        $calculus = Topic::firstOrCreate(
            ['code' => 'CALC', 'partner_id' => $partner->id],
            [
                'subject_id' => $mathSubject->id,
                'name' => 'Calculus',
                'description' => 'Differential and integral calculus',
                'chapter_number' => 1,
                'status' => 'active',
            ]
        );

        // Create sample questions
        $this->createSampleQuestions($partner, $mcqType, $descType, $mechanics, $thermodynamics, $organic, $calculus);

        // Create question sets
        // $questionSets = $this->createQuestionSets($partner);

        // Create exams
        $this->createExams($partner, []);

        // Create some students
        $this->createStudents($partner);

        $this->command->info('Basic demo data seeded successfully!');
    }

    private function createSampleQuestions($partner, $mcqType, $descType, $mechanics, $thermodynamics, $organic, $calculus)
    {
        $questions = [
            // Physics MCQ questions
            [
                'topic_id' => $mechanics->id,
                'q_type_id' => $mcqType->id,
                'question_text' => 'What is the SI unit of force?',
                'option_a' => 'Newton',
                'option_b' => 'Joule',
                'option_c' => 'Watt',
                'option_d' => 'Pascal',
                'correct_answer' => 'a',
                'explanation' => 'Force is measured in Newtons (N) in the SI system.',
                'marks' => 1,
                'difficulty_level' => 1,
                'status' => 'active',
                'partner_id' => $partner->id,
            ],
            [
                'topic_id' => $mechanics->id,
                'q_type_id' => $mcqType->id,
                'question_text' => 'Which of the following is a vector quantity?',
                'option_a' => 'Mass',
                'option_b' => 'Temperature',
                'option_c' => 'Velocity',
                'option_d' => 'Time',
                'correct_answer' => 'c',
                'explanation' => 'Velocity has both magnitude and direction, making it a vector quantity.',
                'marks' => 1,
                'difficulty_level' => 2,
                'status' => 'active',
                'partner_id' => $partner->id,
            ],
            [
                'topic_id' => $thermodynamics->id,
                'q_type_id' => $mcqType->id,
                'question_text' => 'What is the first law of thermodynamics?',
                'option_a' => 'Energy cannot be created or destroyed',
                'option_b' => 'Entropy always increases',
                'option_c' => 'Heat flows from hot to cold',
                'option_d' => 'Pressure and volume are inversely proportional',
                'correct_answer' => 'a',
                'explanation' => 'The first law states that energy cannot be created or destroyed, only transformed.',
                'marks' => 1,
                'difficulty_level' => 2,
                'status' => 'active',
                'partner_id' => $partner->id,
            ],
            // Chemistry MCQ questions
            [
                'topic_id' => $organic->id,
                'q_type_id' => $mcqType->id,
                'question_text' => 'What is the general formula for alkanes?',
                'option_a' => 'CnH2n',
                'option_b' => 'CnH2n+2',
                'option_c' => 'CnH2n-2',
                'option_d' => 'CnH2n+1',
                'correct_answer' => 'b',
                'explanation' => 'Alkanes have the general formula CnH2n+2.',
                'marks' => 1,
                'difficulty_level' => 1,
                'status' => 'active',
                'partner_id' => $partner->id,
            ],
            [
                'topic_id' => $organic->id,
                'q_type_id' => $mcqType->id,
                'question_text' => 'Which functional group is present in alcohols?',
                'option_a' => '-COOH',
                'option_b' => '-OH',
                'option_c' => '-CHO',
                'option_d' => '-NH2',
                'correct_answer' => 'b',
                'explanation' => 'Alcohols contain the hydroxyl (-OH) functional group.',
                'marks' => 1,
                'difficulty_level' => 1,
                'status' => 'active',
                'partner_id' => $partner->id,
            ],
            // Mathematics MCQ questions
            [
                'topic_id' => $calculus->id,
                'q_type_id' => $mcqType->id,
                'question_text' => 'What is the derivative of x²?',
                'option_a' => 'x',
                'option_b' => '2x',
                'option_c' => '2x²',
                'option_d' => 'x²',
                'correct_answer' => 'b',
                'explanation' => 'The derivative of x² is 2x using the power rule.',
                'marks' => 1,
                'difficulty_level' => 1,
                'status' => 'active',
                'partner_id' => $partner->id,
            ],
            [
                'topic_id' => $calculus->id,
                'q_type_id' => $mcqType->id,
                'question_text' => 'What is the integral of 2x?',
                'option_a' => 'x²',
                'option_b' => 'x² + C',
                'option_c' => '2x²',
                'option_d' => '2x² + C',
                'correct_answer' => 'b',
                'explanation' => 'The integral of 2x is x² + C, where C is the constant of integration.',
                'marks' => 1,
                'difficulty_level' => 2,
                'status' => 'active',
                'partner_id' => $partner->id,
            ],
            // Descriptive questions
            [
                'topic_id' => $mechanics->id,
                'q_type_id' => $descType->id,
                'question_text' => 'Explain Newton\'s three laws of motion with examples.',
                'explanation' => 'Newton\'s laws describe the relationship between forces and motion.',
                'marks' => 5,
                'difficulty_level' => 3,
                'status' => 'active',
                'partner_id' => $partner->id,
            ],
            [
                'topic_id' => $organic->id,
                'q_type_id' => $descType->id,
                'question_text' => 'Describe the process of fractional distillation of crude oil.',
                'explanation' => 'Fractional distillation separates crude oil into different fractions based on boiling points.',
                'marks' => 5,
                'difficulty_level' => 3,
                'status' => 'active',
                'partner_id' => $partner->id,
            ],
            [
                'topic_id' => $calculus->id,
                'q_type_id' => $descType->id,
                'question_text' => 'Solve the differential equation dy/dx = 2x + 3.',
                'explanation' => 'This is a first-order linear differential equation that can be solved by integration.',
                'marks' => 5,
                'difficulty_level' => 3,
                'status' => 'active',
                'partner_id' => $partner->id,
            ],
        ];

        foreach ($questions as $questionData) {
            // Check if question already exists to avoid duplicates
            $existingQuestion = Question::where('question_text', $questionData['question_text'])
                ->where('partner_id', $partner->id)
                ->first();
            
            if (!$existingQuestion) {
                Question::create($questionData);
            }
        }
    }

    // private function createQuestionSets($partner)
    // {
    //     $questionSets = [];

    //     $setData = [
    //         [
    //             'name' => 'HSC Physics Mock Test 1',
    //             'description' => 'Comprehensive mock test covering HSC Physics syllabus',
    //             'language' => 'English',
    //             'question_limit' => 10,
    //             'status' => 'published'
    //         ],
    //         [
    //             'name' => 'HSC Chemistry Practice Set',
    //             'description' => 'Practice questions for HSC Chemistry examination',
    //             'language' => 'English',
    //             'question_limit' => 8,
    //             'status' => 'published'
    //         ],
    //         [
    //             'name' => 'HSC Mathematics Final Review',
    //             'description' => 'Final review questions for HSC Mathematics',
    //             'language' => 'English',
    //             'question_limit' => 7,
    //             'status' => 'published'
    //         ],
    //     ];

    //     foreach ($setData as $setInfo) {
    //         $questionSet = QuestionSet::firstOrCreate(
    //             ['name' => $setInfo['name'], 'partner_id' => $partner->id],
    //             [
    //                 'description' => $setInfo['description'],
    //             'language' => $setInfo['language'],
    //             'question_limit' => $setInfo['question_limit'],
    //             'status' => $setInfo['status'],
    //             'total_questions' => 0,
    //             'total_marks' => 0,
    //             'time_limit' => rand(60, 120),
    //         ]
    //     );

    //         // Get questions and attach them
    //         $questions = Question::where('partner_id', $partner->id)
    //             ->where('status', 'active')
    //             ->take($setInfo['question_limit'])
    //             ->get();

    //         $questionAttachments = [];
    //         foreach ($questions as $index => $question) {
    //             $questionAttachments[$question->id] = [
    //             'order' => $index + 1,
    //             'marks' => $question->marks ?? 1
    //         ];
    //         }

    //         $questionSet->questions()->attach($questionAttachments);
    //         $questionSet->updateTotals();
            
    //         $questionSets[] = $questionSet;
    //     }

    //     return $questionSets;
    // }

    private function createExams($partner, $questionSets)
    {
        $examData = [
            [
                'title' => 'HSC Physics Final Mock Test',
                'description' => 'Final mock test for HSC Physics examination',
                'start_time' => Carbon::now()->addDays(7),
                'end_time' => Carbon::now()->addDays(30),
                'duration' => 120,
                'passing_marks' => 40,
                'status' => 'published',
                'allow_retake' => false,
                'show_results_immediately' => true,
                'has_negative_marking' => true,
                'negative_marks_per_question' => 0.25
            ],
            [
                'title' => 'HSC Chemistry Practice Exam',
                'description' => 'Practice examination for HSC Chemistry',
                'start_time' => Carbon::now()->addDays(3),
                'end_time' => Carbon::now()->addDays(21),
                'duration' => 90,
                'passing_marks' => 35,
                'status' => 'published',
                'allow_retake' => true,
                'show_results_immediately' => false,
                'has_negative_marking' => false,
                'negative_marks_per_question' => 0
            ],
            [
                'title' => 'HSC Mathematics Review Test',
                'description' => 'Comprehensive review test for HSC Mathematics',
                'start_time' => Carbon::now()->addDays(5),
                'end_time' => Carbon::now()->addDays(25),
                'duration' => 100,
                'passing_marks' => 45,
                'status' => 'published',
                'allow_retake' => false,
                'show_results_immediately' => true,
                'has_negative_marking' => true,
                'negative_marks_per_question' => 0.50
            ],
        ];

        foreach ($examData as $index => $examInfo) {
            Exam::firstOrCreate(
                ['title' => $examInfo['title'], 'partner_id' => $partner->id],
                [
                    'total_questions' => $examInfo['total_questions'] ?? 10,
                    'exam_type' => $examInfo['exam_type'] ?? 'online',
                    'description' => $examInfo['description'],
                    'start_time' => $examInfo['start_time'],
                    'end_time' => $examInfo['end_time'],
                    'duration' => $examInfo['duration'],
                    'passing_marks' => $examInfo['passing_marks'],
                    'status' => $examInfo['status'],
                    'allow_retake' => $examInfo['allow_retake'],
                    'show_results_immediately' => $examInfo['show_results_immediately'],
                    'has_negative_marking' => $examInfo['has_negative_marking'],
                    'negative_marks_per_question' => $examInfo['negative_marks_per_question'],
                ]
            );
        }
    }

    private function createStudents($partner)
    {
        $studentData = [
            ['full_name' => 'Ahmed Khan', 'email' => 'ahmed@demo.com', 'phone' => '+880 1111111111'],
            ['full_name' => 'Fatima Rahman', 'email' => 'fatima@demo.com', 'phone' => '+880 2222222222'],
            ['full_name' => 'Mohammed Ali', 'email' => 'ali@demo.com', 'phone' => '+880 3333333333'],
            ['full_name' => 'Aisha Begum', 'email' => 'aisha@demo.com', 'phone' => '+880 4444444444'],
            ['full_name' => 'Omar Hassan', 'email' => 'omar@demo.com', 'phone' => '+880 5555555555'],
        ];

        foreach ($studentData as $studentInfo) {
            Student::firstOrCreate(
                ['email' => $studentInfo['email']],
                [
                    'full_name' => $studentInfo['full_name'],
                    'phone' => $studentInfo['phone'],
                    'date_of_birth' => '2005-01-01',
                    'gender' => 'male',
                    'address' => 'Dhaka, Bangladesh',
                    'city' => 'Dhaka',
                    'school_college' => 'Demo School',
                    'class_grade' => 'HSC',
                    'status' => 'active',
                    'partner_id' => $partner->id,
                ]
            );
        }
    }
}
