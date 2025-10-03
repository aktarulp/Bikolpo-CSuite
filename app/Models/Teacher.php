<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Teacher extends Model
{
    use HasFactory; // Temporarily removed SoftDeletes

    protected $fillable = [
        'teacher_id',
        'full_name_en',
        'full_name_bn',
        'mother_name',
        'gender',
        'dob',
        'blood_group',
        'photo',
        'mobile',
        'alt_mobile',
        'email',
        'present_address',
        'permanent_address',
        'emergency_contact_name',
        'emergency_contact_number',
        'designation',
        'department',
        'subject_specialization',
        'joining_date',
        'experience_years',
        'status',
        'highest_degree',
        'institution_name',
        'salary_type',
        'salary_amount',
        'payment_method',
        'account_details',
        'notes',
        'documents',
        'rating',
        'user_id',
        'partner_id',
        'created_by',
        'updated_by',
        'enable_login',
        'default_role',
    ];

    protected $casts = [
        'dob' => 'date',
        'joining_date' => 'date',
        'salary_amount' => 'decimal:2',
        'rating' => 'decimal:2',
        'documents' => 'array',
        'experience_years' => 'integer',
        'enable_login' => 'string',
    ];

    /**
     * Check if login is enabled for this teacher
     */
    public function isLoginEnabled()
    {
        return $this->enable_login === 'y';
    }

    /**
     * Enable login for this teacher
     */
    public function enableLogin()
    {
        $this->update(['enable_login' => 'y']);
    }

    /**
     * Disable login for this teacher
     */
    public function disableLogin()
    {
        $this->update(['enable_login' => 'n']);
    }


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

    /**
     * Get the default role for this teacher.
     */
    public function defaultRole()
    {
        return $this->belongsTo(EnhancedRole::class, 'default_role', 'name');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    public function scopeForPartner($query, $partnerId)
    {
        return $query->where('partner_id', $partnerId);
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->full_name_en;
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return Storage::url($this->photo);
        }
        return asset('images/default-avatar.png');
    }

    public function getAgeAttribute()
    {
        if ($this->dob) {
            return $this->dob->age;
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
        return match($this->status) {
            'Active' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
            'Inactive' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400',
            'On Leave' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400',
        };
    }

    public function getGenderIcon()
    {
        return match($this->gender) {
            'Male' => '👨',
            'Female' => '👩',
            'Other' => '👤',
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
