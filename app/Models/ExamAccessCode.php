<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAccessCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'student_id',
        'access_code',
        'status',
        'used_at',
        'expires_at',
    ];

    protected $casts = [
        'used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // Relationships
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeValid($query)
    {
        return $query->where('status', 'active')
                    ->where(function ($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }

    // Methods
    public function markAsUsed()
    {
        $this->update([
            'status' => 'used',
            'used_at' => now(),
        ]);
    }

    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isValid()
    {
        return $this->status === 'active' && !$this->isExpired();
    }

    // Generate unique 6-digit access code
    public static function generateUniqueCode()
    {
        do {
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (static::where('access_code', $code)->exists());

        return $code;
    }
}
