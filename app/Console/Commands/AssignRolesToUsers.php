<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EnhancedUser;
use App\Models\EnhancedRole;

class AssignRolesToUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:assign-roles {--force : Force assignment even if user already has roles}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign roles to existing users based on their current role field';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting role assignment process...');
        
        $force = $this->option('force');
        
        // Get all users
        $users = EnhancedUser::all();
        
        if ($users->isEmpty()) {
            $this->warn('No users found in the database.');
            return;
        }
        
        $this->info("Found {$users->count()} users to process.");
        
        $processed = 0;
        $skipped = 0;
        $errors = 0;
        
        foreach ($users as $user) {
            try {
                // Skip if user already has roles and force is not enabled
                if (!$force && $user->roles->isNotEmpty()) {
                    $this->line("Skipping {$user->name} - already has roles assigned");
                    $skipped++;
                    continue;
                }
                
                // Determine role based on user's current role field
                $roleName = $this->determineRoleName($user);
                
                if (!$roleName) {
                    $this->warn("Could not determine role for user: {$user->name} (role: {$user->role})");
                    $errors++;
                    continue;
                }
                
                // Check if role exists
                $role = EnhancedRole::where('name', $roleName)->first();
                
                if (!$role) {
                    $this->error("Role '{$roleName}' not found for user: {$user->name}");
                    $errors++;
                    continue;
                }
                
                // Remove existing roles if force is enabled
                if ($force) {
                    $user->roles()->sync([]);
                }
                
                // Assign the role using custom pivot
                $user->assignRoleWithMetadata($role, auth()->id());
                
                $this->info("✓ Assigned '{$roleName}' role to {$user->name}");
                $processed++;
                
            } catch (\Exception $e) {
                $this->error("Error processing user {$user->name}: " . $e->getMessage());
                $errors++;
            }
        }
        
        $this->newLine();
        $this->info("Role assignment completed!");
        $this->table(['Status', 'Count'], [
            ['Processed', $processed],
            ['Skipped', $skipped],
            ['Errors', $errors],
            ['Total', $users->count()]
        ]);
    }
    
    /**
     * Determine the appropriate Spatie role name based on user's current role
     */
    private function determineRoleName(EnhancedUser $user): ?string
    {
        $currentRole = strtolower($user->role ?? '');
        
        // Map current roles to Spatie roles
        $roleMapping = [
            'admin' => 'Admin',
            'administrator' => 'Admin',
            'system_administrator' => 'Admin',
            'system' => 'Admin',
            'partner' => 'partner', // Partners get full organization-level access (lowercase to match database)
            'teacher' => 'Teacher',
            'instructor' => 'Teacher',
            'student' => 'Student',
            'learner' => 'Student',
            'operator' => 'Operator',
            'staff' => 'Operator',
        ];
        
        return $roleMapping[$currentRole] ?? null;
    }
}
