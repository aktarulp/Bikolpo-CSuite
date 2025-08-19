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
        'difficulty_level',
        'marks',
        'image',
        'status',
        'tags',
        'appearance_history',
    ];

    protected $casts = [
        'question_type' => 'string',
        'difficulty_level' => 'integer',
        'marks' => 'integer',
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

    public function questionSets()
    {
        return $this->belongsToMany(QuestionSet::class, 'question_set_question')
                    ->withPivot('order')
                    ->withTimestamps();
    }

    public function questionHistory()
    {
        return $this->hasMany(QuestionHistory::class);
    }



    // Accessors
    public function getCorrectOptionTextAttribute()
    {
        return $this->{'option_' . $this->correct_answer};
    }

    public function getDifficultyTextAttribute()
    {
        return match($this->difficulty_level) {
            1 => 'Easy',
            2 => 'Medium',
            3 => 'Hard',
            default => 'Unknown'
        };
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



    public function getQuestionTypeTextAttribute()
    {
        return match($this->question_type) {
            'mcq' => 'MCQ',
            'descriptive' => 'Descriptive',
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


}
