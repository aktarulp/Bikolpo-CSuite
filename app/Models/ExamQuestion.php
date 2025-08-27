<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    use HasFactory;

    protected $table = 'exam_questions';

    protected $fillable = [
        'exam_id',
        'question_id',
        'order',
        'marks',
    ];

    protected $casts = [
        'order' => 'integer',
        'marks' => 'integer',
    ];

    /**
     * Get the exam that owns this exam question.
     */
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * Get the question that belongs to this exam question.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get all exams that use this exam question.
     */
    public function exams()
    {
        return $this->hasMany(Exam::class, 'exam_question_id');
    }
}
