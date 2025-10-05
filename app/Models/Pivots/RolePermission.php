<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RolePermission extends Pivot
{
    protected $table = 'ac_role_permissions';
    public $timestamps = true;
    public $incrementing = false; // composite keys (role_id, module_id)

    protected $fillable = [
        'role_id',
        'module_id',
        'module_name',
        'can_create',
        'can_read',
        'can_update',
        'can_delete',
        'is_default',
        'created_by',
        'granted_by',
        'granted_at',
        'expires_at',
    ];

    protected static function booted()
    {
        static::creating(function (RolePermission $pivot) {
            // Default flags to 'N' if not set
            foreach (['can_create','can_read','can_update','can_delete','is_default'] as $flag) {
                if (is_null($pivot->{$flag}) || $pivot->{$flag} === '') {
                    $pivot->{$flag} = 'N';
                }
            }
            // Set created_by from current user if available
            try {
                if (empty($pivot->created_by) && auth()->check()) {
                    $pivot->created_by = (int) auth()->id();
                }
            } catch (\Throwable $e) {
                // ignore if auth is not available (e.g., during seeding)
            }
        });
    }

    // Accessors: expose flags as booleans when reading
    public function getCanCreateAttribute($value): bool { return strtoupper((string)$value) === 'Y'; }
    public function getCanReadAttribute($value): bool   { return strtoupper((string)$value) === 'Y'; }
    public function getCanUpdateAttribute($value): bool { return strtoupper((string)$value) === 'Y'; }
    public function getCanDeleteAttribute($value): bool { return strtoupper((string)$value) === 'Y'; }
    public function getIsDefaultAttribute($value): bool { return strtoupper((string)$value) === 'Y'; }

    // Mutators: accept booleans/'Y'/'N' and store as 'Y'/'N'
    public function setCanCreateAttribute($value): void { $this->attributes['can_create'] = $this->boolToYN($value); }
    public function setCanReadAttribute($value): void   { $this->attributes['can_read']   = $this->boolToYN($value); }
    public function setCanUpdateAttribute($value): void { $this->attributes['can_update'] = $this->boolToYN($value); }
    public function setCanDeleteAttribute($value): void { $this->attributes['can_delete'] = $this->boolToYN($value); }
    public function setIsDefaultAttribute($value): void { $this->attributes['is_default'] = $this->boolToYN($value); }

    protected function boolToYN($value): string
    {
        if (is_string($value)) {
            return strtoupper($value) === 'Y' ? 'Y' : 'N';
        }
        return $value ? 'Y' : 'N';
    }
}
