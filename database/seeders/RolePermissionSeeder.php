<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear cache before seeding
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Get permission configuration
        $config = config('permissions');
        
        $this->command->info('Starting Role and Permission Seeder...');
        
        // Generate and create permissions
        $this->createPermissions($config['menus']);
        
        // Create roles and assign permissions
        $this->createRoles($config['roles'], $config['menus']);
        
        $this->command->info('Role and Permission Seeder completed successfully!');
    }

    /**
     * Create permissions from configuration
     */
    private function createPermissions(array $menus): void
    {
        $this->command->info('Creating permissions...');
        
        $permissions = [];
        
        foreach ($menus as $menuKey => $menuConfig) {
            // Create menu permission
            $menuPermission = "menu-{$menuKey}";
            $permissions[] = [
                'name' => $menuPermission,
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            // Create button permissions for this menu
            foreach ($menuConfig['buttons'] as $buttonKey => $buttonLabel) {
                $buttonPermission = "{$menuKey}-{$buttonKey}";
                $permissions[] = [
                    'name' => $buttonPermission,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        // Batch insert permissions for better performance
        $chunks = array_chunk($permissions, 100);
        foreach ($chunks as $chunk) {
            DB::table(config('permission.table_names.permissions'))->insertOrIgnore($chunk);
        }
        
        $this->command->info('Created ' . count($permissions) . ' permissions.');
    }

    /**
     * Create roles and assign permissions
     */
    private function createRoles(array $roleConfigs, array $menus): void
    {
        $this->command->info('Creating roles and assigning permissions...');
        
        foreach ($roleConfigs as $roleName => $roleConfig) {
            $this->command->info("Processing role: {$roleName}");
            
            // Create or get the role
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web'
            ]);
            
            // Clear existing permissions for this role
            $role->permissions()->detach();
            
            // Assign permissions
            if ($roleConfig['permissions'] === 'all') {
                // Assign all permissions to this role
                $allPermissions = $this->getAllPermissionNames($menus);
                $role->givePermissionTo($allPermissions);
                $this->command->info("  - Assigned ALL permissions to {$roleName}");
            } else {
                // Assign specific permissions
                $validPermissions = $this->validatePermissions($roleConfig['permissions'], $menus);
                if (!empty($validPermissions)) {
                    $role->givePermissionTo($validPermissions);
                    $this->command->info("  - Assigned " . count($validPermissions) . " permissions to {$roleName}");
                }
            }
        }
    }

    /**
     * Get all permission names from menus configuration
     */
    private function getAllPermissionNames(array $menus): array
    {
        $permissions = [];
        
        foreach ($menus as $menuKey => $menuConfig) {
            // Add menu permission
            $permissions[] = "menu-{$menuKey}";
            
            // Add button permissions
            foreach ($menuConfig['buttons'] as $buttonKey => $buttonLabel) {
                $permissions[] = "{$menuKey}-{$buttonKey}";
            }
        }
        
        return $permissions;
    }

    /**
     * Validate that permissions exist in the configuration
     */
    private function validatePermissions(array $permissions, array $menus): array
    {
        $allValidPermissions = $this->getAllPermissionNames($menus);
        $validPermissions = [];
        
        foreach ($permissions as $permission) {
            if (in_array($permission, $allValidPermissions)) {
                $validPermissions[] = $permission;
            } else {
                $this->command->warn("  - Warning: Permission '{$permission}' not found in configuration");
            }
        }
        
        return $validPermissions;
    }
}
