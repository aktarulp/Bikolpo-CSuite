<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;

echo "=== Current User Permissions Check ===\n";

// Get all users with partner role
$partnerUsers = User::where('role', 'partner')->get();

if ($partnerUsers->isEmpty()) {
    echo "❌ No users with 'partner' role found\n";
    
    // Check for any users
    $allUsers = User::all();
    echo "Total users in database: " . $allUsers->count() . "\n";
    
    foreach ($allUsers as $user) {
        echo "User ID: {$user->id}, Email: {$user->email}, Role: {$user->role}\n";
    }
} else {
    echo "Found " . $partnerUsers->count() . " partner users\n";
    
    foreach ($partnerUsers as $user) {
        echo "\n--- User: {$user->email} ---\n";
        echo "Role: {$user->role}\n";
        
        // Check if user has roles relationship
        if (method_exists($user, 'roles')) {
            $roles = $user->roles;
            echo "Roles count: " . $roles->count() . "\n";
            
            foreach ($roles as $role) {
                echo "  - Role: {$role->name}\n";
                
                // Check if role has permissions
                if (method_exists($role, 'hasPermission')) {
                    $hasCoursesView = $role->hasPermission('courses-view');
                    echo "  - Has 'courses-view' permission: " . ($hasCoursesView ? 'YES' : 'NO') . "\n";
                }
            }
        } else {
            echo "User does not have roles relationship\n";
        }
    }
}

// Check if courses-view permission exists
echo "\n=== Checking 'courses-view' permission ===\n";

try {
    // Try to find the permission in different possible tables
    $tables = ['permissions', 'ac_modules', 'ac_permissions'];
    
    foreach ($tables as $table) {
        try {
            $result = \DB::table($table)->where('name', 'courses-view')->orWhere('module_name', 'courses-view')->first();
            if ($result) {
                echo "Found 'courses-view' in table '$table': " . json_encode($result) . "\n";
            } else {
                echo "Not found in table '$table'\n";
            }
        } catch (Exception $e) {
            echo "Table '$table' doesn't exist or error: " . $e->getMessage() . "\n";
        }
    }
} catch (Exception $e) {
    echo "Error checking permissions: " . $e->getMessage() . "\n";
}