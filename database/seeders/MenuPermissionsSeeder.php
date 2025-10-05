<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MenuPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = config('permissions.menus', []);
        $created = 0; $updated = 0; $skipped = 0;

        foreach ($menus as $menuKey => $menuConfig) {
            $menuName = 'menu-' . $menuKey;
            $menuDisplay = $menuConfig['label'] ?? ucfirst($menuKey);
            $this->upsertPermission($menuName, $menuDisplay, "Access to {$menuDisplay} menu", $created, $updated, $skipped);

            $buttons = $menuConfig['buttons'] ?? [];
            foreach ($buttons as $buttonKey => $buttonLabel) {
                $permName = $menuKey . '-' . $buttonKey;
                $this->upsertPermission($permName, $buttonLabel, "$buttonLabel permission for {$menuDisplay}", $created, $updated, $skipped);
            }
        }

        $this->command->info("\n✅ Menu and button permissions seeded. Created: {$created}, Updated: {$updated}, Skipped: {$skipped}\n");

        // Assign all permissions for menus to Partner role by default
        $this->assignAllMenuPermissionsToPartner();
    }
    
    /**
     * Assign all menu permissions to Partner role
     */
    protected function assignAllMenuPermissionsToPartner(): void
    {
        try {
            $partnerRole = DB::table('ac_roles')->where('name', 'partner')->first();
            
            if (!$partnerRole) {
                $this->command->warn("⚠ Partner role not found. Skipping permission assignment.");
                return;
            }
            
            // All permissions related to menus and their buttons
            $permissions = DB::table('ac_modules')
                ->where(function($q){
                    $q->where('module_name', 'LIKE', 'menu-%')
                      ->orWhereRaw("LOCATE('-', module_name) > 0");
                })
                ->get();
            
            $assigned = 0;
            $skipped = 0;
            
            foreach ($permissions as $permission) {
                try {
                    $exists = DB::table('ac_role_permissions')
                        ->where('role_id', $partnerRole->id)
                        ->where('module_id', $permission->id)
                        ->exists();
                    
                    if (!$exists) {
                        DB::table('ac_role_permissions')->insert([
                            'role_id' => $partnerRole->id,
                            'module_id' => $permission->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        $assigned++;
                    } else {
                        $skipped++;
                    }
                } catch (\Exception $e) {
                    $this->command->warn("Error assigning {$permission->module_name}: " . $e->getMessage());
                }
            }
            
            $this->command->info("✅ Assigned {$assigned} menu-related permissions to Partner role (skipped {$skipped} existing)");
        } catch (\Exception $e) {
            $this->command->error("Error in assignAllMenuPermissionsToPartner: " . $e->getMessage());
        }
    }
    /**
     * Upsert helper with counters
     */
    private function upsertPermission(string $name, string $displayName, ?string $description, int &$created, int &$updated, int &$skipped): void
    {
        try {
            [$module, $action, $resource] = $this->deriveMeta($name);
            $exists = DB::table('ac_modules')->where('module_name', $name)->first();
            $payload = [
                'module_name' => $name,
                'display_name' => $displayName,
                'description' => $description,
                'updated_at' => now(),
            ];
            if (Schema::hasColumn('ac_modules', 'module')) {
                $payload['module'] = $module;
            }
            if (Schema::hasColumn('ac_modules', 'action')) {
                $payload['action'] = $action;
            }
            if (Schema::hasColumn('ac_modules', 'resource')) {
                $payload['resource'] = $resource;
            }
            if (!$exists) {
                $payload['created_at'] = now();
                DB::table('ac_modules')->insert($payload);
                $this->command->info("✓ Created: {$name}");
                $created++;
            } else {
                DB::table('ac_modules')->where('id', $exists->id)->update($payload);
                $this->command->info("○ Updated: {$name}");
                $updated++;
            }
        } catch (\Exception $e) {
            $this->command->warn("✗ Error with {$name}: " . $e->getMessage());
            $skipped++;
        }
    }

    private function deriveMeta(string $name): array
    {
        if (str_starts_with($name, 'menu-')) {
            $resource = substr($name, 5) ?: 'menu';
            return ['menu', 'view', $resource];
        }
        if (strpos($name, '-') !== false) {
            [$module, $action] = explode('-', $name, 2);
            return [$module ?: 'system', $action ?: 'view', $module ?: 'system'];
        }
        return ['system', 'view', $name];
    }
}
