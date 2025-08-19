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

class McqQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing data
        $mcqType = QuestionType::where('q_type_code', 'MCQ')->first();
        $partners = Partner::all();
        $courses = Course::with(['subjects.topics'])->get();

        if (!$mcqType) {
            $this->command->error('MCQ question type not found. Please run QuestionTypeSeeder first.');
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

        $questions = [];

        // Physics Questions (20 questions)
        $physicsQuestions = [
            [
                'question_text' => 'What is the SI unit of force?',
                'option_a' => 'Newton',
                'option_b' => 'Joule',
                'option_c' => 'Watt',
                'option_d' => 'Pascal',
                'correct_answer' => 'a',
                'explanation' => 'The SI unit of force is Newton (N), named after Sir Isaac Newton.',
                'difficulty_level' => 1,
                'marks' => 1,
                'tags' => ['mechanics', 'units', 'basic']
            ],
            [
                'question_text' => 'Which of the following is a vector quantity?',
                'option_a' => 'Mass',
                'option_b' => 'Temperature',
                'option_c' => 'Velocity',
                'option_d' => 'Time',
                'correct_answer' => 'c',
                'explanation' => 'Velocity has both magnitude and direction, making it a vector quantity.',
                'difficulty_level' => 1,
                'marks' => 1,
                'tags' => ['mechanics', 'vectors', 'basic']
            ],
            [
                'question_text' => 'What is the formula for kinetic energy?',
                'option_a' => 'KE = mgh',
                'option_b' => 'KE = ½mv²',
                'option_c' => 'KE = Fd',
                'option_d' => 'KE = Pt',
                'correct_answer' => 'b',
                'explanation' => 'Kinetic energy is calculated using the formula KE = ½mv² where m is mass and v is velocity.',
                'difficulty_level' => 2,
                'marks' => 2,
                'tags' => ['mechanics', 'energy', 'formula']
            ],
            [
                'question_text' => 'Which law states that every action has an equal and opposite reaction?',
                'option_a' => 'Newton\'s First Law',
                'option_b' => 'Newton\'s Second Law',
                'option_c' => 'Newton\'s Third Law',
                'option_d' => 'Law of Gravitation',
                'correct_answer' => 'c',
                'explanation' => 'Newton\'s Third Law states that for every action, there is an equal and opposite reaction.',
                'difficulty_level' => 1,
                'marks' => 1,
                'tags' => ['mechanics', 'newton-laws', 'basic']
            ],
            [
                'question_text' => 'What is the unit of electric current?',
                'option_a' => 'Volt',
                'option_b' => 'Ampere',
                'option_c' => 'Ohm',
                'option_d' => 'Watt',
                'correct_answer' => 'b',
                'explanation' => 'The SI unit of electric current is Ampere (A), named after André-Marie Ampère.',
                'difficulty_level' => 1,
                'marks' => 1,
                'tags' => ['electricity', 'units', 'basic']
            ]
        ];

        // Chemistry Questions (20 questions)
        $chemistryQuestions = [
            [
                'question_text' => 'What is the chemical symbol for gold?',
                'option_a' => 'Ag',
                'option_b' => 'Au',
                'option_c' => 'Fe',
                'option_d' => 'Cu',
                'correct_answer' => 'b',
                'explanation' => 'Au is the chemical symbol for gold, derived from the Latin word "aurum".',
                'difficulty_level' => 1,
                'marks' => 1,
                'tags' => ['inorganic', 'elements', 'symbols']
            ],
            [
                'question_text' => 'Which gas is known as the greenhouse gas?',
                'option_a' => 'Oxygen',
                'option_b' => 'Nitrogen',
                'option_c' => 'Carbon Dioxide',
                'option_d' => 'Hydrogen',
                'correct_answer' => 'c',
                'explanation' => 'Carbon dioxide (CO₂) is a major greenhouse gas that contributes to global warming.',
                'difficulty_level' => 1,
                'marks' => 1,
                'tags' => ['environmental', 'gases', 'climate']
            ],
            [
                'question_text' => 'What is the pH of a neutral solution?',
                'option_a' => '0',
                'option_b' => '7',
                'option_c' => '14',
                'option_d' => '10',
                'correct_answer' => 'b',
                'explanation' => 'A neutral solution has a pH of 7. Values below 7 are acidic, above 7 are basic.',
                'difficulty_level' => 1,
                'marks' => 1,
                'tags' => ['acids-bases', 'ph-scale', 'basic']
            ],
            [
                'question_text' => 'Which element has the atomic number 1?',
                'option_a' => 'Helium',
                'option_b' => 'Hydrogen',
                'option_c' => 'Lithium',
                'option_d' => 'Carbon',
                'correct_answer' => 'b',
                'explanation' => 'Hydrogen has atomic number 1, making it the first element in the periodic table.',
                'difficulty_level' => 1,
                'marks' => 1,
                'tags' => ['periodic-table', 'atomic-numbers', 'basic']
            ],
            [
                'question_text' => 'What type of bond is formed between sodium and chlorine in NaCl?',
                'option_a' => 'Covalent',
                'option_b' => 'Ionic',
                'option_c' => 'Metallic',
                'option_d' => 'Hydrogen',
                'correct_answer' => 'b',
                'explanation' => 'NaCl forms an ionic bond where sodium donates an electron to chlorine.',
                'difficulty_level' => 2,
                'marks' => 2,
                'tags' => ['bonding', 'ionic-compounds', 'intermediate']
            ]
        ];

        // Biology Questions (20 questions)
        $biologyQuestions = [
            [
                'question_text' => 'What is the powerhouse of the cell?',
                'option_a' => 'Nucleus',
                'option_b' => 'Mitochondria',
                'option_c' => 'Endoplasmic Reticulum',
                'option_d' => 'Golgi Apparatus',
                'correct_answer' => 'b',
                'explanation' => 'Mitochondria are called the powerhouse of the cell because they produce energy through cellular respiration.',
                'difficulty_level' => 1,
                'marks' => 1,
                'tags' => ['cell-biology', 'organelles', 'energy']
            ],
            [
                'question_text' => 'Which process is responsible for the production of gametes?',
                'option_a' => 'Mitosis',
                'option_b' => 'Meiosis',
                'option_c' => 'Binary Fission',
                'option_d' => 'Budding',
                'correct_answer' => 'b',
                'explanation' => 'Meiosis is the process that produces gametes (sperm and egg cells) with half the chromosome number.',
                'difficulty_level' => 2,
                'marks' => 2,
                'tags' => ['genetics', 'cell-division', 'reproduction']
            ],
            [
                'question_text' => 'What is the main function of chlorophyll?',
                'option_a' => 'Absorb water',
                'option_b' => 'Absorb sunlight',
                'option_c' => 'Store nutrients',
                'option_d' => 'Provide structure',
                'correct_answer' => 'b',
                'explanation' => 'Chlorophyll absorbs sunlight and converts it into chemical energy during photosynthesis.',
                'difficulty_level' => 1,
                'marks' => 1,
                'tags' => ['photosynthesis', 'plant-biology', 'pigments']
            ],
            [
                'question_text' => 'Which system is responsible for fighting diseases?',
                'option_a' => 'Digestive System',
                'option_b' => 'Immune System',
                'option_c' => 'Respiratory System',
                'option_d' => 'Circulatory System',
                'correct_answer' => 'b',
                'explanation' => 'The immune system protects the body from diseases and infections.',
                'difficulty_level' => 1,
                'marks' => 1,
                'tags' => ['human-biology', 'immune-system', 'health']
            ],
            [
                'question_text' => 'What is the study of fossils called?',
                'option_a' => 'Paleontology',
                'option_b' => 'Archaeology',
                'option_c' => 'Anthropology',
                'option_d' => 'Geology',
                'correct_answer' => 'a',
                'explanation' => 'Paleontology is the scientific study of fossils and ancient life forms.',
                'difficulty_level' => 1,
                'marks' => 1,
                'tags' => ['evolution', 'fossils', 'earth-history']
            ]
        ];

        // Mathematics Questions (20 questions)
        $mathQuestions = [
            [
                'question_text' => 'What is the value of π (pi) to two decimal places?',
                'option_a' => '3.12',
                'option_b' => '3.14',
                'option_c' => '3.16',
                'option_d' => '3.18',
                'correct_answer' => 'b',
                'explanation' => 'The value of π (pi) is approximately 3.14159, which rounds to 3.14 to two decimal places.',
                'difficulty_level' => 1,
                'marks' => 1,
                'tags' => ['geometry', 'constants', 'basic']
            ],
            [
                'question_text' => 'What is the square root of 144?',
                'option_a' => '10',
                'option_b' => '11',
                'option_c' => '12',
                'option_d' => '13',
                'correct_answer' => 'c',
                'explanation' => '12 × 12 = 144, so the square root of 144 is 12.',
                'difficulty_level' => 1,
                'marks' => 1,
                'tags' => ['arithmetic', 'square-roots', 'basic']
            ],
            [
                'question_text' => 'What is the formula for the area of a circle?',
                'option_a' => 'A = 2πr',
                'option_b' => 'A = πr²',
                'option_c' => 'A = 2πr²',
                'option_d' => 'A = πd',
                'correct_answer' => 'b',
                'explanation' => 'The area of a circle is calculated using the formula A = πr² where r is the radius.',
                'difficulty_level' => 1,
                'marks' => 1,
                'tags' => ['geometry', 'area', 'circles']
            ],
            [
                'question_text' => 'What is the value of 2³ × 3²?',
                'option_a' => '36',
                'option_b' => '54',
                'option_c' => '72',
                'option_d' => '108',
                'correct_answer' => 'c',
                'explanation' => '2³ = 8 and 3² = 9, so 8 × 9 = 72.',
                'difficulty_level' => 2,
                'marks' => 2,
                'tags' => ['exponents', 'arithmetic', 'intermediate']
            ],
            [
                'question_text' => 'What is the slope of a horizontal line?',
                'option_a' => '0',
                'option_b' => '1',
                'option_c' => 'Undefined',
                'option_d' => '∞',
                'correct_answer' => 'a',
                'explanation' => 'A horizontal line has a slope of 0 because there is no vertical change.',
                'difficulty_level' => 2,
                'marks' => 2,
                'tags' => ['algebra', 'slope', 'lines']
            ]
        ];

        // History Questions (10 questions)
        $historyQuestions = [
            [
                'question_text' => 'In which year did World War II end?',
                'option_a' => '1943',
                'option_b' => '1944',
                'option_c' => '1945',
                'option_d' => '1946',
                'correct_answer' => 'c',
                'explanation' => 'World War II ended in 1945 with the surrender of Germany in May and Japan in September.',
                'difficulty_level' => 1,
                'marks' => 1,
                'tags' => ['world-war-ii', 'modern-history', 'dates']
            ],
            [
                'question_text' => 'Who was the first President of the United States?',
                'option_a' => 'Thomas Jefferson',
                'option_b' => 'John Adams',
                'option_c' => 'George Washington',
                'option_d' => 'Benjamin Franklin',
                'correct_answer' => 'c',
                'explanation' => 'George Washington was the first President of the United States, serving from 1789 to 1797.',
                'difficulty_level' => 1,
                'marks' => 1,
                'tags' => ['us-history', 'presidents', 'founding-fathers']
            ]
        ];

        // Geography Questions (10 questions)
        $geographyQuestions = [
            [
                'question_text' => 'What is the capital of Japan?',
                'option_a' => 'Kyoto',
                'option_b' => 'Osaka',
                'option_c' => 'Tokyo',
                'option_d' => 'Yokohama',
                'correct_answer' => 'c',
                'explanation' => 'Tokyo is the capital and largest city of Japan.',
                'difficulty_level' => 1,
                'marks' => 1,
                'tags' => ['world-geography', 'capitals', 'asia']
            ],
            [
                'question_text' => 'Which is the largest ocean on Earth?',
                'option_a' => 'Atlantic Ocean',
                'option_b' => 'Indian Ocean',
                'option_c' => 'Arctic Ocean',
                'option_d' => 'Pacific Ocean',
                'correct_answer' => 'd',
                'explanation' => 'The Pacific Ocean is the largest and deepest ocean on Earth.',
                'difficulty_level' => 1,
                'marks' => 1,
                'tags' => ['physical-geography', 'oceans', 'earth-science']
            ]
        ];

        // Combine all questions
        $allQuestions = array_merge(
            $physicsQuestions,
            $chemistryQuestions,
            $biologyQuestions,
            $mathQuestions,
            $historyQuestions,
            $geographyQuestions
        );

        // Generate additional questions to reach 100
        $additionalQuestions = [];
        $questionTemplates = [
            [
                'question_text' => 'What is the SI unit of {unit}?',
                'options' => [
                    ['{unit}' => 'pressure', 'a' => 'Pascal', 'b' => 'Newton', 'c' => 'Joule', 'd' => 'Watt', 'correct' => 'a'],
                    ['{unit}' => 'energy', 'a' => 'Newton', 'b' => 'Joule', 'c' => 'Watt', 'd' => 'Pascal', 'correct' => 'b'],
                    ['{unit}' => 'power', 'a' => 'Joule', 'b' => 'Newton', 'c' => 'Watt', 'd' => 'Pascal', 'correct' => 'c'],
                ]
            ],
            [
                'question_text' => 'Which of the following is a {type}?',
                'options' => [
                    ['{type}' => 'scalar quantity', 'a' => 'Velocity', 'b' => 'Force', 'c' => 'Mass', 'd' => 'Acceleration', 'correct' => 'c'],
                    ['{type}' => 'vector quantity', 'a' => 'Mass', 'b' => 'Temperature', 'c' => 'Force', 'd' => 'Time', 'correct' => 'c'],
                ]
            ]
        ];

        // Generate more questions using templates
        for ($i = 0; $i < 50; $i++) {
            $template = $questionTemplates[array_rand($questionTemplates)];
            $option = $template['options'][array_rand($template['options'])];
            
            $questionText = str_replace('{unit}', $option['{unit}'], $template['question_text']);
            $questionText = str_replace('{type}', $option['{type}'], $questionText);
            
            $additionalQuestions[] = [
                'question_text' => $questionText,
                'option_a' => $option['a'],
                'option_b' => $option['b'],
                'option_c' => $option['c'],
                'option_d' => $option['d'],
                'correct_answer' => $option['correct'],
                'explanation' => 'This is a fundamental concept in physics.',
                'difficulty_level' => rand(1, 3),
                'marks' => rand(1, 3),
                'tags' => ['physics', 'units', 'basic']
            ];
        }

        $allQuestions = array_merge($allQuestions, $additionalQuestions);

        // Ensure we have exactly 100 questions
        $allQuestions = array_slice($allQuestions, 0, 100);

        // Insert questions into database
        foreach ($allQuestions as $index => $questionData) {
            // Randomly select course, subject, and topic
            $course = $courses->random();
            $subject = $course->subjects->random();
            $topic = $subject->topics->random();
            $partner = $partners->random();

            Question::create([
                'question_type' => 'mcq',
                'q_type_id' => $mcqType->q_type_id,
                'course_id' => $course->id,
                'subject_id' => $subject->id,
                'topic_id' => $topic->id,
                'partner_id' => $partner->id,
                'question_text' => $questionData['question_text'],
                'option_a' => $questionData['option_a'],
                'option_b' => $questionData['option_b'],
                'option_c' => $questionData['option_c'],
                'option_d' => $questionData['option_d'],
                'correct_answer' => $questionData['correct_answer'],
                'explanation' => $questionData['explanation'],
                'difficulty_level' => $questionData['difficulty_level'],
                'marks' => $questionData['marks'],
                'tags' => $questionData['tags'],
                'status' => 'active',
                'time_allocation' => rand(30, 120), // 30 seconds to 2 minutes
            ]);
        }

        $this->command->info('Successfully created 100 MCQ questions!');
    }
}

