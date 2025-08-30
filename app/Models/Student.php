<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'partner_id',
        'course_id',
        'batch_id',
        'enroll_date',
        'full_name',
        'student_id',
        'date_of_birth',
        'gender',
        'photo',
        'email',
        'phone',
        'address',
        'city',
        'school_college',
        'class_grade',
        'parent_name',
        'parent_phone',
        'status',
    ];

    protected $casts = [
        'enroll_date' => 'date',
        'date_of_birth' => 'date',
        'status' => 'string',
    ];

    // Relationships
    /**
     * Get all exam results for this student
     */
    public function examResults()
    {
        return $this->hasMany(ExamResult::class);
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'exam_results');
    }

    /**
     * Get the user account associated with the student.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the partner associated with the student.
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    /**
     * Get the course associated with the student.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the batch associated with the student.
     */
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    /**
     * Get all migrations for this student.
     */
    public function migrations()
    {
        return $this->hasMany(StudentMigration::class);
    }

    /**
     * Get the latest migration for this student.
     */
    public function latestMigration()
    {
        return $this->hasOne(StudentMigration::class)->latestOfMany();
    }

    /**
     * Get the current course duration for this student.
     */
    public function getCurrentCourseDurationAttribute()
    {
        if (!$this->course || !$this->enroll_date) {
            return null;
        }

        $endDate = $this->course->end_date ?? now();
        return $this->enroll_date->diffInDays($endDate);
    }

    /**
     * Check if student is currently enrolled in a course.
     */
    public function isCurrentlyEnrolled()
    {
        if (!$this->course || !$this->enroll_date) {
            return false;
        }

        $now = now();
        $startDate = $this->course->start_date ?? $this->enroll_date;
        $endDate = $this->course->end_date;

        return $now->between($startDate, $endDate);
    }
}
