<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Populate role_id for existing users based on their role name
        $users = DB::table('users')->whereNotNull('role')->get();
        
        foreach ($users as $user) {
            // Find the role by name
            $role = DB::table('roles')->where('name', $user->role)->first();
            
            if ($role) {
                // Update the user with the role_id
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['role_id' => $role->id]);
            } else {
                // If role not found, try to find a default role or create one
                $defaultRole = DB::table('roles')->where('name', 'user')->first();
                if (!$defaultRole) {
                    // Create a default user role if it doesn't exist
                    $defaultRoleId = DB::table('roles')->insertGetId([
                        'name' => 'user',
                        'display_name' => 'User',
                        'description' => 'Default user role',
                        'level' => 6,
                        'status' => 'active',
                        'is_system' => true,
                        'is_default' => true,
                        'inherit_permissions' => false,
                        'permissions_inheritance_mode' => 'none',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $defaultRole = (object)['id' => $defaultRoleId];
                }
                
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['role_id' => $defaultRole->id]);
            }
        }
        
        // For users without a role name, assign default role
        $usersWithoutRole = DB::table('users')->whereNull('role')->get();
        if ($usersWithoutRole->count() > 0) {
            $defaultRole = DB::table('roles')->where('name', 'user')->first();
            if ($defaultRole) {
                DB::table('users')
                    ->whereNull('role')
                    ->update(['role_id' => $defaultRole->id, 'role' => 'user']);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Set role_id back to null for all users
        DB::table('users')->update(['role_id' => null]);
    }
};
