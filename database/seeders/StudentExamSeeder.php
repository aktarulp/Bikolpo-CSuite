<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Exam;
use App\Models\StudentExamResult;
use App\Models\ExamAccessCode;
use Carbon\Carbon;

class StudentExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding student exam assignments and results...');

        // Get some students and exams
        $students = Student::take(20)->get();
        $exams = Exam::where('status', 'published')->take(5)->get();

        if ($students->count() === 0) {
            $this->command->error('No students found. Please run StudentSeeder first.');
            return;
        }

        if ($exams->count() === 0) {
            $this->command->error('No exams found. Please run ExamSeeder first.');
            return;
        }

        // Create exam access codes and assign students to exams
        $this->createExamAssignments($students, $exams);

        // Create some exam results
        $this->createExamResults($students, $exams);

        $this->command->info('Student exam data seeded successfully!');
    }

    private function createExamAssignments($students, $exams)
    {
        foreach ($exams as $exam) {
            // Assign 5-10 random students to each exam
            $randomStudents = $students->random(min(10, $students->count()));
            
            foreach ($randomStudents as $student) {
                // Generate unique access code
                $accessCode = $this->generateAccessCode();
                
                ExamAccessCode::create([
                    'exam_id' => $exam->id,
                    'student_id' => $student->id,
                    'access_code' => $accessCode,
                    'is_used' => false,
                    'expires_at' => $exam->end_time,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function createExamResults($students, $exams)
    {
        foreach ($exams as $exam) {
            // Get students assigned to this exam
            $assignedStudents = $exam->assignedStudents;
            
            // Create results for some students (simulating completed exams)
            $completedStudents = $assignedStudents->random(min(5, $assignedStudents->count()));
            
            foreach ($completedStudents as $student) {
                $totalMarks = $exam->total_questions ?? 100;
                $obtainedMarks = rand(30, $totalMarks); // Random score between 30 and total marks
                $passingMarks = $exam->passing_marks ?? 40;
                
                $startTime = Carbon::now()->subDays(rand(1, 30));
                $endTime = $startTime->copy()->addMinutes(rand(30, $exam->duration));
                
                StudentExamResult::create([
                    'exam_id' => $exam->id,
                    'student_id' => $student->id,

                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'total_marks' => $totalMarks,
                    'obtained_marks' => $obtainedMarks,
                    'passing_marks' => $passingMarks,
                    'is_passed' => $obtainedMarks >= $passingMarks,
                    'score_percentage' => round(($obtainedMarks / $totalMarks) * 100, 2),
                    'time_taken_minutes' => $endTime->diffInMinutes($startTime),
                    'status' => 'completed',
                    'created_at' => $startTime,
                    'updated_at' => $endTime,
                ]);

                // Mark access code as used
                ExamAccessCode::where('exam_id', $exam->id)
                    ->where('student_id', $student->id)
                    ->update(['is_used' => true]);
            }
        }
    }

    private function generateAccessCode()
    {
        do {
            $code = strtoupper(substr(md5(uniqid()), 0, 8));
        } while (ExamAccessCode::where('access_code', $code)->exists());
        
        return $code;
    }
}
