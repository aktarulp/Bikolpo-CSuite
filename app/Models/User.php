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
        'partner_id',
        'status',
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
     * Get the role associated with the user
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
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
     * Check if user is System Administrator
     */
    public function isSystemAdministrator(): bool
    {
        return $this->role && $this->role->name === 'system_administrator';
    }

    /**
     * Check if user is Partner Admin
     */
    public function isPartnerAdmin(): bool
    {
        return $this->role && $this->role->name === 'partner_admin';
    }

    /**
     * Check if user is Student
     */
    public function isStudentRole(): bool
    {
        return $this->role && $this->role->name === 'student';
    }

    /**
     * Check if user is Teacher
     */
    public function isTeacherRole(): bool
    {
        return $this->role && $this->role->name === 'teacher';
    }

    /**
     * Check if user is Operator
     */
    public function isOperatorRole(): bool
    {
        return $this->role && $this->role->name === 'operator';
    }

    /**
     * Check if user can manage another user
     */
    public function canManageUser(User $user): bool
    {
        // System Administrator can manage everyone
        if ($this->isSystemAdministrator()) {
            return true;
        }

        // Partner Admin can only manage users with roles 3, 4, 5 (Student, Teacher, Operator)
        // and only within their own partner
        if ($this->isPartnerAdmin()) {
            return $user->role && 
                   in_array($user->role->level, [3, 4, 5]) &&
                   $user->partner_id === $this->partner_id;
        }

        // Students, Teachers, and Operators cannot manage other users
        return false;
    }

    /**
     * Check if user can view another user
     */
    public function canViewUser(User $user): bool
    {
        // System Administrator can view everyone
        if ($this->isSystemAdministrator()) {
            return true;
        }

        // Partner Admin can view users within their partner
        if ($this->isPartnerAdmin()) {
            return $user->partner_id === $this->partner_id;
        }

        // Students, Teachers, and Operators can view other users
        // except Partner Admins
        if ($this->isStudentRole() || $this->isTeacherRole() || $this->isOperatorRole()) {
            return !$user->isPartnerAdmin();
        }

        return false;
    }

    /**
     * Check if user can create users with specific role
     */
    public function canCreateUsersWithRole(Role $role): bool
    {
        // System Administrator can create any role
        if ($this->isSystemAdministrator()) {
            return true;
        }

        // Partner Admin can only create users with roles 3, 4, 5
        if ($this->isPartnerAdmin()) {
            return in_array($role->level, [3, 4, 5]);
        }

        // Other roles cannot create users
        return false;
    }

    /**
     * Get manageable users for this user
     */
    public function getManageableUsers()
    {
        if ($this->isSystemAdministrator()) {
            return User::with('role')->get();
        }

        if ($this->isPartnerAdmin()) {
            return User::with('role')
                ->where('partner_id', $this->partner_id)
                ->whereHas('role', function($query) {
                    $query->whereIn('level', [3, 4, 5]); // Student, Teacher, Operator
                })
                ->get();
        }

        // Other roles cannot manage users
        return collect();
    }

    /**
     * Get viewable users for this user
     */
    public function getViewableUsers()
    {
        if ($this->isSystemAdministrator()) {
            return User::with('role')->get();
        }

        if ($this->isPartnerAdmin()) {
            return User::with('role')
                ->where('partner_id', $this->partner_id)
                ->get();
        }

        // Students, Teachers, and Operators can view all users except Partner Admins
        if ($this->isStudentRole() || $this->isTeacherRole() || $this->isOperatorRole()) {
            return User::with('role')
                ->whereHas('role', function($query) {
                    $query->where('name', '!=', 'partner_admin');
                })
                ->get();
        }

        return collect();
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
     * Get all enhanced roles assigned to this user
     */
    public function roles()
    {
        return $this->belongsToMany(EnhancedRole::class, 'user_roles', 'user_id', 'role_id')
                    ->withPivot('assigned_by', 'assigned_at', 'expires_at')
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
