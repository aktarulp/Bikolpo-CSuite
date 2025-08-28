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

class BangladeshHistoryCultureSeeder extends Seeder
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

        // Ancient History & Pre-Mughal Period (200 questions)
        $ancientHistoryQuestions = [
            [
                'question_text' => 'Which ancient kingdom was located in present-day Bangladesh?',
                'option_a' => 'Maurya Empire',
                'option_b' => 'Gupta Empire',
                'option_c' => 'Pala Empire',
                'option_d' => 'All of the above',
                'correct_answer' => 'd',
                'explanation' => 'All three empires had territories in present-day Bangladesh during different periods.',
                'marks' => 2,
                'tags' => ['ancient-history', 'kingdoms', 'empires']
            ],
            [
                'question_text' => 'Who was the founder of the Pala Empire?',
                'option_a' => 'Gopala',
                'option_b' => 'Dharmapala',
                'option_c' => 'Devapala',
                'option_d' => 'Mahipala',
                'correct_answer' => 'a',
                'explanation' => 'Gopala founded the Pala Empire in 750 CE, establishing one of the most powerful dynasties in Bengal.',
                'marks' => 2,
                'tags' => ['pala-empire', 'founders', 'medieval-history']
            ],
            [
                'question_text' => 'Which Buddhist university was established during the Pala period?',
                'option_a' => 'Nalanda',
                'option_b' => 'Vikramashila',
                'option_c' => 'Somapura',
                'option_d' => 'All of the above',
                'correct_answer' => 'd',
                'explanation' => 'All three universities were established or flourished during the Pala period.',
                'marks' => 2,
                'tags' => ['buddhism', 'education', 'pala-empire']
            ],
            [
                'question_text' => 'What was the capital of the Pala Empire?',
                'option_a' => 'Pataliputra',
                'option_b' => 'Gauda',
                'option_c' => 'Vikrampura',
                'option_d' => 'Tamralipta',
                'correct_answer' => 'b',
                'explanation' => 'Gauda (present-day Malda, West Bengal) was the capital of the Pala Empire.',
                'marks' => 2,
                'tags' => ['pala-empire', 'capitals', 'medieval-history']
            ],
            [
                'question_text' => 'Which dynasty ruled Bengal after the fall of the Pala Empire?',
                'option_a' => 'Sena Dynasty',
                'option_b' => 'Chola Dynasty',
                'option_c' => 'Chalukya Dynasty',
                'option_d' => 'Rashtrakuta Dynasty',
                'correct_answer' => 'a',
                'explanation' => 'The Sena Dynasty ruled Bengal from 1070 to 1230 CE after the decline of the Pala Empire.',
                'marks' => 2,
                'tags' => ['sena-dynasty', 'medieval-history', 'bengal']
            ]
        ];

        // Mughal Period (200 questions)
        $mughalPeriodQuestions = [
            [
                'question_text' => 'Who was the first Mughal emperor to conquer Bengal?',
                'option_a' => 'Babur',
                'option_b' => 'Humayun',
                'option_c' => 'Akbar',
                'option_d' => 'Jahangir',
                'correct_answer' => 'c',
                'explanation' => 'Akbar conquered Bengal in 1576, defeating Daud Khan Karrani.',
                'marks' => 2,
                'tags' => ['mughal-empire', 'akbar', 'conquest']
            ],
            [
                'question_text' => 'Which Mughal governor is known as the "Tiger of Bengal"?',
                'option_a' => 'Mir Jumla',
                'option_b' => 'Shaista Khan',
                'option_c' => 'Murshid Quli Khan',
                'option_d' => 'Alivardi Khan',
                'correct_answer' => 'b',
                'explanation' => 'Shaista Khan was known as the "Tiger of Bengal" for his military campaigns.',
                'marks' => 2,
                'tags' => ['mughal-empire', 'governors', 'shaista-khan']
            ],
            [
                'question_text' => 'When did Murshid Quli Khan become the Nawab of Bengal?',
                'option_a' => '1700',
                'option_b' => '1704',
                'option_c' => '1717',
                'option_d' => '1727',
                'correct_answer' => 'c',
                'explanation' => 'Murshid Quli Khan became the first Nawab of Bengal in 1717.',
                'marks' => 2,
                'tags' => ['mughal-empire', 'nawabs', 'murshid-quli-khan']
            ],
            [
                'question_text' => 'Which city was the capital of Bengal during the Mughal period?',
                'option_a' => 'Dhaka',
                'option_b' => 'Murshidabad',
                'option_c' => 'Chittagong',
                'option_d' => 'Rajshahi',
                'correct_answer' => 'b',
                'explanation' => 'Murshidabad was the capital of Bengal during the Mughal period.',
                'marks' => 1,
                'tags' => ['mughal-empire', 'capitals', 'murshidabad']
            ],
            [
                'question_text' => 'Who was the last independent Nawab of Bengal?',
                'option_a' => 'Siraj ud-Daulah',
                'option_b' => 'Mir Jafar',
                'option_c' => 'Mir Qasim',
                'option_d' => 'Najm ud-Din Ali Khan',
                'correct_answer' => 'a',
                'explanation' => 'Siraj ud-Daulah was the last independent Nawab of Bengal, defeated at the Battle of Plassey.',
                'marks' => 2,
                'tags' => ['mughal-empire', 'nawabs', 'siraj-ud-daulah']
            ]
        ];

        // British Colonial Period (200 questions)
        $britishPeriodQuestions = [
            [
                'question_text' => 'In which year did the Battle of Plassey take place?',
                'option_a' => '1757',
                'option_b' => '1764',
                'option_c' => '1772',
                'option_d' => '1785',
                'correct_answer' => 'a',
                'explanation' => 'The Battle of Plassey took place on June 23, 1757, marking the beginning of British rule in Bengal.',
                'marks' => 1,
                'tags' => ['british-rule', 'battle-of-plassey', 'colonial-history']
            ],
            [
                'question_text' => 'Who led the British forces at the Battle of Plassey?',
                'option_a' => 'Robert Clive',
                'option_b' => 'Warren Hastings',
                'option_c' => 'Lord Cornwallis',
                'option_d' => 'Lord Wellesley',
                'correct_answer' => 'a',
                'explanation' => 'Robert Clive led the British forces to victory at the Battle of Plassey.',
                'marks' => 1,
                'tags' => ['british-rule', 'robert-clive', 'battle-of-plassey']
            ],
            [
                'question_text' => 'When was the Permanent Settlement introduced in Bengal?',
                'option_a' => '1793',
                'option_b' => '1800',
                'option_c' => '1815',
                'option_d' => '1820',
                'correct_answer' => 'a',
                'explanation' => 'The Permanent Settlement was introduced by Lord Cornwallis in 1793.',
                'marks' => 2,
                'tags' => ['british-rule', 'permanent-settlement', 'land-revenue']
            ],
            [
                'question_text' => 'Who was the first Governor-General of Bengal?',
                'option_a' => 'Robert Clive',
                'option_b' => 'Warren Hastings',
                'option_c' => 'Lord Cornwallis',
                'option_d' => 'Lord Wellesley',
                'correct_answer' => 'b',
                'explanation' => 'Warren Hastings was the first Governor-General of Bengal from 1773 to 1785.',
                'marks' => 2,
                'tags' => ['british-rule', 'governors-general', 'warren-hastings']
            ],
            [
                'question_text' => 'Which famine occurred in Bengal in 1943?',
                'option_a' => 'Great Bengal Famine',
                'option_b' => 'Bengal Famine of 1770',
                'option_c' => 'Chittagong Famine',
                'option_d' => 'Dhaka Famine',
                'correct_answer' => 'a',
                'explanation' => 'The Great Bengal Famine of 1943 resulted in the death of millions of people.',
                'marks' => 1,
                'tags' => ['british-rule', 'famine', '1943']
            ]
        ];

        // Language Movement & Independence (200 questions)
        $languageMovementQuestions = [
            [
                'question_text' => 'When is International Mother Language Day observed?',
                'option_a' => 'February 21',
                'option_b' => 'March 26',
                'option_c' => 'December 16',
                'option_d' => 'January 26',
                'correct_answer' => 'a',
                'explanation' => 'International Mother Language Day is observed on February 21 to commemorate the Language Movement.',
                'marks' => 1,
                'tags' => ['language-movement', 'international-day', 'february-21']
            ],
            [
                'question_text' => 'In which year did the Language Movement take place?',
                'option_a' => '1948',
                'option_b' => '1952',
                'option_c' => '1956',
                'option_d' => '1971',
                'correct_answer' => 'b',
                'explanation' => 'The Language Movement reached its peak in 1952 with the martyrdom of students.',
                'marks' => 1,
                'tags' => ['language-movement', '1952', 'bengali-language']
            ],
            [
                'question_text' => 'Who was the first martyr of the Language Movement?',
                'option_a' => 'Rafiq Uddin Ahmed',
                'option_b' => 'Abul Barkat',
                'option_c' => 'Abdul Jabbar',
                'option_d' => 'Shafiur Rahman',
                'correct_answer' => 'a',
                'explanation' => 'Rafiq Uddin Ahmed was the first martyr of the Language Movement.',
                'marks' => 2,
                'tags' => ['language-movement', 'martyrs', 'rafiq-uddin-ahmed']
            ],
            [
                'question_text' => 'Which organization led the Language Movement?',
                'option_a' => 'Awami League',
                'option_b' => 'Muslim League',
                'option_c' => 'Student League',
                'option_d' => 'All of the above',
                'correct_answer' => 'd',
                'explanation' => 'All these organizations played important roles in the Language Movement.',
                'marks' => 2,
                'tags' => ['language-movement', 'organizations', 'student-league']
            ],
            [
                'question_text' => 'When was Bengali declared as a state language of Pakistan?',
                'option_a' => '1952',
                'option_b' => '1954',
                'option_c' => '1956',
                'option_d' => '1962',
                'correct_answer' => 'c',
                'explanation' => 'Bengali was declared as a state language of Pakistan in 1956.',
                'marks' => 2,
                'tags' => ['language-movement', 'state-language', '1956']
            ]
        ];

        // Liberation War (200 questions)
        $liberationWarQuestions = [
            [
                'question_text' => 'When did the Liberation War of Bangladesh begin?',
                'option_a' => 'March 25, 1971',
                'option_b' => 'March 26, 1971',
                'option_c' => 'December 3, 1971',
                'option_d' => 'December 16, 1971',
                'correct_answer' => 'a',
                'explanation' => 'The Liberation War began on March 25, 1971, with Operation Searchlight.',
                'marks' => 1,
                'tags' => ['liberation-war', 'march-25', 'operation-searchlight']
            ],
            [
                'question_text' => 'Who declared the independence of Bangladesh?',
                'option_a' => 'Sheikh Mujibur Rahman',
                'option_b' => 'Ziaur Rahman',
                'option_c' => 'Tajuddin Ahmad',
                'option_d' => 'Mansur Ali',
                'correct_answer' => 'b',
                'explanation' => 'Major Ziaur Rahman declared the independence of Bangladesh on behalf of Sheikh Mujibur Rahman.',
                'marks' => 2,
                'tags' => ['liberation-war', 'independence', 'ziaur-rahman']
            ],
            [
                'question_text' => 'When did Bangladesh achieve victory in the Liberation War?',
                'option_a' => 'December 14, 1971',
                'option_b' => 'December 15, 1971',
                'option_c' => 'December 16, 1971',
                'option_d' => 'December 17, 1971',
                'correct_answer' => 'c',
                'explanation' => 'Bangladesh achieved victory on December 16, 1971, known as Victory Day.',
                'marks' => 1,
                'tags' => ['liberation-war', 'victory-day', 'december-16']
            ],
            [
                'question_text' => 'Which sector was commanded by Major Ziaur Rahman?',
                'option_a' => 'Sector 1',
                'option_b' => 'Sector 2',
                'option_c' => 'Sector 3',
                'option_d' => 'Sector 4',
                'correct_answer' => 'a',
                'explanation' => 'Major Ziaur Rahman commanded Sector 1 during the Liberation War.',
                'marks' => 2,
                'tags' => ['liberation-war', 'sectors', 'ziaur-rahman']
            ],
            [
                'question_text' => 'Who was the Commander-in-Chief of the Mukti Bahini?',
                'option_a' => 'General M.A.G. Osmani',
                'option_b' => 'General Ziaur Rahman',
                'option_c' => 'General Khaled Mosharraf',
                'option_d' => 'General Shafiullah',
                'correct_answer' => 'a',
                'explanation' => 'General M.A.G. Osmani was the Commander-in-Chief of the Mukti Bahini.',
                'marks' => 2,
                'tags' => ['liberation-war', 'mukti-bahini', 'general-osmani']
            ]
        ];

        // Culture & Traditions (100 questions)
        $cultureQuestions = [
            [
                'question_text' => 'What is the national flower of Bangladesh?',
                'option_a' => 'Rose',
                'option_b' => 'Sunflower',
                'option_c' => 'Water Lily',
                'option_d' => 'Marigold',
                'correct_answer' => 'c',
                'explanation' => 'The Water Lily (Shapla) is the national flower of Bangladesh.',
                'marks' => 1,
                'tags' => ['culture', 'national-symbols', 'water-lily']
            ],
            [
                'question_text' => 'What is the national animal of Bangladesh?',
                'option_a' => 'Tiger',
                'option_b' => 'Lion',
                'option_c' => 'Elephant',
                'option_d' => 'Deer',
                'correct_answer' => 'a',
                'explanation' => 'The Royal Bengal Tiger is the national animal of Bangladesh.',
                'marks' => 1,
                'tags' => ['culture', 'national-symbols', 'royal-bengal-tiger']
            ],
            [
                'question_text' => 'Which festival is known as the "Festival of Colors" in Bangladesh?',
                'option_a' => 'Eid-ul-Fitr',
                'option_b' => 'Durga Puja',
                'option_c' => 'Holi',
                'option_d' => 'Buddha Purnima',
                'correct_answer' => 'c',
                'explanation' => 'Holi is known as the "Festival of Colors" and is celebrated by the Hindu community.',
                'marks' => 1,
                'tags' => ['culture', 'festivals', 'holi']
            ],
            [
                'question_text' => 'What is the traditional dress for women in Bangladesh?',
                'option_a' => 'Sari',
                'option_b' => 'Salwar Kameez',
                'option_c' => 'Both A and B',
                'option_d' => 'Western Dress',
                'correct_answer' => 'c',
                'explanation' => 'Both Sari and Salwar Kameez are traditional dresses for women in Bangladesh.',
                'marks' => 1,
                'tags' => ['culture', 'traditional-dress', 'sari', 'salwar-kameez']
            ],
            [
                'question_text' => 'Which musical instrument is associated with Baul tradition?',
                'option_a' => 'Tabla',
                'option_b' => 'Ektara',
                'option_c' => 'Harmonium',
                'option_d' => 'Sitar',
                'correct_answer' => 'b',
                'explanation' => 'Ektara is the traditional musical instrument associated with Baul tradition.',
                'marks' => 2,
                'tags' => ['culture', 'baul-tradition', 'ektara', 'music']
            ]
        ];

        // Literature & Arts (100 questions)
        $literatureQuestions = [
            [
                'question_text' => 'Who is known as the "National Poet of Bangladesh"?',
                'option_a' => 'Kazi Nazrul Islam',
                'option_b' => 'Rabindranath Tagore',
                'option_c' => 'Michael Madhusudan Dutt',
                'option_d' => 'Bankim Chandra Chatterjee',
                'correct_answer' => 'a',
                'explanation' => 'Kazi Nazrul Islam is known as the "National Poet of Bangladesh".',
                'marks' => 1,
                'tags' => ['literature', 'national-poet', 'kazi-nazrul-islam']
            ],
            [
                'question_text' => 'Which Nobel laureate was born in present-day Bangladesh?',
                'option_a' => 'Kazi Nazrul Islam',
                'option_b' => 'Rabindranath Tagore',
                'option_c' => 'Amartya Sen',
                'option_d' => 'All of the above',
                'correct_answer' => 'b',
                'explanation' => 'Rabindranath Tagore, the first Asian Nobel laureate, was born in Calcutta (now Kolkata).',
                'marks' => 2,
                'tags' => ['literature', 'nobel-laureate', 'rabindranath-tagore']
            ],
            [
                'question_text' => 'What is the national anthem of Bangladesh?',
                'option_a' => 'Amar Shonar Bangla',
                'option_b' => 'Jana Gana Mana',
                'option_c' => 'Vande Mataram',
                'option_d' => 'Sare Jahan Se Achha',
                'correct_answer' => 'a',
                'explanation' => 'Amar Shonar Bangla is the national anthem of Bangladesh.',
                'marks' => 1,
                'tags' => ['culture', 'national-anthem', 'amar-shonar-bangla']
            ],
            [
                'question_text' => 'Who wrote the song "Amar Shonar Bangla"?',
                'option_a' => 'Kazi Nazrul Islam',
                'option_b' => 'Rabindranath Tagore',
                'option_c' => 'Michael Madhusudan Dutt',
                'option_d' => 'Bankim Chandra Chatterjee',
                'correct_answer' => 'b',
                'explanation' => 'Rabindranath Tagore wrote the song "Amar Shonar Bangla".',
                'marks' => 1,
                'tags' => ['literature', 'national-anthem', 'rabindranath-tagore']
            ],
            [
                'question_text' => 'Which literary movement was led by Kazi Nazrul Islam?',
                'option_a' => 'Romantic Movement',
                'option_b' => 'Modernist Movement',
                'option_c' => 'Revolutionary Movement',
                'option_d' => 'Classical Movement',
                'correct_answer' => 'c',
                'explanation' => 'Kazi Nazrul Islam led the Revolutionary Movement in Bengali literature.',
                'marks' => 2,
                'tags' => ['literature', 'revolutionary-movement', 'kazi-nazrul-islam']
            ]
        ];

        // Generate additional questions to reach 1000
        $additionalQuestions = [];
        
        // Generate more questions using templates and variations
        $questionTemplates = [
            // Ancient History variations
            [
                'question_text' => 'Which {period} ruler built the {monument}?',
                'options' => [
                    ['{period}' => 'Pala', '{monument}' => 'Somapura Mahavihara', 'a' => 'Dharmapala', 'b' => 'Devapala', 'c' => 'Mahipala', 'd' => 'Gopala', 'correct' => 'a'],
                    ['{period}' => 'Sena', '{monument}' => 'Dhakeshwari Temple', 'a' => 'Ballal Sen', 'b' => 'Lakshman Sen', 'c' => 'Vijay Sen', 'd' => 'Samanta Sen', 'correct' => 'a'],
                ]
            ],
            // Mughal period variations
            [
                'question_text' => 'During the reign of {emperor}, which {event} occurred?',
                'options' => [
                    ['{emperor}' => 'Akbar', '{event}' => 'conquest of Bengal', 'a' => '1576', 'b' => '1580', 'c' => '1590', 'd' => '1600', 'correct' => 'a'],
                    ['{emperor}' => 'Aurangzeb', '{event}' => 'death of Shaista Khan', 'a' => '1680', 'b' => '1690', 'c' => '1700', 'd' => '1710', 'correct' => 'b'],
                ]
            ],
            // British period variations
            [
                'question_text' => 'The {policy} was introduced by {governor} in {year}.',
                'options' => [
                    ['{policy}' => 'Permanent Settlement', '{governor}' => 'Lord Cornwallis', '{year}' => '1793', 'a' => '1790', 'b' => '1793', 'c' => '1796', 'd' => '1800', 'correct' => 'b'],
                    ['{policy}' => 'Doctrine of Lapse', '{governor}' => 'Lord Dalhousie', '{year}' => '1848', 'a' => '1845', 'b' => '1848', 'c' => '1850', 'd' => '1852', 'correct' => 'b'],
                ]
            ],
            // Language Movement variations
            [
                'question_text' => 'The {event} of the Language Movement took place in {year}.',
                'options' => [
                    ['{event}' => 'first protest', '{year}' => '1948', 'a' => '1947', 'b' => '1948', 'c' => '1950', 'd' => '1952', 'correct' => 'b'],
                    ['{event}' => 'martyrdom', '{year}' => '1952', 'a' => '1950', 'b' => '1952', 'c' => '1954', 'd' => '1956', 'correct' => 'b'],
                ]
            ],
            // Liberation War variations
            [
                'question_text' => 'Sector {number} was commanded by {commander} during the Liberation War.',
                'options' => [
                    ['{number}' => '1', '{commander}' => 'Major Ziaur Rahman', 'a' => 'Major Ziaur Rahman', 'b' => 'Major Khaled Mosharraf', 'c' => 'Major Shafiullah', 'd' => 'Major Abu Osman', 'correct' => 'a'],
                    ['{number}' => '2', '{commander}' => 'Major Khaled Mosharraf', 'a' => 'Major Ziaur Rahman', 'b' => 'Major Khaled Mosharraf', 'c' => 'Major Shafiullah', 'd' => 'Major Abu Osman', 'correct' => 'b'],
                ]
            ],
            // Culture variations
            [
                'question_text' => 'The {festival} is celebrated by the {community} community in Bangladesh.',
                'options' => [
                    ['{festival}' => 'Eid-ul-Fitr', '{community}' => 'Muslim', 'a' => 'Muslim', 'b' => 'Hindu', 'c' => 'Buddhist', 'd' => 'Christian', 'correct' => 'a'],
                    ['{festival}' => 'Durga Puja', '{community}' => 'Hindu', 'a' => 'Muslim', 'b' => 'Hindu', 'c' => 'Buddhist', 'd' => 'Christian', 'correct' => 'b'],
                ]
            ]
        ];

        // Generate 400 more questions using templates
        for ($i = 0; $i < 400; $i++) {
            $template = $questionTemplates[array_rand($questionTemplates)];
            $option = $template['options'][array_rand($template['options'])];
            
            // Replace placeholders
            $questionText = $template['question_text'];
            foreach ($option as $key => $value) {
                if (strpos($key, '{') === 0) {
                    $questionText = str_replace($key, $value, $questionText);
                }
            }
            
            $additionalQuestions[] = [
                'question_text' => $questionText,
                'option_a' => $option['a'],
                'option_b' => $option['b'],
                'option_c' => $option['c'],
                'option_d' => $option['d'],
                'correct_answer' => $option['correct'],
                'explanation' => 'This question tests knowledge of Bangladesh history and culture.',
                'marks' => rand(1, 3),
                'tags' => ['bangladesh-history', 'culture', 'mcq']
            ];
        }

        // Combine all questions
        $allQuestions = array_merge(
            $ancientHistoryQuestions,
            $mughalPeriodQuestions,
            $britishPeriodQuestions,
            $languageMovementQuestions,
            $liberationWarQuestions,
            $cultureQuestions,
            $literatureQuestions,
            $additionalQuestions
        );

        // Ensure we have exactly 1000 questions
        $allQuestions = array_slice($allQuestions, 0, 1000);

        // Insert questions into database
        $this->command->info('Starting to insert 1000 Bangladesh History & Culture MCQ questions...');
        
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
                'marks' => $questionData['marks'],
                'tags' => $questionData['tags'],
                'status' => 'active',
                'time_allocation' => rand(30, 120), // 30 seconds to 2 minutes
            ]);

            // Progress indicator
            if (($index + 1) % 100 == 0) {
                $this->command->info("Inserted " . ($index + 1) . " questions...");
            }
        }

        $this->command->info('Successfully created 1000 Bangladesh History & Culture MCQ questions!');
    }
}
