<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'start_date',
        'end_date',
        'status',
        'flag',
        'partner_id',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'string',
        'flag' => 'string',
    ];

    // Relationships
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // One-to-many relationship with subjects
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
    
    /**
     * Get all batches for this course.
     */
    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get all students enrolled in this course (Legacy - for backward compatibility).
     * @deprecated Use enrollments() or studentsEnrolled() instead
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Get all enrollments for this course.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get all students enrolled in this course (Many-to-Many).
     */
    public function studentsEnrolled()
    {
        return $this->belongsToMany(Student::class, 'enrollments')
            ->withPivot([
                'id',
                'batch_id',
                'partner_id',
                'enrolled_at',
                'status',
                'completion_date',
                'final_grade',
                'grade_letter',
                'remarks',
                'created_at',
                'updated_at'
            ])
            ->withTimestamps();
    }

    /**
     * Get active enrollments for this course.
     */
    public function activeEnrollments()
    {
        return $this->hasMany(Enrollment::class)
            ->where('status', Enrollment::STATUS_ACTIVE);
    }

    /**
     * Get completed enrollments for this course.
     */
    public function completedEnrollments()
    {
        return $this->hasMany(Enrollment::class)
            ->where('status', Enrollment::STATUS_COMPLETED);
    }

    /**
     * Get active students for this course.
     */
    public function activeStudents()
    {
        return $this->belongsToMany(Student::class, 'enrollments')
            ->wherePivot('status', Enrollment::STATUS_ACTIVE)
            ->withPivot([
                'id',
                'batch_id',
                'enrolled_at',
                'status',
                'created_at',
                'updated_at'
            ])
            ->withTimestamps();
    }

    /**
     * Get total number of enrolled students (all statuses).
     */
    public function getTotalEnrolledStudents()
    {
        return $this->enrollments()->count();
    }

    /**
     * Get total number of active students.
     */
    public function getActiveStudentsCount()
    {
        return $this->activeEnrollments()->count();
    }

    /**
     * Get total number of completed students.
     */
    public function getCompletedStudentsCount()
    {
        return $this->completedEnrollments()->count();
    }

    /**
     * Get enrollment statistics for this course.
     */
    public function getEnrollmentStatistics()
    {
        return Enrollment::getCourseStatistics($this->id);
    }

    /**
     * Get all migrations from this course.
     */
    public function migrationsFrom()
    {
        return $this->hasMany(StudentMigration::class, 'from_course_id');
    }

    /**
     * Get all migrations to this course.
     */
    public function migrationsTo()
    {
        return $this->hasMany(StudentMigration::class, 'to_course_id');
    }

    /**
     * Get the course duration in days.
     */
    public function getDurationAttribute()
    {
        if (!$this->start_date || !$this->end_date) {
            return null;
        }

        return $this->start_date->diffInDays($this->end_date);
    }

    /**
     * Check if course is currently active.
     */
    public function isActive()
    {
        if (!$this->start_date || !$this->end_date) {
            return false;
        }

        $now = now();
        return $now->between($this->start_date, $this->end_date);
    }

    /**
     * Check if course has started.
     */
    public function hasStarted()
    {
        return $this->start_date && now()->gte($this->start_date);
    }

    /**
     * Check if course has ended.
     */
    public function hasEnded()
    {
        return $this->end_date && now()->gt($this->end_date);
    }
}
