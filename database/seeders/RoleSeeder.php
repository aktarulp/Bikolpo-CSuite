<?php

namespace Database\Seeders;

use App\Models\EnhancedRole;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing roles
        EnhancedRole::query()->delete();

        // Create the 5 hierarchical roles
        $roles = [
            [
                'name' => 'system_administrator',
                'display_name' => 'System Administrator',
                'description' => 'Super user with full system access',
                'level' => 1,
                'parent_role_id' => null,
                'status' => 'active',
                'permissions' => [
                    'system' => ['full'],
                    'users' => ['full'],
                    'roles' => ['full'],
                    'permissions' => ['full'],
                    'partners' => ['full'],
                    'students' => ['full'],
                    'operators' => ['full'],
                    'reports' => ['full'],
                    'settings' => ['full']
                ]
            ],
            [
                'name' => 'partner_admin',
                'display_name' => 'Partner Admin',
                'description' => 'Main administrator of each partner',
                'level' => 2,
                'parent_role_id' => null, // Will be set to system_administrator after creation
                'status' => 'active',
                'permissions' => [
                    'users' => ['full'],
                    'students' => ['full'],
                    'operators' => ['full'],
                    'reports' => ['full'],
                    'settings' => ['limited']
                ]
            ],
            [
                'name' => 'student',
                'display_name' => 'Student',
                'description' => 'Student role with limited access',
                'level' => 3,
                'parent_role_id' => null, // Will be set to partner_admin after creation
                'status' => 'active',
                'permissions' => [
                    'profile' => ['full'],
                    'courses' => ['read'],
                    'assignments' => ['read'],
                    'grades' => ['read'],
                    'reports' => ['read']
                ]
            ],
            [
                'name' => 'operator',
                'display_name' => 'Operator',
                'description' => 'Operator role with operational access',
                'level' => 5,
                'parent_role_id' => null, // Will be set to partner_admin after creation
                'status' => 'active',
                'permissions' => [
                    'profile' => ['full'],
                    'users' => ['read'],
                    'students' => ['read'],
                    'reports' => ['read'],
                    'settings' => ['read']
                ]
            ]
        ];

        // Create roles and store references
        $createdRoles = [];
        foreach ($roles as $roleData) {
            $createdRoles[$roleData['name']] = EnhancedRole::create(['permissions' => json_encode($roleData['permissions'])] + $roleData);
        }

        // Update parent relationships
        $createdRoles['partner_admin']->update([
            'parent_role_id' => $createdRoles['system_administrator']->id
        ]);

        $createdRoles['student']->update([
            'parent_role_id' => $createdRoles['partner_admin']->id
        ]);


        $createdRoles['operator']->update([
            'parent_role_id' => $createdRoles['partner_admin']->id
        ]);
    }
}
