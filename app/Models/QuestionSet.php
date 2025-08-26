<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionSet extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'name',
        'description',
        'question_head',
        'language',
        'total_questions',
        'question_limit',
        'total_marks',
        'time_limit',
        'status',
    ];

    protected $casts = [
        'total_questions' => 'integer',
        'question_limit' => 'integer',
        'total_marks' => 'integer',
        'time_limit' => 'integer',
        'status' => 'string',
    ];

    // Relationships
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_set_question')
                    ->withPivot('order', 'marks')
                    ->withTimestamps()
                    ->orderBy('question_set_question.order');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    // Methods
    public function updateTotals()
    {
        $this->total_questions = $this->questions()->count();
        $this->total_marks = $this->questions()->sum('question_set_question.marks');
        $this->save();
    }
}
