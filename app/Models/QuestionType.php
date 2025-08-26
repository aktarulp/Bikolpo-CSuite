<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    protected $primaryKey = 'q_type_id';
    
    protected $fillable = [
        'q_type_name',
        'q_type_code',
        'description',
        'status',
        'sort_order',
        'has_options',
        'has_explanation',
        'has_image',
        'has_marks',
        'partner_id',
    ];

    protected $casts = [
        'has_options' => 'boolean',
        'has_explanation' => 'boolean',
        'has_image' => 'boolean',
        'has_marks' => 'boolean',
        'sort_order' => 'integer',
        'partner_id' => 'integer',
    ];

    // Relationships
    public function questions()
    {
        return $this->hasMany(Question::class, 'question_type_id', 'q_type_id');
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function scopeByPartner($query, $partnerId)
    {
        return $query->where('partner_id', $partnerId);
    }

    public function scopeGlobal($query)
    {
        return $query->whereNull('partner_id');
    }

    // Accessors
    public function getDisplayNameAttribute()
    {
        return $this->q_type_name;
    }

    public function getShortCodeAttribute()
    {
        return $this->q_type_code;
    }
}
