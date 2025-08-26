<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\Partner;
use App\Models\Student;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\QuestionType;
use App\Models\Question;
use App\Models\QuestionHistory;
use App\Models\Batch;
use App\Models\TypingPassage;
use App\Models\User;

class ConsolidatedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create roles first
        $this->createRoles();
        
        // 2. Create users
        $this->createUsers();
        
        // 3. Create partners
        $this->createPartners();
        
        // 4. Create question types
        $this->createQuestionTypes();
        
        // 5. Create courses, subjects, and topics
        $this->createCourseStructure();
        
        // 6. Create students
        $this->createStudents();
        
        // 7. Create questions
        $this->createQuestions();
        
        // 8. Create question history
        $this->createQuestionHistory();
        
        // 9. Create batches
        $this->createBatches();
        
        // 10. Create typing passages
        $this->createTypingPassages();
    }

    private function createRoles(): void
    {
        if (Role::count() > 0) {
            $this->command->info('Roles already exist, skipping...');
            return;
        }

        $roles = [
            ['name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Full system access'],
            ['name' => 'partner', 'display_name' => 'Partner', 'description' => 'Educational institution partner'],
            ['name' => 'student', 'display_name' => 'Student', 'description' => 'Student user'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        $this->command->info('Roles created successfully!');
    }

    private function createUsers(): void
    {
        if (User::count() > 0) {
            $this->command->info('Users already exist, skipping...');
            return;
        }

        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@csuite.com',
            'password' => bcrypt('password'),
            'role' => 'partner',
            'role_id' => Role::where('name', 'admin')->first()->id,
        ]);

        // Create partner user
        User::create([
            'name' => 'Prottay Partner',
            'email' => 'partner@prottay.com',
            'password' => bcrypt('password'),
            'role' => 'partner',
            'role_id' => Role::where('name', 'partner')->first()->id,
        ]);

        $this->command->info('Users created successfully!');
    }

    private function createPartners(): void
    {
        if (Partner::count() > 0) {
            $this->command->info('Partners already exist, skipping...');
            return;
        }

        $adminUser = User::where('email', 'admin@csuite.com')->first();
        $partnerUser = User::where('email', 'partner@prottay.com')->first();

        // Create main partner
        $partner = Partner::create([
            'name' => 'প্রত্যয় কোচিং সেন্টার',
            'email' => 'info@prottay.com',
            'phone' => '+880 1234567890',
            'user_id' => $partnerUser->id,
            'address' => 'রংপুর, বাংলাদেশ',
            'city' => 'রংপুর',
            'description' => 'প্রত্যয় কোচিং সেন্টার একটি বিশ্বস্ত শিক্ষা প্রতিষ্ঠান যা শিক্ষার্থীদের উচ্চ শিক্ষার জন্য প্রস্তুত করে।',
            'status' => 'active',
            'slug' => 'prottay',
            'institute_name' => 'প্রত্যয় কোচিং সেন্টার',
            'established_year' => 2020,
            'category' => 'Coaching Center',
            'target_group' => 'HSC, SSC Students',
            'subjects_offered' => 'Mathematics, Physics, Chemistry, Biology, English',
            'class_range' => 'Class 6-12',
            'total_teachers' => 15,
            'total_students' => 200,
            'batch_system' => true,
            'subscription_plan' => 'Premium',
            'payment_status' => 'paid',
            'created_by' => $adminUser->id,
        ]);

        // Create comprehensive partner data
        $this->createComprehensivePartnerData($partner);

        $this->command->info('Partners created successfully!');
    }

    private function createComprehensivePartnerData(Partner $partner): void
    {
        $faker = \Faker\Factory::create('bn_BD');

        // Update partner with comprehensive data
        $partner->update([
            'cover_photo' => 'partners/cover_' . $partner->id . '.jpg',
            'owner_name' => $faker->name,
            'mobile' => $faker->phoneNumber,
            'alternate_mobile' => $faker->phoneNumber,
            'website' => $faker->url,
            'facebook_page' => 'https://facebook.com/' . $partner->slug,
            'division' => 'রংপুর',
            'district' => 'রংপুর',
            'upazila' => 'রংপুর সদর',
            'eiin_no' => 'EIIN-' . $faker->numberBetween(100000, 999999),
            'trade_license_no' => 'TL-' . $faker->numberBetween(100000, 999999),
            'tin_no' => 'TIN-' . $faker->numberBetween(100000, 999999),
            'institute_name_bangla' => 'প্রত্যয় কোচিং সেন্টার',
            'slug_bangla' => 'প্রত্যয়-কোচিং-সেন্টার',
            'year_of_establishment' => 2020,
            'short_address' => 'রংপুর সদর, রংপুর',
            'course_offers' => json_encode(['HSC', 'SSC', 'JSC']),
            'custom_courses' => 'Special preparation for medical and engineering entrance exams',
        ]);
    }

    private function createQuestionTypes(): void
    {
        if (QuestionType::count() > 0) {
            $this->command->info('Question types already exist, skipping...');
            return;
        }

        $partner = Partner::first();
        $adminUser = User::where('email', 'admin@csuite.com')->first();

        $questionTypes = [
            [
                'q_type_name' => 'Multiple Choice Question (MCQ)',
                'q_type_code' => 'MCQ',
                'description' => 'Questions with multiple choice answers',
                'has_options' => true,
                'has_explanation' => true,
                'has_image' => true,
                'has_marks' => true,
                'has_difficulty' => true,
                'sort_order' => 1,
                'partner_id' => $partner->id,
                'created_by' => $adminUser->id,
            ],
            [
                'q_type_name' => 'Descriptive Question',
                'q_type_code' => 'DESC',
                'description' => 'Questions requiring detailed written answers',
                'has_options' => false,
                'has_explanation' => true,
                'has_image' => true,
                'has_marks' => true,
                'has_difficulty' => true,
                'sort_order' => 2,
                'partner_id' => $partner->id,
                'created_by' => $adminUser->id,
            ],
        ];

        foreach ($questionTypes as $type) {
            QuestionType::create($type);
        }

        $this->command->info('Question types created successfully!');
    }

    private function createCourseStructure(): void
    {
        if (Course::count() > 0) {
            $this->command->info('Course structure already exists, skipping...');
            return;
        }

        $partner = Partner::first();
        $adminUser = User::where('email', 'admin@csuite.com')->first();

        // Create courses
        $courses = [
            ['name' => 'Higher Secondary Certificate (HSC)', 'code' => 'HSC'],
            ['name' => 'Secondary School Certificate (SSC)', 'code' => 'SSC'],
            ['name' => 'Junior School Certificate (JSC)', 'code' => 'JSC'],
        ];

        foreach ($courses as $courseData) {
            $course = Course::create([
                'name' => $courseData['name'],
                'code' => $courseData['code'],
                'description' => 'Preparation course for ' . $courseData['name'],
                'partner_id' => $partner->id,
                'created_by' => $adminUser->id,
            ]);

            // Create subjects for each course
            $subjects = [
                ['name' => 'Mathematics', 'code' => $courseData['code'] . '_MATH'],
                ['name' => 'Physics', 'code' => $courseData['code'] . '_PHY'],
                ['name' => 'Chemistry', 'code' => $courseData['code'] . '_CHEM'],
                ['name' => 'Biology', 'code' => $courseData['code'] . '_BIO'],
                ['name' => 'English', 'code' => $courseData['code'] . '_ENG'],
            ];

            foreach ($subjects as $subjectData) {
                $subject = Subject::create([
                    'name' => $subjectData['name'],
                    'code' => $subjectData['code'],
                    'description' => $subjectData['name'] . ' for ' . $courseData['name'],
                    'course_id' => $course->id,
                    'partner_id' => $partner->id,
                    'created_by' => $adminUser->id,
                ]);

                // Create topics for each subject
                $topics = [
                    ['name' => 'Unit 1: Fundamentals', 'code' => $subjectData['code'] . '_U1', 'chapter_number' => 1],
                    ['name' => 'Unit 2: Advanced Concepts', 'code' => $subjectData['code'] . '_U2', 'chapter_number' => 2],
                    ['name' => 'Unit 3: Practical Applications', 'code' => $subjectData['code'] . '_U3', 'chapter_number' => 3],
                ];

                foreach ($topics as $topicData) {
                    Topic::create([
                        'name' => $topicData['name'],
                        'code' => $topicData['code'],
                        'description' => $topicData['name'] . ' of ' . $subjectData['name'],
                        'chapter_number' => $topicData['chapter_number'],
                        'subject_id' => $subject->id,
                        'partner_id' => $partner->id,
                        'created_by' => $adminUser->id,
                    ]);
                }
            }
        }

        $this->command->info('Course structure created successfully!');
    }

    private function createStudents(): void
    {
        if (Student::count() > 0) {
            $this->command->info('Students already exist, skipping...');
            return;
        }

        $partner = Partner::first();
        $adminUser = User::where('email', 'admin@csuite.com')->first();
        $faker = \Faker\Factory::create('bn_BD');

        // Create sample students
        for ($i = 1; $i <= 20; $i++) {
            $student = Student::create([
                'full_name' => $faker->name,
                'student_id' => 'STU' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'date_of_birth' => $faker->date('Y-m-d', '-18 years'),
                'gender' => $faker->randomElement(['male', 'female']),
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'city' => 'রংপুর',
                'school_college' => 'রংপুর উচ্চ বিদ্যালয়',
                'class_grade' => $faker->randomElement(['Class 9', 'Class 10', 'Class 11', 'Class 12']),
                'parent_name' => $faker->name,
                'parent_phone' => $faker->phoneNumber,
                'status' => 'active',
                'partner_id' => $partner->id,
                'created_by' => $adminUser->id,
            ]);

            // Create user account for student
            User::create([
                'name' => $student->full_name,
                'email' => $student->email,
                'password' => bcrypt('password'),
                'role' => 'student',
                'role_id' => Role::where('name', 'student')->first()->id,
            ]);
        }

        $this->command->info('Students created successfully!');
    }

    private function createQuestions(): void
    {
        if (Question::count() > 0) {
            $this->command->info('Questions already exist, skipping...');
            return;
        }

        $partner = Partner::first();
        $adminUser = User::where('email', 'admin@csuite.com')->first();
        $mcqType = QuestionType::where('q_type_code', 'MCQ')->first();
        $topics = Topic::take(5)->get();
        $faker = \Faker\Factory::create();

        // Create MCQ questions
        for ($i = 1; $i <= 100; $i++) {
            $topic = $topics->random();
            $subject = $topic->subject;
            $course = $subject->course;

            Question::create([
                'question_type' => 'mcq',
                'course_id' => $course->id,
                'subject_id' => $subject->id,
                'topic_id' => $topic->id,
                'partner_id' => $partner->id,
                'question_text' => "Sample MCQ question {$i} for {$topic->name}?",
                'option_a' => "Option A for question {$i}",
                'option_b' => "Option B for question {$i}",
                'option_c' => "Option C for question {$i}",
                'option_d' => "Option D for question {$i}",
                'correct_answer' => $faker->randomElement(['a', 'b', 'c', 'd']),
                'explanation' => "Explanation for question {$i}",
                'difficulty_level' => $faker->numberBetween(1, 5),
                'marks' => $faker->numberBetween(1, 5),
                'status' => 'active',
                'q_type_id' => $mcqType->q_type_id,
                'created_by' => $adminUser->id,
            ]);
        }

        $this->command->info('Questions created successfully!');
    }

    private function createQuestionHistory(): void
    {
        if (QuestionHistory::count() > 0) {
            $this->command->info('Question history already exists, skipping...');
            return;
        }

        $partner = Partner::first();
        $adminUser = User::where('email', 'admin@csuite.com')->first();
        $questions = Question::take(50)->get();

        foreach ($questions as $question) {
            QuestionHistory::create([
                'question_id' => $question->id,
                'partner_id' => $partner->id,
                'public_exam_name' => 'HSC Examination',
                'exam_month' => 'December',
                'exam_year' => 2024,
                'remarks' => 'Sample question from previous exam',
                'exam_board' => 'Dhaka',
                'exam_type' => 'Public',
                'subject_name' => $question->subject->name,
                'topic_name' => $question->topic->name,
                'question_number' => rand(1, 100),
                'marks_allocated' => rand(1, 5),
                'is_verified' => true,
                'verified_by' => 'Admin',
                'verified_at' => now(),
                'created_by' => $adminUser->id,
            ]);
        }

        $this->command->info('Question history created successfully!');
    }

    private function createBatches(): void
    {
        if (Batch::count() > 0) {
            $this->command->info('Batches already exist, skipping...');
            return;
        }

        $partner = Partner::first();
        $adminUser = User::where('email', 'admin@csuite.com')->first();

        $batches = [
            ['name' => 'HSC 2025 Morning', 'year' => 2025],
            ['name' => 'HSC 2025 Evening', 'year' => 2025],
            ['name' => 'SSC 2025 Morning', 'year' => 2025],
            ['name' => 'SSC 2025 Evening', 'year' => 2025],
        ];

        foreach ($batches as $batchData) {
            Batch::create([
                'name' => $batchData['name'],
                'year' => $batchData['year'],
                'status' => 'active',
                'partner_id' => $partner->id,
                'created_by' => $adminUser->id,
            ]);
        }

        $this->command->info('Batches created successfully!');
    }

    private function createTypingPassages(): void
    {
        if (TypingPassage::count() > 0) {
            $this->command->info('Typing passages already exist, skipping...');
            return;
        }

        $adminUser = User::where('email', 'admin@csuite.com')->first();

        $passages = [
            [
                'passage_text' => 'The quick brown fox jumps over the lazy dog. This pangram contains every letter of the alphabet at least once.',
                'title' => 'Quick Brown Fox',
                'language' => 'english',
                'difficulty' => 'easy',
                'category' => 'general',
                'word_count' => 13,
                'character_count' => 65,
            ],
            [
                'passage_text' => 'আমি বাংলায় গান গাই, আমি বাংলার কথা বলি। বাংলা আমার মাতৃভাষা।',
                'title' => 'বাংলা গান',
                'language' => 'bangla',
                'difficulty' => 'medium',
                'category' => 'literature',
                'word_count' => 8,
                'character_count' => 45,
            ],
        ];

        foreach ($passages as $passageData) {
            TypingPassage::create(array_merge($passageData, [
                'created_by' => $adminUser->id,
            ]));
        }

        $this->command->info('Typing passages created successfully!');
    }
}
