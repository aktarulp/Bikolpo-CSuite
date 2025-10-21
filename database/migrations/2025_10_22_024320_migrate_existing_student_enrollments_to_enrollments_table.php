<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MigrateExistingStudentEnrollmentsToEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * This migration transfers existing student course enrollments
     * from the students table (course_id field) to the new enrollments table.
     *
     * @return void
     */
    public function up()
    {
        // Only migrate if the enrollments table exists and students have course_id
        if (Schema::hasTable('enrollments') && Schema::hasColumn('students', 'course_id')) {
            
            // Get all students who have a course_id
            $students = DB::table('students')
                ->whereNotNull('course_id')
                ->get();

            $migratedCount = 0;

            foreach ($students as $student) {
                // Check if enrollment already exists to avoid duplicates
                $exists = DB::table('enrollments')
                    ->where('student_id', $student->id)
                    ->where('course_id', $student->course_id)
                    ->exists();

                if (!$exists) {
                    DB::table('enrollments')->insert([
                        'student_id' => $student->id,
                        'course_id' => $student->course_id,
                        'batch_id' => $student->batch_id,
                        'partner_id' => $student->partner_id,
                        'enrolled_at' => $student->enroll_date ?? $student->created_at ?? now(),
                        'status' => $this->determineStatus($student),
                        'enrolled_by' => $student->created_by,
                        'created_at' => $student->created_at ?? now(),
                        'updated_at' => $student->updated_at ?? now(),
                    ]);

                    $migratedCount++;
                }
            }

            // Log the migration results
            if ($migratedCount > 0) {
                echo "\n✅ Successfully migrated {$migratedCount} student enrollments to the enrollments table.\n\n";
            } else {
                echo "\nℹ️  No new enrollments to migrate. All students are already in the enrollments table.\n\n";
            }
        } else {
            echo "\n⚠️  Skipping migration: enrollments table or course_id column doesn't exist.\n\n";
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // WARNING: This will delete all enrollments
        // Only use if you're certain you want to remove the data
        if (Schema::hasTable('enrollments')) {
            DB::table('enrollments')->truncate();
            echo "\n⚠️  Enrollments table has been truncated.\n\n";
        }
    }

    /**
     * Determine enrollment status based on student data
     *
     * @param object $student
     * @return string
     */
    private function determineStatus($student)
    {
        // If student status is inactive, mark enrollment as suspended
        if (isset($student->status) && $student->status === 'inactive') {
            return 'suspended';
        }

        // If student has a course and is active, mark as active enrollment
        return 'active';
    }
}
