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

    /**
     * Get detailed analytics for a specific question across all students
     */
    public static function getQuestionDetailedAnalytics($questionId)
    {
        $stats = self::forQuestion($questionId);
        
        $analytics = [
            'question_id' => $questionId,
            'total_attempts' => $stats->count(),
            'total_answered' => $stats->answered()->count(),
            'total_correct' => $stats->correct()->count(),
            'total_incorrect' => $stats->incorrect()->count(),
            'total_skipped' => $stats->skipped()->count(),
            'correct_percentage' => $stats->count() > 0 ? round(($stats->correct()->count() / $stats->count()) * 100, 2) : 0,
            'answer_rate' => $stats->count() > 0 ? round(($stats->answered()->count() / $stats->count()) * 100, 2) : 0,
            'average_time_spent' => $stats->whereNotNull('time_spent_seconds')->avg('time_spent_seconds'),
            'difficulty_level' => self::calculateQuestionDifficulty($stats),
            'answer_distribution' => self::getAnswerDistribution($questionId),
            'students_who_got_correct' => $stats->correct()->with('student')->get()->pluck('student'),
            'students_who_got_incorrect' => $stats->incorrect()->with('student')->get()->pluck('student'),
        ];
        
        return $analytics;
    }

    /**
     * Get answer distribution for a question
     */
    public static function getAnswerDistribution($questionId)
    {
        $stats = self::forQuestion($questionId)->answered();
        
        $distribution = [];
        foreach ($stats as $stat) {
            $answer = $stat->student_answer;
            if (!isset($distribution[$answer])) {
                $distribution[$answer] = 0;
            }
            $distribution[$answer]++;
        }
        
        return $distribution;
    }

    /**
     * Calculate question difficulty based on correct percentage
     */
    public static function calculateQuestionDifficulty($stats)
    {
        $totalAttempts = $stats->count();
        if ($totalAttempts === 0) return 'unknown';
        
        $correctPercentage = ($stats->correct()->count() / $totalAttempts) * 100;
        
        if ($correctPercentage >= 80) return 'easy';
        if ($correctPercentage >= 60) return 'medium';
        return 'hard';
    }

    /**
     * Get student performance analytics for a specific exam
     */
    public static function getStudentExamAnalytics($studentId, $examId)
    {
        $stats = self::where('student_id', $studentId)->where('exam_id', $examId);
        
        return [
            'student_id' => $studentId,
            'exam_id' => $examId,
            'total_questions' => $stats->count(),
            'correct_answers' => $stats->correct()->count(),
            'incorrect_answers' => $stats->incorrect()->count(),
            'skipped_questions' => $stats->skipped()->count(),
            'accuracy_percentage' => $stats->count() > 0 ? round(($stats->correct()->count() / $stats->count()) * 100, 2) : 0,
            'average_time_per_question' => $stats->whereNotNull('time_spent_seconds')->avg('time_spent_seconds'),
            'difficulty_performance' => self::getStudentDifficultyPerformance($studentId, $examId),
            'question_type_performance' => self::getStudentQuestionTypePerformance($studentId, $examId),
        ];
    }

    /**
     * Get student performance by difficulty level
     */
    public static function getStudentDifficultyPerformance($studentId, $examId)
    {
        $stats = self::where('student_id', $studentId)->where('exam_id', $examId)->with('question')->get();
        $difficultyStats = [];
        
        foreach ($stats as $stat) {
            if ($stat->question) {
                $questionAnalytics = $stat->question->analytics;
                $difficulty = self::calculateQuestionDifficulty(
                    self::forQuestion($stat->question_id)
                );
                
                if (!isset($difficultyStats[$difficulty])) {
                    $difficultyStats[$difficulty] = [
                        'total' => 0,
                        'correct' => 0,
                        'incorrect' => 0,
                        'skipped' => 0,
                    ];
                }
                
                $difficultyStats[$difficulty]['total']++;
                if ($stat->is_correct) {
                    $difficultyStats[$difficulty]['correct']++;
                } elseif ($stat->is_answered) {
                    $difficultyStats[$difficulty]['incorrect']++;
                } else {
                    $difficultyStats[$difficulty]['skipped']++;
                }
            }
        }
        
        return $difficultyStats;
    }

    /**
     * Get student performance by question type
     */
    public static function getStudentQuestionTypePerformance($studentId, $examId)
    {
        $stats = self::where('student_id', $studentId)->where('exam_id', $examId);
        $typeStats = [];
        
        foreach ($stats->get() as $stat) {
            $type = $stat->question_type;
            
            if (!isset($typeStats[$type])) {
                $typeStats[$type] = [
                    'total' => 0,
                    'correct' => 0,
                    'incorrect' => 0,
                    'skipped' => 0,
                ];
            }
            
            $typeStats[$type]['total']++;
            if ($stat->is_correct) {
                $typeStats[$type]['correct']++;
            } elseif ($stat->is_answered) {
                $typeStats[$type]['incorrect']++;
            } else {
                $typeStats[$type]['skipped']++;
            }
        }
        
        return $typeStats;
    }
}