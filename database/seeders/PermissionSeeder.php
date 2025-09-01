<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\SystemSetting;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding permissions system...');

        // Create default roles with permissions
        $this->createDefaultRoles();

        // Create default system settings
        $this->createDefaultSettings();

        $this->command->info('Permissions system seeded successfully!');
    }

    /**
     * Create default roles with permissions
     */
    private function createDefaultRoles()
    {
        // Administrator role
        $adminRole = Role::create([
            'name' => 'Administrator',
            'display_name' => 'Administrator',
            'slug' => 'administrator',
            'description' => 'Full system access and control',
            'permissions' => [
                'dashboard' => ['full'],
                'students' => ['full'],
                'courses' => ['full'],
                'exams' => ['full'],
                'reports' => ['full'],
                'settings' => ['full']
            ],
            'created_by' => 1, // Assuming user ID 1 exists
            'updated_by' => 1
        ]);

        // Teacher role
        $teacherRole = Role::create([
            'name' => 'Teacher',
            'display_name' => 'Teacher',
            'slug' => 'teacher',
            'description' => 'Course and student management',
            'permissions' => [
                'dashboard' => ['full'],
                'students' => ['full'],
                'courses' => ['full'],
                'exams' => ['full'],
                'reports' => ['limited'],
                'settings' => ['none']
            ],
            'created_by' => 1,
            'updated_by' => 1
        ]);

        // Assistant role
        $assistantRole = Role::create([
            'name' => 'Assistant',
            'display_name' => 'Assistant',
            'slug' => 'assistant',
            'description' => 'Limited access to assigned areas',
            'permissions' => [
                'dashboard' => ['limited'],
                'students' => ['limited'],
                'courses' => ['read'],
                'exams' => ['limited'],
                'reports' => ['read'],
                'settings' => ['none']
            ],
            'created_by' => 1,
            'updated_by' => 1
        ]);

        // Viewer role
        $viewerRole = Role::create([
            'name' => 'Viewer',
            'display_name' => 'Viewer',
            'slug' => 'viewer',
            'description' => 'Read-only access to reports',
            'permissions' => [
                'dashboard' => ['read'],
                'students' => ['read'],
                'courses' => ['read'],
                'exams' => ['read'],
                'reports' => ['read'],
                'settings' => ['none']
            ],
            'created_by' => 1,
            'updated_by' => 1
        ]);

        $this->command->info('Created 4 default roles: Administrator, Teacher, Assistant, Viewer');
    }

    /**
     * Create default system settings
     */
    private function createDefaultSettings()
    {
        $defaultSettings = [
            'session_timeout' => 30,
            'max_sessions' => 3,
            'idle_timeout' => 15,
            'permission_inheritance' => true,
            'inherit_parent_permissions' => true,
            'allow_permission_overrides' => false,
            'log_permission_changes' => true,
            'track_user_access' => true,
            'notify_security_events' => false
        ];

        foreach ($defaultSettings as $key => $value) {
            SystemSetting::setValue(
                $key,
                $value,
                is_bool($value) ? 'boolean' : 'integer',
                'Default permission system setting',
                'permissions',
                1 // created_by
            );
        }

        $this->command->info('Created default system settings');
    }
}
