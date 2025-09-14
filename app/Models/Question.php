<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_type',
        'q_type_id',
        'course_id',
        'subject_id',
        'topic_id',
        'partner_id',
        'created_by',
        'question_text',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'explanation',
        'expected_answer_points',
        'sample_answer',
        'min_words',
        'max_words',
        'sub_questions',
        'expected_answer_structure',
        'key_concepts',
        'time_allocation',
        'status',
        'tags',
        'appearance_history',
    ];

    protected $casts = [
        'question_type' => 'string',
        'status' => 'string',
        'tags' => 'array',
        'appearance_history' => 'array',
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function questionType()
    {
        return $this->belongsTo(QuestionType::class, 'q_type_id', 'q_type_id');
    }

    // public function questionSets()
    // {
    //     return $this->belongsToMany(QuestionSet::class, 'question_set_question')
    //                 ->withPivot('order')
    //                 ->withTimestamps();
    // }

    public function questionHistory()
    {
        return $this->hasMany(QuestionHistory::class);
    }



    // Accessors
    public function getCorrectOptionTextAttribute()
    {
        return $this->{'option_' . $this->correct_answer};
    }

    // Question Type Helpers
    public function isMcq()
    {
        return $this->question_type === 'mcq';
    }

    public function isDescriptive()
    {
        return $this->question_type === 'descriptive';
    }

    public function isTrueFalse()
    {
        return $this->question_type === 'true_false';
    }



    public function getQuestionTypeTextAttribute()
    {
        return match($this->question_type) {
            'mcq' => 'MCQ',
            'descriptive' => 'Descriptive',
            'true_false' => 'True/False',
            'fill_in_blank' => 'Fill in the Blanks',
            default => 'Unknown'
        };
    }

    // Scopes for filtering by question type
    public function scopeMcq($query)
    {
        return $query->where('question_type', 'mcq');
    }

    public function scopeDescriptive($query)
    {
        return $query->where('question_type', 'descriptive');
    }

    public function scopeTrueFalse($query)
    {
        return $query->where('question_type', 'true_false');
    }

    /**
     * Get all question statistics for this question
     */
    public function questionStats()
    {
        return $this->hasMany(\App\Models\QuestionStat::class);
    }

    /**
     * Get question analytics
     */
    public function getAnalyticsAttribute()
    {
        return \App\Models\QuestionStat::getQuestionAnalytics($this->id);
    }

    /**
     * Virtual difficulty calculation based on student performance
     */
    public function getDifficultyLevelAttribute()
    {
        $stats = $this->questionStats();
        $totalAttempts = $stats->count();
        
        if ($totalAttempts < 5) {
            return 3; // Default to medium if not enough data
        }
        
        $correctAttempts = $stats->where('is_correct', true)->count();
        $accuracyPercentage = ($correctAttempts / $totalAttempts) * 100;
        
        // Difficulty levels based on accuracy percentage
        if ($accuracyPercentage >= 90) {
            return 1; // Very Easy
        } elseif ($accuracyPercentage >= 75) {
            return 2; // Easy
        } elseif ($accuracyPercentage >= 50) {
            return 3; // Medium
        } elseif ($accuracyPercentage >= 25) {
            return 4; // Hard
        } else {
            return 5; // Very Hard
        }
    }

    /**
     * Get difficulty level label
     */
    public function getDifficultyLabelAttribute()
    {
        $level = $this->difficulty_level;
        $labels = [
            1 => 'Very Easy',
            2 => 'Easy',
            3 => 'Medium',
            4 => 'Hard',
            5 => 'Very Hard'
        ];
        
        return $labels[$level] ?? 'Unknown';
    }

    /**
     * Get difficulty color classes
     */
    public function getDifficultyColorAttribute()
    {
        $level = $this->difficulty_level;
        $colors = [
            1 => 'bg-green-100 text-green-800 border-green-200',
            2 => 'bg-blue-100 text-blue-800 border-blue-200',
            3 => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            4 => 'bg-orange-100 text-orange-800 border-orange-200',
            5 => 'bg-red-100 text-red-800 border-red-200'
        ];
        
        return $colors[$level] ?? 'bg-gray-100 text-gray-800 border-gray-200';
    }

    /**
     * Get virtual confidence score based on attempt count
     */
    public function getDifficultyConfidenceAttribute()
    {
        $totalAttempts = $this->questionStats()->count();
        
        if ($totalAttempts >= 50) {
            return 1.0; // 100% confidence with 50+ attempts
        } elseif ($totalAttempts >= 20) {
            return 0.8; // 80% confidence with 20-49 attempts
        } elseif ($totalAttempts >= 10) {
            return 0.6; // 60% confidence with 10-19 attempts
        } elseif ($totalAttempts >= 5) {
            return 0.4; // 40% confidence with 5-9 attempts
        } else {
            return 0.0; // No confidence with <5 attempts
        }
    }

    /**
     * Get total attempts for difficulty calculation
     */
    public function getDifficultyCalculationAttemptsAttribute()
    {
        return $this->questionStats()->count();
    }

    /**
     * Get correct percentage for difficulty calculation
     */
    public function getDifficultyCorrectPercentageAttribute()
    {
        $totalAttempts = $this->questionStats()->count();
        if ($totalAttempts === 0) {
            return 0;
        }
        
        $correctAttempts = $this->questionStats()->where('is_correct', true)->count();
        return round(($correctAttempts / $totalAttempts) * 100, 2);
    }

    /**
     * Check if question has enough attempts for reliable difficulty calculation
     */
    public function getHasEnoughAttemptsForDifficultyCalculationAttribute()
    {
        return $this->questionStats()->count() >= 10;
    }

    /**
     * Get comprehensive difficulty information
     */
    public function getDifficultyInfoAttribute()
    {
        return [
            'difficulty_level' => $this->difficulty_level,
            'difficulty_label' => $this->difficulty_label,
            'difficulty_color' => $this->difficulty_color,
            'confidence_score' => $this->difficulty_confidence,
            'total_attempts' => $this->difficulty_calculation_attempts,
            'correct_percentage' => $this->difficulty_correct_percentage,
            'has_enough_data' => $this->has_enough_attempts_for_difficulty_calculation,
        ];
    }

    /**
     * Scope to filter questions by difficulty level (virtual)
     */
    public function scopeByDifficulty($query, string $difficultyLevel)
    {
        // This is a complex scope that would require subqueries
        // For now, we'll handle this in the controller
        return $query;
    }

    /**
     * Scope to filter questions that have enough attempts for difficulty calculation
     */
    public function scopeWithEnoughAttempts($query, int $minAttempts = 10)
    {
        return $query->whereRaw('(SELECT COUNT(*) FROM question_statistics WHERE question_statistics.question_id = questions.id) >= ?', [$minAttempts]);
    }

}
