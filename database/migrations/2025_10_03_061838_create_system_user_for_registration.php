<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create a system user for registration processes
        $systemRole = DB::table('roles')->where('name', 'System')->first();
        if (!$systemRole) {
            // Create system role if it doesn't exist
            $systemRoleId = DB::table('roles')->insertGetId([
                'name' => 'System',
                'display_name' => 'System User',
                'description' => 'System user for automated processes',
                'level' => 0, // Highest level
                'status' => 'active',
                'is_system' => true,
                'is_default' => false,
                'inherit_permissions' => false,
                'permissions_inheritance_mode' => 'none',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $systemRoleId = $systemRole->id;
        }

        // Check if system user already exists
        $existingSystemUser = DB::table('users')->where('email', 'system@bikolpo.com')->first();
        
        if (!$existingSystemUser) {
            // Create system user
            DB::table('users')->insert([
                'name' => 'Web Registration System',
                'email' => 'system@bikolpo.com',
                'password' => Hash::make('system_password_' . time()),
                'role' => 'System',
                'role_id' => $systemRoleId,
                'status' => 'active',
                'partner_id' => null,
                'email_verified_at' => now(),
                'created_by' => null, // Bootstrap user
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove system user
        DB::table('users')->where('email', 'system@bikolpo.com')->delete();
        
        // Remove system role if it was created by this migration
        DB::table('roles')->where('name', 'System')->where('is_system', true)->delete();
    }
};
