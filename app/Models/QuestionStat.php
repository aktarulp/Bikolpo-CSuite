<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionStat extends Model
{
    use HasFactory;

    protected $table = 'question_statistics';

    protected $fillable = [
        'question_id',
        'exam_id',
        'student_id',
        'exam_result_id',
        'student_answer',
        'correct_answer',
        'is_correct',
        'is_answered',
        'is_skipped',
        'time_spent_seconds',
        'question_started_at',
        'question_answered_at',
        'question_order',
        'marks',
        'question_type',
        'answer_metadata',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'is_answered' => 'boolean',
        'is_skipped' => 'boolean',
        'time_spent_seconds' => 'integer',
        'question_started_at' => 'datetime',
        'question_answered_at' => 'datetime',
        'question_order' => 'integer',
        'marks' => 'integer',
        'answer_metadata' => 'array',
    ];

    // Relationships
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function examResult()
    {
        return $this->belongsTo(ExamResult::class);
    }

    // Scopes
    public function scopeCorrect($query)
    {
        return $query->where('is_correct', true);
    }

    public function scopeIncorrect($query)
    {
        return $query->where('is_correct', false);
    }

    public function scopeAnswered($query)
    {
        return $query->where('is_answered', true);
    }

    public function scopeSkipped($query)
    {
        return $query->where('is_skipped', true);
    }

    public function scopeForQuestion($query, $questionId)
    {
        return $query->where('question_id', $questionId);
    }

    public function scopeForExam($query, $examId)
    {
        return $query->where('exam_id', $examId);
    }

    // Accessors
    public function getTimeSpentFormattedAttribute()
    {
        if (!$this->time_spent_seconds) {
            return 'N/A';
        }

        $minutes = floor($this->time_spent_seconds / 60);
        $seconds = $this->time_spent_seconds % 60;

        if ($minutes > 0) {
            return "{$minutes}m {$seconds}s";
        }

        return "{$seconds}s";
    }

    public function getAnswerStatusAttribute()
    {
        if ($this->is_skipped) {
            return 'skipped';
        }

        if (!$this->is_answered) {
            return 'unanswered';
        }

        return $this->is_correct ? 'correct' : 'incorrect';
    }

    // Static methods for analytics
    public static function getQuestionAnalytics($questionId)
    {
        $stats = self::forQuestion($questionId);
        
        return [
            'total_appearances' => $stats->count(),
            'total_answered' => $stats->answered()->count(),
            'total_correct' => $stats->correct()->count(),
            'total_incorrect' => $stats->incorrect()->count(),
            'total_skipped' => $stats->skipped()->count(),
            'total_unanswered' => $stats->where('is_answered', false)->where('is_skipped', false)->count(),
            'correct_percentage' => $stats->count() > 0 ? round(($stats->correct()->count() / $stats->count()) * 100, 2) : 0,
            'answer_rate' => $stats->count() > 0 ? round(($stats->answered()->count() / $stats->count()) * 100, 2) : 0,
            'average_time_spent' => $stats->whereNotNull('time_spent_seconds')->avg('time_spent_seconds'),
        ];
    }

    public static function getExamQuestionAnalytics($examId)
    {
        $stats = self::forExam($examId);
        
        return [
            'total_questions' => $stats->distinct('question_id')->count(),
            'total_attempts' => $stats->count(),
            'total_correct' => $stats->correct()->count(),
            'total_incorrect' => $stats->incorrect()->count(),
            'total_skipped' => $stats->skipped()->count(),
            'total_unanswered' => $stats->where('is_answered', false)->where('is_skipped', false)->count(),
            'overall_accuracy' => $stats->count() > 0 ? round(($stats->correct()->count() / $stats->count()) * 100, 2) : 0,
        ];
    }

    public static function getStudentQuestionAnalytics($studentId)
    {
        $stats = self::where('student_id', $studentId);
        
        return [
            'total_questions_attempted' => $stats->count(),
            'total_correct' => $stats->correct()->count(),
            'total_incorrect' => $stats->incorrect()->count(),
            'total_skipped' => $stats->skipped()->count(),
            'accuracy_percentage' => $stats->count() > 0 ? round(($stats->correct()->count() / $stats->count()) * 100, 2) : 0,
            'average_time_per_question' => $stats->whereNotNull('time_spent_seconds')->avg('time_spent_seconds'),
        ];
    }
}