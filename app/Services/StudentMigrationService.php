<?php

namespace App\Services;

use App\Models\Student;
use App\Models\StudentMigration;
use App\Models\Course;
use App\Models\Batch;
use Illuminate\Support\Facades\DB;
use Exception;

class StudentMigrationService
{
    /**
     * Migrate a student from one course/batch to another.
     */
    public function migrateStudent(
        Student $student,
        ?Course $toCourse = null,
        ?Batch $toBatch = null,
        string $reason = '',
        string $notes = ''
    ): StudentMigration {
        return DB::transaction(function () use ($student, $toCourse, $toBatch, $reason, $notes) {
            // Get current course and batch
            $fromCourse = $student->course;
            $fromBatch = $student->batch;

            // Validate migration
            $this->validateMigration($student, $toCourse, $toBatch);

            // Create migration record
            $migration = StudentMigration::create([
                'student_id' => $student->id,
                'from_course_id' => $fromCourse?->id,
                'to_course_id' => $toCourse?->id,
                'from_batch_id' => $fromBatch?->id,
                'to_batch_id' => $toBatch?->id,
                'migration_date' => now(),
                'reason' => $reason,
                'status' => 'completed',
                'notes' => $notes,
            ]);

            // Update student's current course and batch
            $student->update([
                'course_id' => $toCourse?->id,
                'batch_id' => $toBatch?->id,
                'enroll_date' => now(), // Reset enrollment date for new course/batch
            ]);

            return $migration;
        });
    }

    /**
     * Validate if migration is allowed.
     */
    private function validateMigration(Student $student, ?Course $toCourse, ?Batch $toBatch): void
    {
        // Check if student is currently enrolled
        if (!$student->course_id && !$student->batch_id) {
            throw new Exception('Student is not currently enrolled in any course or batch.');
        }

        // Check if destination course/batch exists
        if ($toCourse && !$toCourse->exists) {
            throw new Exception('Destination course does not exist.');
        }

        if ($toBatch && !$toBatch->exists) {
            throw new Exception('Destination batch does not exist.');
        }

        // Check if destination course/batch is active
        if ($toCourse && !$toCourse->isActive()) {
            throw new Exception('Destination course is not active.');
        }

        if ($toBatch && !$toBatch->isActive()) {
            throw new Exception('Destination batch is not active.');
        }

        // Check if student is already in the destination course/batch
        if ($toCourse && $student->course_id === $toCourse->id) {
            throw new Exception('Student is already enrolled in the destination course.');
        }

        if ($toBatch && $student->batch_id === $toBatch->id) {
            throw new Exception('Student is already enrolled in the destination batch.');
        }
    }

    /**
     * Get migration history for a student.
     */
    public function getMigrationHistory(Student $student): \Illuminate\Database\Eloquent\Collection
    {
        return $student->migrations()->with(['fromCourse', 'toCourse', 'fromBatch', 'toBatch'])->get();
    }

    /**
     * Get students eligible for migration from a specific course/batch.
     */
    public function getEligibleStudentsForMigration(?Course $course = null, ?Batch $batch = null): \Illuminate\Database\Eloquent\Collection
    {
        $query = Student::query();

        if ($course) {
            $query->where('course_id', $course->id);
        }

        if ($batch) {
            $query->where('batch_id', $batch->id);
        }

        return $query->whereNotNull('course_id')->orWhereNotNull('batch_id')->get();
    }

    /**
     * Get migration statistics for a course.
     */
    public function getCourseMigrationStats(Course $course): array
    {
        $migrationsFrom = $course->migrationsFrom()->count();
        $migrationsTo = $course->migrationsTo()->count();
        $currentStudents = $course->getActiveStudentsCount();

        return [
            'students_migrated_out' => $migrationsFrom,
            'students_migrated_in' => $migrationsTo,
            'current_students' => $currentStudents,
            'net_migration' => $migrationsTo - $migrationsFrom,
        ];
    }

    /**
     * Get migration statistics for a batch.
     */
    public function getBatchMigrationStats(Batch $batch): array
    {
        $migrationsFrom = $batch->migrationsFrom()->count();
        $migrationsTo = $batch->migrationsTo()->count();
        $currentStudents = $batch->enrolledStudents()->count();

        return [
            'students_migrated_out' => $migrationsFrom,
            'students_migrated_in' => $migrationsTo,
            'current_students' => $currentStudents,
            'net_migration' => $migrationsTo - $migrationsFrom,
        ];
    }

    /**
     * Cancel a pending migration.
     */
    public function cancelMigration(StudentMigration $migration): bool
    {
        if ($migration->status !== 'pending') {
            throw new Exception('Only pending migrations can be cancelled.');
        }

        return $migration->update(['status' => 'cancelled']);
    }

    /**
     * Get all pending migrations.
     */
    public function getPendingMigrations(): \Illuminate\Database\Eloquent\Collection
    {
        return StudentMigration::with(['student', 'fromCourse', 'toCourse', 'fromBatch', 'toBatch'])
            ->where('status', 'pending')
            ->get();
    }
}
