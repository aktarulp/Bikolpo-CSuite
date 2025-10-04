<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'ac_users';

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
     * Get the partner profile associated with the user
     */
    public function partner()
    {
        return $this->hasOne(Partner::class);
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
     * Check if user is Teacher
     */
    public function isTeacherRole(): bool
    {
        if (is_string($this->role)) {
            return $this->role === 'teacher';
        }
        return $this->role && $this->role->name === 'teacher';
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
        return $this->belongsToMany(EnhancedRole::class, 'ac_user_roles', 'user_id', 'role_id')
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
            'enhanced_user_id' => $this->id
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
