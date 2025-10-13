<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProgressPivot;
use App\Models\Student;
use App\Models\Topic;

class ProgressPivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all students and topics
        $students = Student::all();
        $topics = Topic::all();
        
        // If we don't have students or topics, create some sample data
        if ($students->isEmpty() || $topics->isEmpty()) {
            echo "No students or topics found. Please create some students and topics first.\n";
            return;
        }
        
        // Create progress records for each student-topic combination
        foreach ($students as $student) {
            foreach ($topics as $topic) {
                // Generate random progress data
                $totalQuestions = rand(10, 50);
                $attemptedQuestions = rand(0, $totalQuestions);
                $correctAnswers = rand(0, $attemptedQuestions);
                $wrongAnswers = $attemptedQuestions - $correctAnswers;
                $unansweredQuestions = $totalQuestions - $attemptedQuestions;
                
                // Calculate completion percentage
                $completionPercentage = $totalQuestions > 0 ? round(($attemptedQuestions / $totalQuestions) * 100, 2) : 0;
                
                ProgressPivot::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'topic_id' => $topic->id,
                    ],
                    [
                        'completion_percentage' => $completionPercentage,
                        'total_questions' => $totalQuestions,
                        'attempted_questions' => $attemptedQuestions,
                        'correct_answers' => $correctAnswers,
                        'wrong_answers' => $wrongAnswers,
                        'unanswered_questions' => $unansweredQuestions,
                        'last_activity_at' => now(),
                    ]
                );
            }
        }
    }
}