<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Batch;
use App\Models\StudentMigration;
use App\Services\StudentMigrationService;
use App\Traits\HasPartnerContext;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StudentMigrationController extends Controller
{
    use HasPartnerContext;
    
    protected $migrationService;

    public function __construct(StudentMigrationService $migrationService)
    {
        $this->migrationService = $migrationService;
    }

    /**
     * Show migration form for a student.
     */
    public function showMigrationForm(Student $student)
    {
        $partnerId = $this->getPartnerId();
        $courses = Course::where('status', 'active')->where('partner_id', $partnerId)->get();
        $batches = Batch::where('status', 'active')->where('partner_id', $partnerId)->get();
        $migrationHistory = $this->migrationService->getMigrationHistory($student);

        return view('partner.students.migration-form', compact('student', 'courses', 'batches', 'migrationHistory'));
    }

    /**
     * Process student migration.
     */
    public function migrateStudent(Request $request, Student $student): JsonResponse
    {
        $request->validate([
            'to_course_id' => 'nullable|exists:courses,id',
            'to_batch_id' => 'nullable|exists:batches,id',
            'reason' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            $toCourse = $request->to_course_id ? Course::find($request->to_course_id) : null;
            $toBatch = $request->to_batch_id ? Batch::find($request->to_batch_id) : null;

            $migration = $this->migrationService->migrateStudent(
                $student,
                $toCourse,
                $toBatch,
                $request->reason,
                $request->notes
            );

            return response()->json([
                'success' => true,
                'message' => 'Student migrated successfully',
                'migration' => $migration->load(['fromCourse', 'toCourse', 'fromBatch', 'toBatch']),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Get migration history for a student.
     */
    public function getMigrationHistory(Student $student): JsonResponse
    {
        $migrations = $this->migrationService->getMigrationHistory($student);

        return response()->json([
            'success' => true,
            'migrations' => $migrations,
        ]);
    }

    /**
     * Get migration statistics for a course.
     */
    public function getCourseMigrationStats(Course $course): JsonResponse
    {
        $stats = $this->migrationService->getCourseMigrationStats($course);

        return response()->json([
            'success' => true,
            'stats' => $stats,
        ]);
    }

    /**
     * Get migration statistics for a batch.
     */
    public function getBatchMigrationStats(Batch $batch): JsonResponse
    {
        $stats = $this->migrationService->getBatchMigrationStats($batch);

        return response()->json([
            'success' => true,
            'stats' => $stats,
        ]);
    }

    /**
     * Cancel a pending migration.
     */
    public function cancelMigration(StudentMigration $migration): JsonResponse
    {
        try {
            $this->migrationService->cancelMigration($migration);

            return response()->json([
                'success' => true,
                'message' => 'Migration cancelled successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Get all pending migrations.
     */
    public function getPendingMigrations(): JsonResponse
    {
        $migrations = $this->migrationService->getPendingMigrations();

        return response()->json([
            'success' => true,
            'migrations' => $migrations,
        ]);
    }
}
