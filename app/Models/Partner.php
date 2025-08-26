<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'logo',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Relationships
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function questionSets()
    {
        return $this->hasMany(QuestionSet::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function studentExamResults()
    {
        return $this->hasManyThrough(StudentExamResult::class, Exam::class);
    }
<<<<<<< Updated upstream
=======

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function questionTypes()
    {
        return $this->hasMany(QuestionType::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    // Accessors
    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->address,
            $this->upazila,
            $this->district,
            $this->division
        ]);
        
        return implode(', ', $parts);
    }

    public function getContactInfoAttribute()
    {
        $contacts = array_filter([
            $this->mobile,
            $this->alternate_mobile
        ]);
        
        return implode(' / ', $contacts);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByDistrict($query, $district)
    {
        return $query->where('district', $district);
    }
>>>>>>> Stashed changes
}
