<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menuPermissions = [
            // Main Menus
            ['name' => 'menu-dashboard', 'display_name' => 'Dashboard Menu', 'description' => 'Access to dashboard menu'],
            ['name' => 'menu-students', 'display_name' => 'Students Menu', 'description' => 'Access to students menu'],
            ['name' => 'menu-teachers', 'display_name' => 'Teachers Menu', 'description' => 'Access to teachers menu'],
            ['name' => 'menu-courses', 'display_name' => 'Courses Menu', 'description' => 'Access to courses menu'],
            ['name' => 'menu-subjects', 'display_name' => 'Subjects Menu', 'description' => 'Access to subjects menu'],
            ['name' => 'menu-topics', 'display_name' => 'Topics Menu', 'description' => 'Access to topics menu'],
            ['name' => 'menu-batches', 'display_name' => 'Batches Menu', 'description' => 'Access to batches menu'],
            ['name' => 'menu-questions', 'display_name' => 'Questions Menu', 'description' => 'Access to questions menu'],
            ['name' => 'menu-exams', 'display_name' => 'Exams Menu', 'description' => 'Access to exams menu'],
            ['name' => 'menu-results', 'display_name' => 'Results Menu', 'description' => 'Access to results menu'],
            ['name' => 'menu-analytics', 'display_name' => 'Analytics Menu', 'description' => 'Access to analytics menu'],
            ['name' => 'menu-reports', 'display_name' => 'Reports Menu', 'description' => 'Access to reports menu'],
            ['name' => 'menu-sms', 'display_name' => 'SMS Menu', 'description' => 'Access to SMS menu'],
            ['name' => 'menu-settings', 'display_name' => 'Settings Menu', 'description' => 'Access to settings menu'],
            ['name' => 'menu-users', 'display_name' => 'Users Menu', 'description' => 'Access to users menu'],
            ['name' => 'menu-access-control', 'display_name' => 'Access Control Menu', 'description' => 'Access to access control menu'],
        ];

        foreach ($menuPermissions as $permission) {
            try {
                // Check if permission already exists
                $exists = DB::table('permissions')->where('name', $permission['name'])->exists();
                
                if (!$exists) {
                    DB::table('permissions')->insert([
                        'name' => $permission['name'],
                        'display_name' => $permission['display_name'],
                        'description' => $permission['description'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    
                    $this->command->info("✓ Created: {$permission['name']}");
                } else {
                    $this->command->info("○ Exists: {$permission['name']}");
                }
            } catch (\Exception $e) {
                $this->command->warn("✗ Error with {$permission['name']}: " . $e->getMessage());
            }
        }
        
        $this->command->info("\n✅ Menu permissions seeded successfully!");
        
        // Assign all menu permissions to Partner role
        $this->assignMenuPermissionsToPartner();
    }
    
    /**
     * Assign all menu permissions to Partner role
     */
    protected function assignMenuPermissionsToPartner(): void
    {
        try {
            $partnerRole = DB::table('roles')->where('name', 'partner')->first();
            
            if (!$partnerRole) {
                $this->command->warn("⚠ Partner role not found. Skipping permission assignment.");
                return;
            }
            
            $menuPermissions = DB::table('permissions')
                ->where('name', 'LIKE', 'menu-%')
                ->get();
            
            $assigned = 0;
            $skipped = 0;
            
            foreach ($menuPermissions as $permission) {
                try {
                    // Check if already assigned
                    $exists = DB::table('role_permissions')
                        ->where('enhanced_role_id', $partnerRole->id)
                        ->where('enhanced_permission_id', $permission->id)
                        ->exists();
                    
                    if (!$exists) {
                        DB::table('role_permissions')->insert([
                            'enhanced_role_id' => $partnerRole->id,
                            'enhanced_permission_id' => $permission->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        $assigned++;
                    } else {
                        $skipped++;
                    }
                } catch (\Exception $e) {
                    $this->command->warn("Error assigning {$permission->name}: " . $e->getMessage());
                }
            }
            
            $this->command->info("✅ Assigned {$assigned} menu permissions to Partner role (skipped {$skipped} existing)");
        } catch (\Exception $e) {
            $this->command->error("Error in assignMenuPermissionsToPartner: " . $e->getMessage());
        }
    }
}
