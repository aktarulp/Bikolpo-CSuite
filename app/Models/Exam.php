<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'title',
        'description',
        'start_time',
        'end_time',
        'duration',
        'total_questions',
        'exam_type',
        'passing_marks',
        'allow_retake',
        'show_results_immediately',
        'has_negative_marking',
        'negative_marks_per_question',
        'question_head',
        'exam_question_id',
        'status',
        'flag',
        'created_by',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'duration' => 'integer',
        'total_questions' => 'integer',
        'exam_type' => 'string',
        'passing_marks' => 'integer',
        'allow_retake' => 'boolean',
        'show_results_immediately' => 'boolean',
        'has_negative_marking' => 'boolean',
        'negative_marks_per_question' => 'decimal:2',
        'question_head' => 'string',
        'status' => 'string',
        'flag' => 'string',
    ];

    // Relationships
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function studentResults()
    {
        return $this->hasMany(StudentExamResult::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_exam_results');
    }

    public function accessCodes()
    {
        return $this->hasMany(ExamAccessCode::class);
    }

    public function assignedStudents()
    {
        return $this->belongsToMany(Student::class, 'exam_access_codes');
    }

    public function examQuestion()
    {
        return $this->belongsTo(\App\Models\ExamQuestion::class, 'exam_question_id');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_questions')
                    ->withPivot('order', 'marks')
                    ->withTimestamps();
    }

    public function createdBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    // Accessors
    public function getIsActiveAttribute()
    {
        $now = now();
        return $this->status === 'published' && 
               $now->gte($this->start_time) && 
               $now->lte($this->end_time);
    }

    public function getIsUpcomingAttribute()
    {
        return $this->status === 'published' && now()->lt($this->start_time);
    }

    public function getIsCompletedAttribute()
    {
        return $this->status === 'completed' || now()->gt($this->end_time);
    }

    /**
     * Calculate negative marks for wrong answers
     */
    public function calculateNegativeMarks(int $wrongAnswers): float
    {
        if (!$this->has_negative_marking) {
            return 0;
        }
        
        return $wrongAnswers * $this->negative_marks_per_question;
    }

    /**
     * Get formatted negative marks display
     */
    public function getNegativeMarksDisplayAttribute(): string
    {
        if (!$this->has_negative_marking) {
            return 'No negative marking';
        }
        
        return "{$this->negative_marks_per_question} marks per wrong answer";
    }

    /**
     * Get exam type display name
     */
    public function getExamTypeDisplayAttribute(): string
    {
        return ucfirst($this->exam_type);
    }

    /**
     * Check if exam is online
     */
    public function isOnline(): bool
    {
        return $this->exam_type === 'online';
    }

    /**
     * Check if exam is offline
     */
    public function isOffline(): bool
    {
        return $this->exam_type === 'offline';
    }

    // Mutators to handle HTML datetime-local inputs (e.g., 2025-01-30T14:30)
    public function setStartTimeAttribute($value)
    {
        $this->attributes['start_time'] = $this->normalizeDateTimeValue($value);
    }

    public function setEndTimeAttribute($value)
    {
        $this->attributes['end_time'] = $this->normalizeDateTimeValue($value);
    }

    private function normalizeDateTimeValue($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if ($value instanceof Carbon) {
            return $value->format('Y-m-d H:i:s');
        }

        // Accept strings like "YYYY-MM-DDTHH:MM" from datetime-local inputs
        if (is_string($value)) {
            // Replace the "T" separator if present
            $normalized = str_replace('T', ' ', $value);
            try {
                return Carbon::parse($normalized)->format('Y-m-d H:i:s');
            } catch (\Throwable $e) {
                // Fallback: let database fail loudly rather than silently corrupt
                return $normalized;
            }
        }

        // As a last resort, attempt to parse
        try {
            return Carbon::parse($value)->format('Y-m-d H:i:s');
        } catch (\Throwable $e) {
            return null;
        }
    }
}
