<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'status',
        'flag',
        'course_id',
        'partner_id',
        'created_by',
    ];

    protected $casts = [
        'status' => 'string',
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

    // Belongs to one course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }



    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
