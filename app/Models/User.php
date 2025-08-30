<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'name' => 'string',
    ];

    /**
     * Check if the user is a partner
     *
     * @return bool
     */
    public function isPartner()
    {
        return $this->role === 'partner';
    }

    /**
     * Check if the user is a student
     *
     * @return bool
     */
    public function isStudent()
    {
        return $this->role === 'student';
    }

    /**
     * Get the partner profile associated with the user
     */
    public function partner()
    {
        return $this->hasOne(Partner::class);
    }

    /**
     * Get the partner ID for the user
     */
    public function getPartnerIdAttribute()
    {
        return $this->partner?->id;
    }

    /**
     * Get the student profile associated with the user
     */
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    /**
     * Get courses created by this user
     */
    public function createdCourses()
    {
        return $this->hasMany(Course::class, 'created_by');
    }

    /**
     * Get subjects created by this user
     */
    public function createdSubjects()
    {
        return $this->hasMany(Subject::class, 'created_by');
    }

    /**
     * Get topics created by this user
     */
    public function createdTopics()
    {
        return $this->hasMany(Topic::class, 'created_by');
    }
}
