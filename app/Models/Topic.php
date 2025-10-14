<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'name',
        'code',
        'description',
        'chapter_number',
        'status',
        'flag',
        'partner_id',
        'created_by',
    ];

    protected $casts = [
        'status' => 'string',
        'flag' => 'string',
    ];

    // Relationships
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function course()
    {
        return $this->belongsToThrough(Course::class, Subject::class);
    }

    /**
     * Get the progress records for this topic.
     */
    public function progressRecords()
    {
        return $this->hasMany(ProgressPivot::class);
    }

    /**
     * Get average progress percentage for this topic across all students
     *
     * @return float
     */
    public function getAverageProgressPercentage()
    {
        return $this->progressRecords()->avg('completion_percentage') ?? 0;
    }

    /**
     * Get progress data for a specific student on this topic
     *
     * @param int $studentId
     * @return ProgressPivot|null
     */
    public function getStudentProgress($studentId)
    {
        return $this->progressRecords()->where('student_id', $studentId)->first();
    }
}