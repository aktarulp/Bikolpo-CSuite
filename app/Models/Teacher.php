<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Teacher extends Model
{
    use HasFactory; // Temporarily removed SoftDeletes

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
        'father_phone',
        'mother_name',
        'mother_phone',
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
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
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
            // Use Laravel's storage URL for public disk
            return Storage::disk('public')->url($this->photo);
        }
        return asset('images/default-avatar.png');
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

    // Helper methods
    public static function generateTeacherId($partnerId)
    {
        $year = date('Y');
        $partner = Partner::find($partnerId);
        $prefix = $partner ? strtoupper(substr($partner->name, 0, 3)) : 'TCH';
        
        $lastTeacher = self::where('partner_id', $partnerId)
                          ->where('teacher_id', 'like', "{$prefix}-{$year}-%")
                          ->orderBy('teacher_id', 'desc')
                          ->first();

        if ($lastTeacher) {
            $lastNumber = (int) substr($lastTeacher->teacher_id, -3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . '-' . $year . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
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

    // Boot method for auto-generating teacher_id
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($teacher) {
            if (!$teacher->teacher_id) {
                $teacher->teacher_id = self::generateTeacherId($teacher->partner_id);
            }
        });
    }
}
