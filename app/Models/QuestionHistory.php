<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionHistory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'question_history';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'record_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question_id',
        'partner_id',
        'public_exam_name',
        'private_exam_name',
        'exam_month',
        'exam_year',
        'remarks',
        'exam_board',
        'exam_type',
        'subject_name',
        'topic_name',
        'question_number',
        'marks_allocated',
        'difficulty_level',
        'source_reference',
        'is_verified',
        'verified_by',
        'verified_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'exam_year' => 'integer',
        'question_number' => 'integer',
        'marks_allocated' => 'integer',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    /**
     * Get the question that owns the history record.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    /**
     * Get the partner that owns the history record.
     */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    /**
     * Scope a query to filter by exam year.
     */
    public function scopeByYear($query, $year)
    {
        return $query->where('exam_year', $year);
    }

    /**
     * Scope a query to filter by exam month.
     */
    public function scopeByMonth($query, $month)
    {
        return $query->where('exam_month', $month);
    }

    /**
     * Scope a query to filter by public exam name.
     */
    public function scopeByExamName($query, $examName)
    {
        return $query->where('public_exam_name', $examName);
    }

    /**
     * Scope a query to filter by exam board.
     */
    public function scopeByBoard($query, $board)
    {
        return $query->where('exam_board', $board);
    }

    /**
     * Scope a query to filter by verification status.
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope a query to filter by unverified status.
     */
    public function scopeUnverified($query)
    {
        return $query->where('is_verified', false);
    }

    /**
     * Scope a query to filter by partner.
     */
    public function scopeByPartner($query, $partnerId)
    {
        return $query->where('partner_id', $partnerId);
    }
}
