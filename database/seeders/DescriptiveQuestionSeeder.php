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

class DescriptiveQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing data
        $descriptiveType = QuestionType::where('q_type_code', 'DESC')->first();
        $partners = Partner::all();
        $courses = Course::with(['subjects.topics'])->get();

        if (!$descriptiveType) {
            $this->command->error('Descriptive question type not found. Please run QuestionTypeSeeder first.');
            return;
        }

        if ($partners->isEmpty()) {
            $this->command->error('No partners found. Please run PartnerSeeder first.');
            return;
        }

        if ($courses->isEmpty()) {
            $this->command->error('No courses found. Please run CourseSeeder first.');
            return;
        }

        $questions = [
            // Physics Descriptive Questions
            [
                'question_text' => 'Explain the concept of Newton\'s three laws of motion with examples from everyday life.',
                'min_words' => 100,
                'max_words' => 300,
                'explanation' => 'Newton\'s laws describe the relationship between forces and motion. First law: objects at rest stay at rest unless acted upon by a force. Second law: force equals mass times acceleration. Third law: for every action there is an equal and opposite reaction.',
                'marks' => 5,
                'tags' => ['mechanics', 'newton-laws', 'physics']
            ],
            [
                'question_text' => 'Describe the process of energy transformation in a simple pendulum system.',
                'min_words' => 80,
                'max_words' => 250,
                'explanation' => 'A pendulum transforms gravitational potential energy to kinetic energy and back. At the highest point, it has maximum potential energy. As it swings down, potential energy converts to kinetic energy. At the lowest point, it has maximum kinetic energy.',
                'marks' => 4,
                'tags' => ['mechanics', 'energy', 'oscillations']
            ],
            [
                'question_text' => 'What is the difference between scalar and vector quantities? Give three examples of each.',
                'min_words' => 60,
                'max_words' => 200,
                'explanation' => 'Scalar quantities have only magnitude (mass, temperature, time). Vector quantities have both magnitude and direction (velocity, force, acceleration).',
                'marks' => 3,
                'tags' => ['mechanics', 'vectors', 'basic-concepts']
            ],

            // Chemistry Descriptive Questions
            [
                'question_text' => 'Explain the process of photosynthesis and its importance to life on Earth.',
                'min_words' => 120,
                'max_words' => 350,
                'explanation' => 'Photosynthesis is the process where plants convert sunlight, carbon dioxide, and water into glucose and oxygen. This process is crucial as it provides food for plants and oxygen for animals.',
                'marks' => 5,
                'tags' => ['biochemistry', 'photosynthesis', 'plant-biology']
            ],
            [
                'question_text' => 'Describe the structure of an atom and explain how electrons are arranged in different energy levels.',
                'min_words' => 100,
                'max_words' => 300,
                'explanation' => 'An atom consists of a nucleus (protons and neutrons) surrounded by electrons in energy levels or shells. Electrons fill the lowest energy levels first, following the Aufbau principle.',
                'marks' => 4,
                'tags' => ['atomic-structure', 'electron-configuration', 'chemistry']
            ],

            // Biology Descriptive Questions
            [
                'question_text' => 'Explain the process of cell division (mitosis) and its importance in growth and repair.',
                'min_words' => 150,
                'max_words' => 400,
                'explanation' => 'Mitosis is the process where a cell divides to produce two identical daughter cells. It consists of prophase, metaphase, anaphase, and telophase. This process is essential for growth, development, and tissue repair.',
                'marks' => 6,
                'tags' => ['cell-biology', 'mitosis', 'growth']
            ],
            [
                'question_text' => 'Describe the human digestive system and explain how food is broken down and absorbed.',
                'min_words' => 200,
                'max_words' => 500,
                'explanation' => 'The digestive system includes the mouth, esophagus, stomach, small intestine, and large intestine. Food is mechanically and chemically broken down, and nutrients are absorbed in the small intestine.',
                'marks' => 7,
                'tags' => ['human-biology', 'digestive-system', 'nutrition']
            ],

            // Mathematics Descriptive Questions
            [
                'question_text' => 'Explain the concept of derivatives in calculus and provide a real-world application.',
                'min_words' => 100,
                'max_words' => 300,
                'explanation' => 'A derivative represents the rate of change of a function. It measures how a quantity changes with respect to another variable. Real-world applications include velocity (rate of change of position) and acceleration (rate of change of velocity).',
                'marks' => 5,
                'tags' => ['calculus', 'derivatives', 'rate-of-change']
            ],
            [
                'question_text' => 'Describe the process of solving a quadratic equation using the quadratic formula.',
                'min_words' => 80,
                'max_words' => 250,
                'explanation' => 'The quadratic formula x = (-b ± √(b² - 4ac)) / 2a is used to solve equations in the form ax² + bx + c = 0. First identify a, b, and c, then substitute into the formula.',
                'marks' => 4,
                'tags' => ['algebra', 'quadratic-equations', 'formulas']
            ],

            // History Descriptive Questions
            [
                'question_text' => 'Explain the causes and consequences of the Industrial Revolution.',
                'min_words' => 150,
                'max_words' => 400,
                'explanation' => 'The Industrial Revolution was caused by technological innovations, population growth, and agricultural improvements. Consequences included urbanization, social changes, and economic growth.',
                'marks' => 6,
                'tags' => ['modern-history', 'industrial-revolution', 'social-change']
            ],
            [
                'question_text' => 'Describe the key events that led to the American Civil War.',
                'min_words' => 120,
                'max_words' => 350,
                'explanation' => 'Key events included the Missouri Compromise, Kansas-Nebraska Act, Dred Scott decision, and the election of Abraham Lincoln. The main issue was slavery and states\' rights.',
                'marks' => 5,
                'tags' => ['us-history', 'civil-war', 'slavery']
            ],

            // Geography Descriptive Questions
            [
                'question_text' => 'Explain the factors that influence climate and weather patterns.',
                'min_words' => 100,
                'max_words' => 300,
                'explanation' => 'Climate is influenced by latitude, altitude, distance from oceans, ocean currents, and prevailing winds. Weather patterns are affected by air pressure, temperature, humidity, and wind.',
                'marks' => 4,
                'tags' => ['physical-geography', 'climate', 'weather']
            ],
            [
                'question_text' => 'Describe the formation and types of mountains.',
                'min_words' => 120,
                'max_words' => 350,
                'explanation' => 'Mountains are formed through tectonic processes like folding, faulting, and volcanic activity. Types include fold mountains, block mountains, and volcanic mountains.',
                'marks' => 5,
                'tags' => ['physical-geography', 'mountains', 'tectonics']
            ]
        ];

        // Insert questions into database
        foreach ($questions as $index => $questionData) {
            // Randomly select course, subject, and topic
            $course = $courses->random();
            $subject = $course->subjects->random();
            $topic = $subject->topics->random();
            $partner = $partners->random();

            Question::create([
                'question_type' => 'descriptive',
                'q_type_id' => $descriptiveType->q_type_id,
                'course_id' => $course->id,
                'subject_id' => $subject->id,
                'topic_id' => $topic->id,
                'partner_id' => $partner->id,
                'question_text' => $questionData['question_text'],
                'min_words' => $questionData['min_words'],
                'max_words' => $questionData['max_words'],
                'explanation' => $questionData['explanation'],
                'marks' => $questionData['marks'],
                'tags' => $questionData['tags'],
                'status' => 'active',
                'time_allocation' => rand(300, 900), // 5 to 15 minutes for descriptive questions
            ]);
        }

        $this->command->info('Successfully created ' . count($questions) . ' descriptive questions!');
    }
}
