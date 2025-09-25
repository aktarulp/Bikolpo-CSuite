<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAccessCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'student_id',
        'access_code',
        'status',
        'sms_status',
        'used_at',
        'expires_at',
    ];

    protected $casts = [
        'used_at' => 'datetime',
        'expires_at' => 'datetime',
        'sms_status' => 'string',
    ];

    // Relationships
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeValid($query)
    {
        return $query->where('status', 'active')
                    ->where(function ($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }

    // Methods
    public function markAsUsed()
    {
        $this->update([
            'status' => 'used',
            'used_at' => now(),
        ]);
    }

    public function isExpired()
    {
        // Check if exam end date has passed
        return $this->exam && $this->exam->end_time && \Carbon\Carbon::parse($this->exam->end_time)->isPast();
    }

    public function isValid()
    {
        // Access code is valid if:
        // 1. Status is active
        // 2. Exam end date hasn't passed
        // 3. Student hasn't submitted the exam yet
        return $this->status === 'active' && 
               !$this->isExpired() && 
               !$this->hasSubmittedExam();
    }

    public function hasSubmittedExam()
    {
        // Check if student has already submitted this exam
        return \App\Models\ExamResult::where('student_id', $this->student_id)
            ->where('exam_id', $this->exam_id)
            ->where('status', 'completed')
            ->exists();
    }

    public function hasInProgressExam()
    {
        // Check if student has an in-progress exam
        return \App\Models\ExamResult::where('student_id', $this->student_id)
            ->where('exam_id', $this->exam_id)
            ->where('status', 'in_progress')
            ->exists();
    }

    // Generate unique 6-digit access code
    public static function generateUniqueCode()
    {
        do {
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (static::where('access_code', $code)->exists());

        return $code;
    }
}
