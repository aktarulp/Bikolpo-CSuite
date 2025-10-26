<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use App\Models\EnhancedUser;
use App\Models\Partner;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'teachers';

    protected $fillable = [
        'teacher_id',
        'full_name',
        'date_of_birth',
        'gender',
        'photo',
        'email',
        'phone',
        'alternate_phone',
        'father_name',
        'mother_name',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relation',
        'blood_group',
        'religion',
        'marital_status',
        'national_id',
        'passport_number',
        'tin_number',
        'division_id',
        'district_id',
        'upazila_id',
        'post_office',
        'village_road',
        'designation',
        'department',
        'joining_date',
        'employee_type',
        'employment_status',
        'bank_name',
        'bank_account_number',
        'bank_routing_number',
        'partner_id',
        'user_id',
        'created_by',
        'updated_by',
        'last_degree',
        'university',
        'completion_year',
        'achievement',
        'flag',
        'subject_specialization',
        'experience_years',
        'highest_degree',
        'institution_name',
        'salary_type',
        'salary_amount',
        'payment_method',
        'account_details',
        'present_address',
        'permanent_address',
        'notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'joining_date' => 'date',
        'completion_year' => 'integer',
    ];


    // Relationships
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function user()
    {
        return $this->belongsTo(EnhancedUser::class);
    }

    public function creator()
    {
        return $this->belongsTo(EnhancedUser::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(EnhancedUser::class, 'updated_by');
    }

    // Many-to-many relationships for assignments
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'teacher_courses')
                    ->withPivot('assigned_at', 'assigned_by')
                    ->withTimestamps();
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subjects')
                    ->withPivot('assigned_at', 'assigned_by')
                    ->withTimestamps();
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'teacher_students')
                    ->withPivot('assigned_at', 'assigned_by')
                    ->withTimestamps();
    }

    public function batches()
    {
        return $this->belongsToMany(Batch::class, 'teacher_batches')
                    ->withPivot('assigned_at', 'assigned_by')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('employment_status', 'Active');
    }

    public function scopeForPartner($query, $partnerId)
    {
        return $query->where('partner_id', $partnerId);
    }

    // Accessors
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            // Direct approach - photos are stored directly in public/uploads/teachers/
            return asset('uploads/' . $this->photo);
        }
        return asset('images/default-avatar.svg');
    }


    public function getAgeAttribute()
    {
        if ($this->date_of_birth) {
            return $this->date_of_birth->age;
        }
        return null;
    }

    // Mutators
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = $value ? strtolower($value) : null;
    }


    public function getStatusBadgeClass()
    {
        return match($this->employment_status) {
            'Active' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
            'Inactive' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400',
            'On Leave' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400',
        };
    }

    public function getGenderIcon()
    {
        return match(strtolower($this->gender)) {
            'male' => '👨',
            'female' => '👩',
            'other' => '👤',
            default => '👤',
        };
    }

}
