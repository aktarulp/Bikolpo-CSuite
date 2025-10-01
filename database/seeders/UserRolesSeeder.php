<?php

namespace Database\Seeders;

use App\Models\EnhancedRole;
use App\Models\EnhancedUser;
use Illuminate\Database\Seeder;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding user roles pivot table...');

        // Get all users and their current role_id
        $users = \App\Models\User::all();
        
        foreach ($users as $user) {
            if ($user->role_id) {
                // Find the corresponding enhanced role
                $enhancedRole = EnhancedRole::find($user->role_id);
                
                if ($enhancedRole) {
                    // Create the pivot relationship
                    $user->roles()->attach($enhancedRole->id, [
                        'assigned_by' => 1, // Assuming user ID 1 is the system admin
                        'assigned_at' => now()
                    ]);
                    
                    $this->command->info("Assigned role {$enhancedRole->name} to user {$user->email}");
                }
            }
        }

        $this->command->info('User roles pivot table seeded successfully!');
    }
}
