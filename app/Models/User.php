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
        'created_by',
        'updated_by',
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
        'partner_id' => 'integer',
    ];

    /**
     * Check if the user is a partner
     *
     * @return bool
     */
    public function isPartner()
    {
        if (is_string($this->role)) {
            return $this->role === 'partner';
        }
        return $this->role && $this->role->name === 'partner';
    }

    /**
     * Check if the user is a student
     *
     * @return bool
     */
    public function isStudent()
    {
        if (is_string($this->role)) {
            return $this->role === 'student';
        }
        return $this->role && $this->role->name === 'student';
    }

    /**
     * Get the role associated with the user
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Get the roles assigned to this user.
     * Role checking disabled - returns empty relationship.
     */
    public function roles()
    {
        return $this->belongsToMany(EnhancedRole::class, 'non_existent_table', 'user_id', 'role_id')
                ->whereRaw('1 = 0'); // Always return empty
    }


    /**
     * Get the partner profile associated with the user
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    /**
     * Get the user who created this user
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this user
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get users created by this user
     */
    public function createdUsers()
    {
        return $this->hasMany(User::class, 'created_by');
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
        // Check if role is stored as string or relationship
        if (is_string($this->role)) {
            return $this->role === 'system_administrator';
        }
        return $this->role && $this->role->name === 'system_administrator';
    }

    /**
     * Check if user is Partner Admin
     */
    public function isPartnerAdmin(): bool
    {
        // Check if role is stored as string or relationship
        if (is_string($this->role)) {
            return $this->role === 'partner_admin' || $this->role === 'partner';
        }
        return $this->role && ($this->role->name === 'partner_admin' || $this->role->name === 'partner');
    }

    /**
     * Check if user is Student
     */
    public function isStudentRole(): bool
    {
        if (is_string($this->role)) {
            return $this->role === 'student';
        }
        return $this->role && $this->role->name === 'student';
    }


    /**
     * Check if user is Operator
     */
    public function isOperatorRole(): bool
    {
        if (is_string($this->role)) {
            return $this->role === 'operator';
        }
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

        // Partner Admin can only manage users with roles 3, 5 (Student, Operator)
        // and only within their own partner
        if ($this->isPartnerAdmin()) {
            return $user->role && 
                   in_array($user->role->level, [3, 5]) &&
                   $user->partner_id === $this->partner_id;
        }

        // Students and Operators cannot manage other users
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

        // Students and Operators can view other users
        // except Partner Admins
        if ($this->isStudentRole() || $this->isOperatorRole()) {
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

        // Partner Admin can only create users with roles 3, 5
        if ($this->isPartnerAdmin()) {
            return in_array($role->level, [3, 5]);
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

        // Students and Operators can view all users except Partner Admins
        if ($this->isStudentRole() || $this->isOperatorRole()) {
            return User::with('role')
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
     * Get the primary role (first assigned role)
     * Role checking disabled - returns null.
     */
    public function primaryRole()
    {
        return null;
    }

    /**
     * Check if user has a specific role
     * Role checking disabled - always returns true.
     */
    public function hasRole(string $roleName): bool
    {
        return true;
    }

    /**
     * Check if user has any of the specified roles
     * Role checking disabled - always returns true.
     */
    public function hasAnyRole(array $roleNames): bool
    {
        return true;
    }

    /**
     * Check if user has permission for a specific module and action
     * Permission checking disabled - always returns true.
     */
    public function hasPermission(string $module, string $action): bool
    {
        return true;
    }

    /**
     * Check if user has any permission for a module
     * Permission checking disabled - always returns true.
     */
    public function hasModulePermission(string $module): bool
    {
        return true;
    }

    /**
     * Get all permissions for user across all roles
     * Permission checking disabled - returns empty array.
     */
    public function getAllPermissions(): array
    {
        return [];
    }

    /**
     * Assign a role to the user
     * Role assignment disabled - always returns true.
     */
    public function assignRole(int $roleId, int $assignedBy = null): bool
    {
        return true;
    }

    /**
     * Remove a role from the user
     * Role removal disabled - always returns true.
     */
    public function removeRole(int $roleId): bool
    {
        return true;
    }

    /**
     * Sync user roles (replace all roles with the given ones)
     * Role syncing disabled - always returns true.
     */
    public function syncRoles(array $roleIds, int $assignedBy = null): bool
    {
        return true;
    }
}
