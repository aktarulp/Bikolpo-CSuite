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
        'partner_id',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'string',
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

    // Many-to-many relationship with subjects
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_on_course')
                    ->withPivot('partner_id')
                    ->withTimestamps();
    }

    public function questions()
    {
        return $this->hasManyThrough(Question::class, Subject::class, 'course_id', 'topic_id');
    }

    /**
     * Get all students enrolled in this course.
     */
    public function students()
    {
        return $this->hasMany(Student::class);
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
