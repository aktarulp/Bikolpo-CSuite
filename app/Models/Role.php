<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    // Relationships
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Scopes
    public function scopePartner($query)
    {
        return $query->where('name', 'partner');
    }

    public function scopeStudent($query)
    {
        return $query->where('name', 'student');
    }

    // Accessors
    public function getIsPartnerAttribute()
    {
        return $this->name === 'partner';
    }

    public function getIsStudentAttribute()
    {
        return $this->name === 'student';
    }
}
