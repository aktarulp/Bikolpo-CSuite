<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'year',
        'course_id',
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
        'year' => 'integer'
    ];

    // Relationships
    
    /**
     * Get the course that this batch belongs to.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Deprecated: This relationship is no longer used with the new enrollment system
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    
    // New relationship for the enrollment system
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    
    // New relationship to get students through enrollments
    public function enrolledStudents()
    {
        return $this->belongsToMany(Student::class, 'course_batch_enrollments', 'batch_id', 'student_id')
            ->withPivot(['id', 'course_id', 'enrolled_at', 'status'])
            ->wherePivot('status', 'active');
    }

    /**
     * Get all migrations from this batch.
     */
    public function migrationsFrom()
    {
        return $this->hasMany(StudentMigration::class, 'from_batch_id');
    }

    /**
     * Get all migrations to this batch.
     */
    public function migrationsTo()
    {
        return $this->hasMany(StudentMigration::class, 'to_batch_id');
    }

    // Scopes
    public function scopeByPartner($query, $partnerId)
    {
        return $query->where('partner_id', $partnerId);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeNotDeleted($query)
    {
        return $query->where('flag', '!=', 'deleted');
    }

    public function scopeVisible($query)
    {
        return $query->where('flag', 'active');
    }

    // Helper method to get batch name with year
    public function getDisplayNameAttribute()
    {
        return $this->name . ' (' . $this->year . ')';
    }

    /**
     * Get the batch duration in days.
     */
    public function getDurationAttribute()
    {
        if (!$this->start_date || !$this->end_date) {
            return null;
        }

        return $this->start_date->diffInDays($this->end_date);
    }

    /**
     * Check if batch is currently active.
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
     * Check if batch has started.
     */
    public function hasStarted()
    {
        return $this->start_date && now()->gte($this->start_date);
    }

    /**
     * Check if batch has ended.
     */
    public function hasEnded()
    {
        return $this->end_date && now()->gt($this->end_date);
    }
}