<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentMigration extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'from_course_id',
        'to_course_id',
        'from_batch_id',
        'to_batch_id',
        'migration_date',
        'reason',
        'status',
        'notes',
    ];

    protected $casts = [
        'migration_date' => 'date',
    ];

    /**
     * Get the student that owns the migration.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the course the student migrated from.
     */
    public function fromCourse(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'from_course_id');
    }

    /**
     * Get the course the student migrated to.
     */
    public function toCourse(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'to_course_id');
    }

    /**
     * Get the batch the student migrated from.
     */
    public function fromBatch(): BelongsTo
    {
        return $this->belongsTo(Batch::class, 'from_batch_id');
    }

    /**
     * Get the batch the student migrated to.
     */
    public function toBatch(): BelongsTo
    {
        return $this->belongsTo(Batch::class, 'to_batch_id');
    }

    /**
     * Scope to get completed migrations.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope to get pending migrations.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Get the migration description.
     */
    public function getMigrationDescriptionAttribute(): string
    {
        $description = [];
        
        if ($this->from_course_id && $this->to_course_id) {
            $description[] = "Course: {$this->fromCourse->name} → {$this->toCourse->name}";
        }
        
        if ($this->from_batch_id && $this->to_batch_id) {
            $description[] = "Batch: {$this->fromBatch->name} → {$this->toBatch->name}";
        }
        
        return implode(', ', $description);
    }
}
