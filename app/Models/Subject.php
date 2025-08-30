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

    // Many-to-many relationship with courses
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'subject_on_course')
                    ->withPivot('partner_id')
                    ->withTimestamps();
    }



    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function questions()
    {
        return $this->hasManyThrough(Question::class, Topic::class);
    }
}
