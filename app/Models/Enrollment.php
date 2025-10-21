<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Enrollment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'course_id',
        'batch_id',
        'partner_id',
        'enrolled_at',
        'status',
        'completion_date',
        'final_grade',
        'grade_letter',
        'remarks',
        'transferred_to_course_id',
        'transferred_at',
        'enrolled_by',
        'updated_by',
    ];

    protected $casts = [
        'enrolled_at' => 'date',
        'completion_date' => 'date',
        'transferred_at' => 'date',
        'final_grade' => 'decimal:2',
    ];

    /**
     * Status constants for type safety
     */
    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';
    const STATUS_DROPPED = 'dropped';
    const STATUS_SUSPENDED = 'suspended';
    const STATUS_TRANSFERRED = 'transferred';

    /**
     * Get all available statuses
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_DROPPED => 'Dropped',
            self::STATUS_SUSPENDED => 'Suspended',
            self::STATUS_TRANSFERRED => 'Transferred',
        ];
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the student that owns the enrollment.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the course that the student is enrolled in.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the batch associated with the enrollment.
     */
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    /**
     * Get the partner associated with the enrollment.
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    /**
     * Get the user who enrolled the student.
     */
    public function enrolledBy()
    {
        return $this->belongsTo(EnhancedUser::class, 'enrolled_by');
    }

    /**
     * Get the user who last updated the enrollment.
     */
    public function updatedBy()
    {
        return $this->belongsTo(EnhancedUser::class, 'updated_by');
    }

    /**
     * Get the course that the student was transferred to.
     */
    public function transferredToCourse()
    {
        return $this->belongsTo(Course::class, 'transferred_to_course_id');
    }

    // ==================== SCOPES ====================

    /**
     * Scope a query to only include active enrollments.
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope a query to only include completed enrollments.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope a query to only include dropped enrollments.
     */
    public function scopeDropped($query)
    {
        return $query->where('status', self::STATUS_DROPPED);
    }

    /**
     * Scope a query to only include suspended enrollments.
     */
    public function scopeSuspended($query)
    {
        return $query->where('status', self::STATUS_SUSPENDED);
    }

    /**
     * Scope a query to filter by student.
     */
    public function scopeForStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    /**
     * Scope a query to filter by course.
     */
    public function scopeForCourse($query, $courseId)
    {
        return $query->where('course_id', $courseId);
    }

    /**
     * Scope a query to filter by partner.
     */
    public function scopeForPartner($query, $partnerId)
    {
        return $query->where('partner_id', $partnerId);
    }

    // ==================== HELPER METHODS ====================

    /**
     * Check if enrollment is active.
     */
    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Check if enrollment is completed.
     */
    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Check if enrollment is dropped.
     */
    public function isDropped()
    {
        return $this->status === self::STATUS_DROPPED;
    }

    /**
     * Check if enrollment is suspended.
     */
    public function isSuspended()
    {
        return $this->status === self::STATUS_SUSPENDED;
    }

    /**
     * Check if enrollment is transferred.
     */
    public function isTransferred()
    {
        return $this->status === self::STATUS_TRANSFERRED;
    }

    /**
     * Get the duration of enrollment in days.
     */
    public function getDurationInDays()
    {
        $endDate = $this->completion_date ?? now();
        return $this->enrolled_at->diffInDays($endDate);
    }

    /**
     * Get the duration of enrollment in months.
     */
    public function getDurationInMonths()
    {
        $endDate = $this->completion_date ?? now();
        return $this->enrolled_at->diffInMonths($endDate);
    }

    // ==================== STATUS CHANGE METHODS ====================

    /**
     * Mark enrollment as completed.
     */
    public function markAsCompleted($finalGrade = null, $gradeLetter = null, $remarks = null)
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'completion_date' => now(),
            'final_grade' => $finalGrade,
            'grade_letter' => $gradeLetter,
            'remarks' => $remarks,
        ]);
    }

    /**
     * Mark enrollment as dropped.
     */
    public function markAsDropped($remarks = null)
    {
        $this->update([
            'status' => self::STATUS_DROPPED,
            'remarks' => $remarks,
        ]);
    }

    /**
     * Mark enrollment as suspended.
     */
    public function markAsSuspended($remarks = null)
    {
        $this->update([
            'status' => self::STATUS_SUSPENDED,
            'remarks' => $remarks,
        ]);
    }

    /**
     * Mark enrollment as transferred.
     */
    public function markAsTransferred($toCourseId, $remarks = null)
    {
        $this->update([
            'status' => self::STATUS_TRANSFERRED,
            'transferred_to_course_id' => $toCourseId,
            'transferred_at' => now(),
            'remarks' => $remarks,
        ]);
    }

    /**
     * Reactivate a suspended or dropped enrollment.
     */
    public function reactivate($remarks = null)
    {
        if ($this->status === self::STATUS_COMPLETED || $this->status === self::STATUS_TRANSFERRED) {
            throw new \Exception('Cannot reactivate a completed or transferred enrollment.');
        }

        $this->update([
            'status' => self::STATUS_ACTIVE,
            'remarks' => $remarks,
        ]);
    }

    // ==================== VALIDATION ====================

    /**
     * Validation rules for creating an enrollment
     */
    public static function getValidationRules($enrollmentId = null)
    {
        return [
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'batch_id' => 'nullable|exists:batches,id',
            'partner_id' => 'required|exists:partners,id',
            'enrolled_at' => 'required|date',
            'status' => 'required|in:active,completed,dropped,suspended,transferred',
            'completion_date' => 'nullable|date|after_or_equal:enrolled_at',
            'final_grade' => 'nullable|numeric|min:0|max:100',
            'grade_letter' => 'nullable|string|max:2',
            'transferred_to_course_id' => 'nullable|exists:courses,id',
            'transferred_at' => 'nullable|date|after_or_equal:enrolled_at',
        ];
    }

    /**
     * Check if student can be enrolled in a course
     */
    public static function canEnroll($studentId, $courseId)
    {
        // Check if student already has an active enrollment in this course
        $existingEnrollment = self::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->where('status', self::STATUS_ACTIVE)
            ->exists();

        return !$existingEnrollment;
    }

    /**
     * Get student's enrollment history
     */
    public static function getStudentHistory($studentId)
    {
        return self::where('student_id', $studentId)
            ->with(['course', 'batch', 'enrolledBy'])
            ->orderBy('enrolled_at', 'desc')
            ->get();
    }

    /**
     * Get course's enrollment statistics
     */
    public static function getCourseStatistics($courseId)
    {
        $enrollments = self::where('course_id', $courseId);

        return [
            'total' => $enrollments->count(),
            'active' => $enrollments->where('status', self::STATUS_ACTIVE)->count(),
            'completed' => $enrollments->where('status', self::STATUS_COMPLETED)->count(),
            'dropped' => $enrollments->where('status', self::STATUS_DROPPED)->count(),
            'suspended' => $enrollments->where('status', self::STATUS_SUSPENDED)->count(),
            'transferred' => $enrollments->where('status', self::STATUS_TRANSFERRED)->count(),
            'average_completion_time' => $enrollments
                ->where('status', self::STATUS_COMPLETED)
                ->whereNotNull('completion_date')
                ->get()
                ->avg(function ($enrollment) {
                    return $enrollment->enrolled_at->diffInDays($enrollment->completion_date);
                }),
        ];
    }
}
