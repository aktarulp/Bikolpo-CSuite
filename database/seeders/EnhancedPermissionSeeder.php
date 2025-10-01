<?php

namespace Database\Seeders;

use App\Models\EnhancedRole;
use App\Models\EnhancedPermission;
use Illuminate\Database\Seeder;

class EnhancedPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding enhanced permissions system...');

        // Create default permissions
        $permissions = $this->createDefaultPermissions();
        
        // Assign permissions to roles
        $this->assignPermissionsToRoles($permissions);

        $this->command->info('Enhanced permissions system seeded successfully!');
    }

    /**
     * Create default permissions
     */
    private function createDefaultPermissions()
    {
        $permissions = [];

        // Dashboard permissions
        $permissions[] = EnhancedPermission::create([
            'name' => 'dashboard.view',
            'display_name' => 'View Dashboard',
            'module' => 'dashboard',
            'action' => 'view',
            'description' => 'Access to view the dashboard',
            'status' => 'active',
            'is_system' => true,
        ]);

        // User management permissions
        $permissions[] = EnhancedPermission::create([
            'name' => 'users.view',
            'display_name' => 'View Users',
            'module' => 'users',
            'action' => 'view',
            'description' => 'View user list and details',
            'status' => 'active',
            'is_system' => true,
        ]);

        $permissions[] = EnhancedPermission::create([
            'name' => 'users.create',
            'display_name' => 'Create Users',
            'module' => 'users',
            'action' => 'create',
            'description' => 'Create new users',
            'status' => 'active',
            'is_system' => true,
        ]);

        $permissions[] = EnhancedPermission::create([
            'name' => 'users.edit',
            'display_name' => 'Edit Users',
            'module' => 'users',
            'action' => 'edit',
            'description' => 'Edit existing users',
            'status' => 'active',
            'is_system' => true,
        ]);

        $permissions[] = EnhancedPermission::create([
            'name' => 'users.delete',
            'display_name' => 'Delete Users',
            'module' => 'users',
            'action' => 'delete',
            'description' => 'Delete users',
            'status' => 'active',
            'is_system' => true,
        ]);

        // Role management permissions
        $permissions[] = EnhancedPermission::create([
            'name' => 'roles.view',
            'display_name' => 'View Roles',
            'module' => 'roles',
            'action' => 'view',
            'description' => 'View roles and permissions',
            'status' => 'active',
            'is_system' => true,
        ]);

        $permissions[] = EnhancedPermission::create([
            'name' => 'roles.create',
            'display_name' => 'Create Roles',
            'module' => 'roles',
            'action' => 'create',
            'description' => 'Create new roles',
            'status' => 'active',
            'is_system' => true,
        ]);

        $permissions[] = EnhancedPermission::create([
            'name' => 'roles.edit',
            'display_name' => 'Edit Roles',
            'module' => 'roles',
            'action' => 'edit',
            'description' => 'Edit existing roles',
            'status' => 'active',
            'is_system' => true,
        ]);

        $permissions[] = EnhancedPermission::create([
            'name' => 'roles.delete',
            'display_name' => 'Delete Roles',
            'module' => 'roles',
            'action' => 'delete',
            'description' => 'Delete roles',
            'status' => 'active',
            'is_system' => true,
        ]);

        // Course management permissions
        $permissions[] = EnhancedPermission::create([
            'name' => 'courses.view',
            'display_name' => 'View Courses',
            'module' => 'courses',
            'action' => 'view',
            'description' => 'View courses',
            'status' => 'active',
            'is_system' => true,
        ]);

        $permissions[] = EnhancedPermission::create([
            'name' => 'courses.create',
            'display_name' => 'Create Courses',
            'module' => 'courses',
            'action' => 'create',
            'description' => 'Create new courses',
            'status' => 'active',
            'is_system' => true,
        ]);

        $permissions[] = EnhancedPermission::create([
            'name' => 'courses.edit',
            'display_name' => 'Edit Courses',
            'module' => 'courses',
            'action' => 'edit',
            'description' => 'Edit existing courses',
            'status' => 'active',
            'is_system' => true,
        ]);

        $permissions[] = EnhancedPermission::create([
            'name' => 'courses.delete',
            'display_name' => 'Delete Courses',
            'module' => 'courses',
            'action' => 'delete',
            'description' => 'Delete courses',
            'status' => 'active',
            'is_system' => true,
        ]);

        // Exam management permissions
        $permissions[] = EnhancedPermission::create([
            'name' => 'exams.view',
            'display_name' => 'View Exams',
            'module' => 'exams',
            'action' => 'view',
            'description' => 'View exams',
            'status' => 'active',
            'is_system' => true,
        ]);

        $permissions[] = EnhancedPermission::create([
            'name' => 'exams.create',
            'display_name' => 'Create Exams',
            'module' => 'exams',
            'action' => 'create',
            'description' => 'Create new exams',
            'status' => 'active',
            'is_system' => true,
        ]);

        $permissions[] = EnhancedPermission::create([
            'name' => 'exams.edit',
            'display_name' => 'Edit Exams',
            'module' => 'exams',
            'action' => 'edit',
            'description' => 'Edit existing exams',
            'status' => 'active',
            'is_system' => true,
        ]);

        $permissions[] = EnhancedPermission::create([
            'name' => 'exams.delete',
            'display_name' => 'Delete Exams',
            'module' => 'exams',
            'action' => 'delete',
            'description' => 'Delete exams',
            'status' => 'active',
            'is_system' => true,
        ]);

        // Settings permissions
        $permissions[] = EnhancedPermission::create([
            'name' => 'settings.view',
            'display_name' => 'View Settings',
            'module' => 'settings',
            'action' => 'view',
            'description' => 'View system settings',
            'status' => 'active',
            'is_system' => true,
        ]);

        $permissions[] = EnhancedPermission::create([
            'name' => 'settings.edit',
            'display_name' => 'Edit Settings',
            'module' => 'settings',
            'action' => 'edit',
            'description' => 'Edit system settings',
            'status' => 'active',
            'is_system' => true,
        ]);

        return $permissions;
    }

    /**
     * Assign permissions to roles based on hierarchy
     */
    private function assignPermissionsToRoles($permissions)
    {
        // Get all permissions by name for easier assignment
        $permissionMap = collect($permissions)->keyBy('name');

        // Get roles
        $systemAdmin = EnhancedRole::where('name', 'system_administrator')->first();
        $partnerAdmin = EnhancedRole::where('name', 'partner_admin')->first();
        $student = EnhancedRole::where('name', 'student')->first();
        $teacher = EnhancedRole::where('name', 'teacher')->first();
        $operator = EnhancedRole::where('name', 'operator')->first();

        if (!$systemAdmin || !$partnerAdmin || !$student || !$teacher || !$operator) {
            $this->command->error('Roles not found. Please run RoleSeeder first.');
            return;
        }

        // System Administrator gets ALL permissions
        $allPermissions = $permissionMap->keys();
        foreach ($allPermissions as $permissionName) {
            $systemAdmin->permissions()->attach($permissionMap[$permissionName]->id, [
                'granted_by' => 1,
                'granted_at' => now()
            ]);
        }

        // Partner Admin gets most permissions (except system-level settings)
        $partnerAdminPermissions = [
            'dashboard.view',
            'users.view', 'users.create', 'users.edit',
            'roles.view',
            'courses.view', 'courses.create', 'courses.edit',
            'exams.view', 'exams.create', 'exams.edit',
            'settings.view'
        ];

        foreach ($partnerAdminPermissions as $permissionName) {
            if ($permissionMap->has($permissionName)) {
                $partnerAdmin->permissions()->attach($permissionMap[$permissionName]->id, [
                    'granted_by' => 1,
                    'granted_at' => now()
                ]);
            }
        }

        // Teacher gets course and exam related permissions
        $teacherPermissions = [
            'dashboard.view',
            'users.view',
            'courses.view', 'courses.edit',
            'exams.view', 'exams.create', 'exams.edit'
        ];

        foreach ($teacherPermissions as $permissionName) {
            if ($permissionMap->has($permissionName)) {
                $teacher->permissions()->attach($permissionMap[$permissionName]->id, [
                    'granted_by' => 1,
                    'granted_at' => now()
                ]);
            }
        }

        // Student gets view permissions only
        $studentPermissions = [
            'dashboard.view',
            'courses.view',
            'exams.view'
        ];

        foreach ($studentPermissions as $permissionName) {
            if ($permissionMap->has($permissionName)) {
                $student->permissions()->attach($permissionMap[$permissionName]->id, [
                    'granted_by' => 1,
                    'granted_at' => now()
                ]);
            }
        }

        // Operator gets operational permissions
        $operatorPermissions = [
            'dashboard.view',
            'users.view',
            'courses.view',
            'exams.view', 'exams.create', 'exams.edit'
        ];

        foreach ($operatorPermissions as $permissionName) {
            if ($permissionMap->has($permissionName)) {
                $operator->permissions()->attach($permissionMap[$permissionName]->id, [
                    'granted_by' => 1,
                    'granted_at' => now()
                ]);
            }
        }
    }
}
