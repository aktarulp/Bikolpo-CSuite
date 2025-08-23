<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'institute_name',
        'institute_name_bangla',
        'slug',
        'slug_bangla',
        'partner_category',
        'logo',
        'cover_photo',
        'description',
        'owner_name',
        'owner_director_name',
        'primary_contact_person',
        'primary_contact_no',
        'alternate_contact_person',
        'alternate_contact_no',
        'mobile',
        'alternate_mobile',
        'website',
        'facebook_page',
        'division',
        'district',
        'upazila',
        'upazila_p_s',
        'post_office',
        'post_code',
        'village_road_no',
        'flat_house_no',
        'short_address',
        'address',
        'map_location',
        'established_year',
        'year_of_establishment',
        'eiin_no',
        'trade_license_no',
        'tin_no',
        'category',
        'target_group',
        'subjects_offered',
        'class_range',
        'total_teachers',
        'total_students',
        'batch_system',
        'course_offers',
        'custom_courses',
        'subscription_plan',
        'subscription_plan_id',
        'subscription_start_date',
        'subscription_end_date',
        'payment_status',
        'status',
        'created_by',
    ];

    protected $casts = [
        'status' => 'string',
        'established_year' => 'integer',
        'year_of_establishment' => 'integer',
        'total_teachers' => 'integer',
        'total_students' => 'integer',
        'batch_system' => 'boolean',
        'course_offers' => 'array',
        'subscription_start_date' => 'date',
        'subscription_end_date' => 'date',
        'payment_status' => 'string',
        'subscription_plan_id' => 'string',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

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
