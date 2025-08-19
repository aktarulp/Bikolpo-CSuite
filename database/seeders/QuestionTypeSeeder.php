<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questionTypes = [
            [
                'q_type_name' => 'Multiple Choice Question (MCQ)',
                'q_type_code' => 'MCQ',
                'description' => 'Questions with multiple options where only one answer is correct',
                'status' => 'active',
                'sort_order' => 1,
                'has_options' => true,
                'has_explanation' => true,
                'has_image' => true,
                'has_marks' => true,
                'has_difficulty' => true,
            ],
            [
                'q_type_name' => 'Descriptive Question',
                'q_type_code' => 'DESC',
                'description' => 'Questions requiring detailed written answers',
                'status' => 'active',
                'sort_order' => 2,
                'has_options' => false,
                'has_explanation' => true,
                'has_image' => true,
                'has_marks' => true,
                'has_difficulty' => true,
            ],

            [
                'q_type_name' => 'True/False Question',
                'q_type_code' => 'TF',
                'description' => 'Questions with only two possible answers: True or False',
                'status' => 'active',
                'sort_order' => 3,
                'has_options' => true,
                'has_explanation' => true,
                'has_image' => false,
                'has_marks' => true,
                'has_difficulty' => true,
            ],
            [
                'q_type_name' => 'Fill in the Blanks',
                'q_type_code' => 'FIB',
                'description' => 'Questions where students fill in missing words or phrases',
                'status' => 'active',
                'sort_order' => 4,
                'has_options' => false,
                'has_explanation' => true,
                'has_image' => true,
                'has_marks' => true,
                'has_difficulty' => true,
            ],
        ];

        foreach ($questionTypes as $questionType) {
            DB::table('question_types')->insert($questionType);
        }
    }
}
