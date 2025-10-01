<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UpdateUserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the Partner Admin role
        $partnerAdminRole = Role::where('name', 'partner_admin')->first();
        
        if (!$partnerAdminRole) {
            $this->command->error('Partner Admin role not found. Please run RoleSeeder first.');
            return;
        }

        // Update all existing users to have the Partner Admin role
        // This assumes all current users are partners as mentioned in requirements
        $users = User::all();
        
        foreach ($users as $user) {
            // Only update if user doesn't have a role_id or if we want to reset all users
            if (!$user->role_id || $user->role === 'partner') {
                $user->role_id = $partnerAdminRole->id;
                $user->save();
                
                $this->command->info("Updated user {$user->email} to Partner Admin role");
            }
        }

        $this->command->info('All existing users have been updated to Partner Admin role!');
    }
}
