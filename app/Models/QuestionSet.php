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
        'total_questions',
        'total_marks',
        'time_limit',
        'status',
        'flag',
        'language',
        'question_limit',
        'question_head',
        'created_by',
    ];

    protected $casts = [
        'total_questions' => 'integer',
        'total_marks' => 'integer',
        'time_limit' => 'integer',
        'question_limit' => 'integer',
    ];

    // Relationships
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_set_question')
                    ->withPivot('order', 'marks', 'status')
                    ->withTimestamps();
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
