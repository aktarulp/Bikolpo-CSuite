<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\QuestionHistory;
use App\Models\Question;

class QuestionHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some existing questions to create history for
        $questions = Question::take(10)->get();

        if ($questions->isEmpty()) {
            $this->command->info('No questions found. Please run QuestionSeeder first.');
            return;
        }

        $examNames = [
            'CBSE Class 10 Board Exam',
            'CBSE Class 12 Board Exam',
            'ICSE Class 10 Board Exam',
            'ICSE Class 12 Board Exam',
            'JEE Main',
            'NEET',
            'UPSC Civil Services',
            'State Board Class 10',
            'State Board Class 12',
            'CAT',
            'GATE',
            'SSC CGL'
        ];

        $examBoards = [
            'CBSE',
            'ICSE',
            'State Board',
            'JEE',
            'NEET',
            'UPSC',
            'CAT',
            'GATE',
            'SSC'
        ];

        $examTypes = [
            'Board Exam',
            'Competitive Exam',
            'Entrance Exam',
            'Professional Exam',
            'Government Exam'
        ];

        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        $difficultyLevels = ['Easy', 'Medium', 'Hard'];

        foreach ($questions as $question) {
            // Create 1-3 history records for each question
            $numRecords = rand(1, 3);
            
            for ($i = 0; $i < $numRecords; $i++) {
                $examYear = rand(2020, 2025);
                $examMonth = $months[array_rand($months)];
                $examName = $examNames[array_rand($examNames)];
                $examBoard = $examBoards[array_rand($examBoards)];
                $examType = $examTypes[array_rand($examTypes)];
                $difficulty = $difficultyLevels[array_rand($difficultyLevels)];

                QuestionHistory::create([
                    'question_id' => $question->id,
                    'partner_id' => $question->partner_id,
                    'public_exam_name' => $examName,
                    'private_exam_name' => $this->getRandomPrivateExamName(),
                    'exam_month' => $examMonth,
                    'exam_year' => $examYear,
                    'remarks' => $this->getRandomRemarks(),
                    'exam_board' => $examBoard,
                    'exam_type' => $examType,
                    'subject_name' => $question->subject?->name ?? 'Mathematics',
                    'topic_name' => $question->topic?->name ?? 'Algebra',
                    'question_number' => rand(1, 50),
                    'marks_allocated' => rand(1, 5),
                    'difficulty_level' => $difficulty,
                    'source_reference' => $this->getRandomSource(),
                    'is_verified' => rand(0, 1),
                    'verified_by' => rand(0, 1) ? 'Admin User' : null,
                    'verified_at' => rand(0, 1) ? now() : null,
                ]);
            }
        }

        $this->command->info('QuestionHistory seeded successfully!');
    }

    private function getRandomRemarks(): string
    {
        $remarks = [
            'Question appeared in previous year exam',
            'Similar question pattern observed',
            'Important for competitive exams',
            'Frequently asked question',
            'Good practice question',
            'Concept-based question',
            'Application-based question',
            'Previous year question with slight modification'
        ];

        return $remarks[array_rand($remarks)];
    }

    private function getRandomSource(): string
    {
        $sources = [
            'Previous Year Question Papers',
            'Sample Question Papers',
            'Practice Books',
            'Online Resources',
            'Textbook Examples',
            'Competitive Exam Papers',
            'Board Exam Papers',
            'Reference Materials'
        ];

        return $sources[array_rand($sources)];
    }

    private function getRandomPrivateExamName(): string
    {
        $privateExams = [
            'Internal Assessment Test',
            'Mid-Term Examination',
            'End-Term Examination',
            'Practice Test Series',
            'Mock Test',
            'Weekly Quiz',
            'Monthly Test',
            'Unit Test',
            'Revision Test',
            'Final Practice Test'
        ];

        return $privateExams[array_rand($privateExams)];
    }
}
