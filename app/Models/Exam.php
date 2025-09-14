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
        'question_header',
        'question_language',
        'status',
        'flag',
        'created_by',
        'ba',
        'bb',
        'bc',
        'bd',
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
        'question_header' => 'string',
        'status' => 'string',
        'flag' => 'string',
        'ba' => 'string',
        'bb' => 'string',
        'bc' => 'string',
        'bd' => 'string',
    ];

    /**
     * Boot the model and add global scopes
     */
    protected static function boot()
    {
        parent::boot();

        // Global scope to only show active records
        static::addGlobalScope('active', function ($query) {
            $query->where('flag', 'active');
        });
    }

    /**
     * Scope to include deleted records
     */
    public function scopeWithDeleted($query)
    {
        return $query->withoutGlobalScope('active');
    }

    /**
     * Scope to only show deleted records
     */
    public function scopeOnlyDeleted($query)
    {
        return $query->withoutGlobalScope('active')->where('flag', 'deleted');
    }

    /**
     * Get the current status of the exam based on time
     */
    public function getCurrentStatusAttribute()
    {
        $now = Carbon::now();
        $startTime = Carbon::parse($this->start_time);
        $endTime = Carbon::parse($this->end_time);

        if ($now < $startTime) {
            return 'scheduled';
        } elseif ($now >= $startTime && $now <= $endTime) {
            return 'ongoing';
        } else {
            return 'completed';
        }
    }

    /**
     * Check if exam is currently running
     */
    public function isRunning()
    {
        $now = Carbon::now();
        $startTime = Carbon::parse($this->start_time);
        $endTime = Carbon::parse($this->end_time);
        
        return $now >= $startTime && $now <= $endTime;
    }

    /**
     * Check if exam has started
     */
    public function hasStarted()
    {
        return Carbon::now() >= Carbon::parse($this->start_time);
    }

    /**
     * Check if exam has ended
     */
    public function hasEnded()
    {
        return Carbon::now() > Carbon::parse($this->end_time);
    }

    /**
     * Get time until exam starts (for countdown)
     */
    public function getTimeUntilStart()
    {
        $now = Carbon::now();
        $startTime = Carbon::parse($this->start_time);
        
        if ($now < $startTime) {
            return $now->diffForHumans($startTime, ['parts' => 2]);
        }
        
        return null;
    }

    /**
     * Get time remaining in exam
     */
    public function getTimeRemaining()
    {
        $now = Carbon::now();
        $endTime = Carbon::parse($this->end_time);
        
        if ($now < $endTime) {
            return $now->diffForHumans($endTime, ['parts' => 2]);
        }
        
        return null;
    }

    /**
     * Update exam status based on current time
     */
    public function updateStatus()
    {
        $currentStatus = $this->getCurrentStatusAttribute();
        
        if ($currentStatus === 'ongoing' && $this->status !== 'ongoing') {
            $this->update(['status' => 'ongoing']);
            \Log::info("Exam {$this->id} ({$this->title}) status updated to ongoing");
        } elseif ($currentStatus === 'completed' && $this->status !== 'completed') {
            $this->update(['status' => 'completed']);
            \Log::info("Exam {$this->id} ({$this->title}) status updated to completed");
        }
        
        return $this->status;
    }

    /**
     * Scope for exams that need status updates
     */
    public function scopeNeedsStatusUpdate($query)
    {
        return $query->whereIn('status', ['published', 'ongoing'])
            ->where(function($q) {
                $q->where('start_time', '<=', now())
                  ->orWhere('end_time', '<=', now());
            });
    }

    /**
     * Get user-friendly status display with countdown
     */
    public function getStatusDisplayAttribute()
    {
        $currentStatus = $this->getCurrentStatusAttribute();
        
        switch ($currentStatus) {
            case 'scheduled':
                $timeUntil = $this->getTimeUntilStart();
                return [
                    'status' => 'scheduled',
                    'label' => 'Scheduled',
                    'badge_class' => 'bg-blue-100 text-blue-800',
                    'message' => "Starts in {$timeUntil}",
                    'countdown' => $timeUntil
                ];
                
            case 'ongoing':
                $timeRemaining = $this->getTimeRemaining();
                return [
                    'status' => 'ongoing',
                    'label' => 'Running',
                    'badge_class' => 'bg-green-100 text-green-800',
                    'message' => "Ends in {$timeRemaining}",
                    'countdown' => $timeRemaining
                ];
                
            case 'completed':
                return [
                    'status' => 'completed',
                    'label' => 'Completed',
                    'badge_class' => 'bg-purple-100 text-purple-800',
                    'message' => 'Exam has ended',
                    'countdown' => null
                ];
                
            default:
                return [
                    'status' => $this->status,
                    'label' => ucfirst($this->status),
                    'badge_class' => 'bg-gray-100 text-gray-800',
                    'message' => 'Status unknown',
                    'countdown' => null
                ];
        }
    }

    /**
     * Soft delete the exam by changing flag to 'deleted'
     */
    public function softDelete()
    {
        return $this->update(['flag' => 'deleted']);
    }

    /**
     * Restore the exam by changing flag back to 'active'
     */
    public function restore()
    {
        return $this->update(['flag' => 'active']);
    }

    /**
     * Check if the exam is deleted
     */
    public function isDeleted()
    {
        return $this->flag === 'deleted';
    }

    /**
     * Check if the exam is scheduled for the future
     */
    public function isScheduled()
    {
        return $this->status === 'published' && now()->lt($this->start_time);
    }

    /**
     * Check if the exam is currently ongoing
     */
    public function isOngoing()
    {
        return $this->status === 'published' && 
               now()->gte($this->start_time) && 
               now()->lte($this->end_time);
    }

    /**
     * Get all exam results for this exam
     */
    public function examResults()
    {
        return $this->hasMany(ExamResult::class);
    }

    /**
     * Get time until exam starts in human readable format
     */
    public function getTimeUntilStartAttribute()
    {
        if ($this->status !== 'published' || now()->gte($this->start_time)) {
            return null;
        }
        
        return now()->diffForHumans($this->start_time, ['parts' => 2]);
    }

    /**
     * Get formatted start time for display
     */
    public function getFormattedStartTimeAttribute()
    {
        return $this->start_time ? $this->start_time->format('M d, Y g:i A') : 'Not set';
    }

    /**
     * Get formatted end time for display
     */
    public function getFormattedEndTimeAttribute()
    {
        return $this->end_time ? $this->end_time->format('M d, Y g:i A') : 'Not set';
    }

    // Relationships
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function studentResults()
    {
        return $this->hasMany(ExamResult::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'exam_results');
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

    /**
     * Get all question statistics for this exam
     */
    public function questionStats()
    {
        return $this->hasMany(\App\Models\QuestionStat::class);
    }

    /**
     * Get exam analytics
     */
    public function getAnalyticsAttribute()
    {
        return \App\Models\QuestionStat::getExamQuestionAnalytics($this->id);
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
