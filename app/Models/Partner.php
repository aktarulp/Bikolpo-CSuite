<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'slug', 
        'logo',
        'status',
        'flag',
        'city',
        'map_location',
        'mobile',
        'alternate_mobile',
        'website',
        'facebook_page',
        'division_id',
        'district_id',
        'established_year',
        'subscription_plan',
        'subscription_start_date',
        'subscription_end_date',
        'payment_status',
        'created_by',
        'institute_name',
        'primary_contact_person',
        'primary_contact_no',
        'alternate_contact_person',
        'alternate_contact_no',
        'upazila_id',
        'post_office',
        'post_code',
        'village_road_no',
        'flat_house_no',
        'subscription_plan_id',
        'institute_name_bangla',
        'slug_bangla',
        'year_of_establishment',
        'short_address',
        'course_offers',
        'custom_courses',
        'referral_code',
        'total_referrals',
        'successful_referrals',
        'referral_earnings'
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

    public function division()
    {
        return $this->belongsTo(\App\Models\Division::class);
    }

    public function district()
    {
        return $this->belongsTo(\App\Models\District::class);
    }

    public function upazila()
    {
        return $this->belongsTo(\App\Models\Upazila::class);
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

    // Referral relationships
    public function referralCodes(): HasMany
    {
        return $this->hasMany(ReferralCode::class, 'referrer_id');
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    public function referredBy(): HasMany
    {
        return $this->hasMany(Referral::class, 'referred_id');
    }

    public function referralRewards(): HasMany
    {
        return $this->hasMany(ReferralReward::class, 'referrer_id');
    }

    public function getActiveReferralCode(): ?ReferralCode
    {
        return $this->referralCodes()
            ->where('is_active', true)
            ->where(function($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>', now());
            })
            ->first();
    }

    public function generateReferralCode(): ReferralCode
    {
        $code = ReferralCode::createForPartner($this, [
            'name' => $this->name . ' Referral Code',
            'description' => 'Invite & Earn referral code for ' . $this->name
        ]);

        // Update partner's referral code
        $this->update(['referral_code' => $code->code]);

        return $code;
    }

    public function getReferralStats(): array
    {
        return [
            'total_referrals' => $this->total_referrals,
            'successful_referrals' => $this->successful_referrals,
            'referral_earnings' => $this->referral_earnings,
            'success_rate' => $this->total_referrals > 0 
                ? round(($this->successful_referrals / $this->total_referrals) * 100, 1) 
                : 0
        ];
    }
}
