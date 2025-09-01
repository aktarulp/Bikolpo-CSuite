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

    /**
     * Get all roles assigned to this user
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles')
                    ->using(UserRole::class)
                    ->withPivot(['assigned_by', 'assigned_at', 'expires_at', 'status'])
                    ->withTimestamps();
    }

    /**
     * Get the primary role (first assigned role)
     */
    public function primaryRole()
    {
        return $this->roles()->first();
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole(string $roleName): bool
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    /**
     * Check if user has any of the specified roles
     */
    public function hasAnyRole(array $roleNames): bool
    {
        return $this->roles()->whereIn('name', $roleNames)->exists();
    }

    /**
     * Check if user has permission for a specific module and action
     */
    public function hasPermission(string $module, string $action): bool
    {
        foreach ($this->roles as $role) {
            if ($role->hasPermission($module, $action)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if user has any permission for a module
     */
    public function hasModulePermission(string $module): bool
    {
        foreach ($this->roles as $role) {
            if (!empty($role->getModulePermissions($module))) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get all permissions for user across all roles
     */
    public function getAllPermissions(): array
    {
        $permissions = [];
        foreach ($this->roles as $role) {
            if (is_array($role->permissions)) {
                foreach ($role->permissions as $module => $actions) {
                    if (!isset($permissions[$module])) {
                        $permissions[$module] = [];
                    }
                    $permissions[$module] = array_merge($permissions[$module], $actions);
                }
            }
        }
        return $permissions;
    }

    /**
     * Assign a role to the user
     */
    public function assignRole(int $roleId, int $assignedBy = null): bool
    {
        $assignedBy = $assignedBy ?? auth()->id();
        
        $this->roles()->attach($roleId, [
            'assigned_by' => $assignedBy,
            'assigned_at' => now(),
            'status' => 'active'
        ]);

        return true;
    }

    /**
     * Remove a role from the user
     */
    public function removeRole(int $roleId): bool
    {
        $this->roles()->detach($roleId);
        return true;
    }

    /**
     * Sync user roles (replace all roles with the given ones)
     */
    public function syncRoles(array $roleIds, int $assignedBy = null): bool
    {
        $assignedBy = $assignedBy ?? auth()->id();
        
        $this->roles()->detach();
        
        foreach ($roleIds as $roleId) {
            $this->assignRole($roleId, $assignedBy);
        }

        return true;
    }
}
