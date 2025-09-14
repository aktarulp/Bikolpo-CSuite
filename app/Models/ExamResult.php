<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'exam_results';

    protected $fillable = [
        'student_id',
        'exam_id',
        'started_at',
        'completed_at',
        'total_questions',
        'correct_answers',
        'wrong_answers',
        'unanswered',
        'score',
        'percentage',
        'status',
        'result_type',
        'answers',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'total_questions' => 'integer',
        'correct_answers' => 'integer',
        'wrong_answers' => 'integer',
        'unanswered' => 'integer',
        'score' => 'decimal:2',
        'percentage' => 'decimal:2',
        'status' => 'string',
        'result_type' => 'string',
        'answers' => 'array',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    // Accessors
    public function getIsPassedAttribute()
    {
        return ($this->percentage ?? 0) >= ($this->exam->passing_marks ?? 50);
    }

    public function getTimeTakenAttribute()
    {
        if ($this->completed_at && $this->started_at) {
            return $this->started_at->diffInMinutes($this->completed_at);
        }
        return null;
    }

    public function getGradeAttribute()
    {
        $percentage = $this->percentage ?? 0;
        return match(true) {
            $percentage >= 90 => 'A+',
            $percentage >= 80 => 'A',
            $percentage >= 70 => 'B',
            $percentage >= 60 => 'C',
            $percentage >= 50 => 'D',
            default => 'F'
        };
    }

    /**
     * Get all question statistics for this exam result
     */
    public function questionStats()
    {
        return $this->hasMany(\App\Models\QuestionStat::class);
    }

    /**
     * Get detailed analytics for this exam result
     */
    public function getDetailedAnalyticsAttribute()
    {
        $questionStats = $this->questionStats;
        
        return [
            'total_questions' => $questionStats->count(),
            'correct_answers' => $questionStats->where('is_correct', true)->count(),
            'incorrect_answers' => $questionStats->where('is_correct', false)->where('is_answered', true)->count(),
            'skipped_questions' => $questionStats->where('is_skipped', true)->count(),
            'unanswered_questions' => $questionStats->where('is_answered', false)->where('is_skipped', false)->count(),
            'accuracy_percentage' => $questionStats->count() > 0 ? round(($questionStats->where('is_correct', true)->count() / $questionStats->count()) * 100, 2) : 0,
            'average_time_per_question' => $questionStats->whereNotNull('time_spent_seconds')->avg('time_spent_seconds'),
            'difficulty_breakdown' => $this->getDifficultyBreakdown(),
            'question_type_breakdown' => $this->getQuestionTypeBreakdown(),
        ];
    }

    /**
     * Get difficulty breakdown for this exam result
     */
    public function getDifficultyBreakdown()
    {
        $questionStats = $this->questionStats;
        $difficultyStats = [];
        
        foreach ($questionStats as $stat) {
            $question = $stat->question;
            if ($question) {
                $analytics = $question->analytics;
                $difficulty = $this->calculateDifficultyLevel($analytics['correct_percentage'] ?? 0);
                
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
     * Get question type breakdown for this exam result
     */
    public function getQuestionTypeBreakdown()
    {
        $questionStats = $this->questionStats;
        $typeStats = [];
        
        foreach ($questionStats as $stat) {
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

    /**
     * Calculate difficulty level based on correct percentage
     */
    private function calculateDifficultyLevel($correctPercentage)
    {
        if ($correctPercentage >= 80) return 'easy';
        if ($correctPercentage >= 60) return 'medium';
        return 'hard';
    }

    /**
     * Get questions that were answered correctly
     */
    public function getCorrectQuestions()
    {
        return $this->questionStats()->where('is_correct', true)->with('question')->get();
    }

    /**
     * Get questions that were answered incorrectly
     */
    public function getIncorrectQuestions()
    {
        return $this->questionStats()->where('is_correct', false)->where('is_answered', true)->with('question')->get();
    }

    /**
     * Get questions that were skipped
     */
    public function getSkippedQuestions()
    {
        return $this->questionStats()->where('is_skipped', true)->with('question')->get();
    }

    /**
     * Check if the result was automatically generated
     */
    public function getIsAutoResultAttribute()
    {
        return $this->result_type === 'auto';
    }

    /**
     * Check if the result was manually entered
     */
    public function getIsManualResultAttribute()
    {
        return $this->result_type === 'manual';
    }

    /**
     * Get the result type display name
     */
    public function getResultTypeDisplayAttribute()
    {
        return match($this->result_type) {
            'auto' => 'Auto Generated',
            'manual' => 'Manually Entered',
            default => 'Unknown'
        };
    }
}
