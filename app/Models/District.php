<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    protected $fillable = [
        'division_id',
        'name',
        'name_bangla',
    ];

    /**
     * Get the division that this district belongs to.
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Get all upazilas for this district.
     */
    public function upazilas(): HasMany
    {
        return $this->hasMany(Upazila::class);
    }
}
