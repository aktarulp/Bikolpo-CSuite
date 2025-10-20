<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressPivot extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'progress_pivot';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'topic_id',
        'completion_percentage',
        'total_questions',
        'attempted_questions',
        'correct_answers',
        'wrong_answers',
        'unanswered_questions',
        'last_activity_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'completion_percentage' => 'decimal:2',
        'total_questions' => 'integer',
        'attempted_questions' => 'integer',
        'correct_answers' => 'integer',
        'wrong_answers' => 'integer',
        'unanswered_questions' => 'integer',
        'last_activity_at' => 'datetime',
    ];

    /**
     * Get the student that owns this progress record.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the topic that this progress record belongs to.
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}