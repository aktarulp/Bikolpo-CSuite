<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Question;
use App\Models\Course;
use App\Models\Partner;
use App\Models\QuestionType;

class SampleQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mcqType = QuestionType::where('q_type_code', 'MCQ')->first();
        $courses = Course::with(['subjects.topics'])->get();
        $partners = Partner::all();

        if (!$mcqType || $courses->isEmpty() || $partners->isEmpty()) {
            $this->command?->warn('Prerequisites missing: ensure QuestionType, Course/Subject/Topic, and Partner data exist.');
            return;
        }

        $targetCount = 1000;
        $batchSize = 200; // insert in chunks to avoid memory spikes

        $loremStems = [
            'Which of the following statements is true about',
            'Identify the correct option regarding',
            'What is the primary purpose of',
            'Which term best describes',
            'Which formula is used to calculate',
            'What unit is commonly used for',
            'Which concept explains',
            'Which process results in',
            'A correct property of',
            'Choose the best definition of',
        ];

        $domains = [
            'mechanics', 'thermodynamics', 'optics', 'electricity', 'chemistry', 'biology', 'genetics', 'economics', 'geography', 'history'
        ];

        $optionsBank = [
            ['A', 'B', 'C', 'D'],
            ['True', 'False', 'Maybe', 'Unknown'],
            ['High', 'Medium', 'Low', 'None'],
            ['Mass', 'Force', 'Energy', 'Power'],
            ['Atom', 'Molecule', 'Ion', 'Compound'],
            ['Cell', 'Tissue', 'Organ', 'System'],
        ];

        $created = 0;
        while ($created < $targetCount) {
            $chunk = [];
            $limit = min($batchSize, $targetCount - $created);
            for ($i = 0; $i < $limit; $i++) {
                $course = $courses->random();
                $subject = $course->subjects->random();
                $topic = $subject->topics->random();
                $partner = $partners->random();

                $stem = $loremStems[array_rand($loremStems)];
                $domain = $domains[array_rand($domains)];
                $opts = $optionsBank[array_rand($optionsBank)];

                // Ensure unique-ish text
                $questionText = $stem.' '.Str::of($domain.' in '.$topic->name.'?')->trim().' #'.Str::padLeft((string)($created + $i + 1), 4, '0');

                // Map four options to option_a..d
                $optionA = $opts[0];
                $optionB = $opts[1];
                $optionC = $opts[2];
                $optionD = $opts[3];
                $correct = ['a','b','c','d'][array_rand(['a','b','c','d'])];

                $chunk[] = [
                    'question_type' => 'mcq',
                    'q_type_id' => $mcqType->q_type_id,
                    'course_id' => $course->id,
                    'subject_id' => $subject->id,
                    'topic_id' => $topic->id,
                    'partner_id' => $partner->id,
                    'question_text' => (string)$questionText,
                    'option_a' => (string)$optionA,
                    'option_b' => (string)$optionB,
                    'option_c' => (string)$optionC,
                    'option_d' => (string)$optionD,
                    'correct_answer' => $correct,
                    'explanation' => 'Auto-generated sample question for testing and demos.',

                    'marks' => 1,
                    'status' => 'active',
                    'tags' => json_encode([$domain, 'sample', 'auto']),
                    'time_allocation' => rand(30, 90),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Use Query Builder for bulk insert to improve performance
            // We cannot use model casting for JSON here; ensure DB column is json and accept string.
            \DB::table('questions')->insert($chunk);
            $created += $limit;
            $this->command?->info("Inserted {$created}/{$targetCount} sample questions...");
        }

        $this->command?->info('Successfully created 1000 sample MCQ questions.');
    }
}


