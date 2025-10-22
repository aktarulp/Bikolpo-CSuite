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
        'slug', 
        'logo',
        'city',
        'map_location',
        'mobile',
        'alternate_mobile',
        'website',
        'facebook_page',
        'division',
        'district',
        'established_year',
        'created_by',
        'institute_name',
            'owner_director_contact',
        'alternate_contact_person',
        'alternate_contact_no',
        'post_office',
        'post_code',
        'village_road_no',
        'flat_house_no',
        'institute_name_bangla',
        'slug_bangla',
            'short_address',
            'short_address_bangla',
        'course_offers',
        // Additional fields from database
        'referral_code',
        'total_referrals',
        'successful_referrals',
        'referral_earnings',
        'upazila',
        'owner_director_name',
        'eiin_no',
        'trade_license_no',
        'tin_no',
        'cover_photo',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Relationships
    public function user()
    {
        // Partner doesn't belong to a single user, but has many users
        // This method should return the primary user if needed, or null
        return $this->users()->first();
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // public function questionSets()
    // {
    //     return $this->hasMany(QuestionSet::class);
    // }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    /**
     * Get all exam results for exams created by this partner
     */
    public function examResults()
    {
        return $this->hasManyThrough(ExamResult::class, Exam::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
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

    public function users()
    {
        return $this->hasMany(EnhancedUser::class);
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
}
