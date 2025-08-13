<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'year',
        'status',
        'flag',
        'partner_id'
    ];

    protected $casts = [
        'year' => 'integer'
    ];

    // Relationships
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    // Scopes
    public function scopeByPartner($query, $partnerId)
    {
        return $query->where('partner_id', $partnerId);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeNotDeleted($query)
    {
        return $query->where('flag', '!=', 'deleted');
    }

    public function scopeVisible($query)
    {
        return $query->where('flag', 'active');
    }
}
