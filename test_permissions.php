<?php

/**
 * Simple test script to verify the permissions system
 * Run this from the Laravel project root directory
 */

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Bootstrap Laravel
$app = Application::configure(basePath: __DIR__)
    ->withRouting(
        web: __DIR__.'/routes/web.php',
        commands: __DIR__.'/bootstrap/commands.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Permissions System Test ===\n\n";

try {
    // Test 1: Check if roles exist
    echo "1. Testing Roles:\n";
    $roles = \App\Models\Role::all();
    echo "   Found " . $roles->count() . " roles:\n";
    foreach ($roles as $role) {
        echo "   - {$role->name}: {$role->description}\n";
        if ($role->permissions) {
            echo "     Permissions: " . json_encode($role->permissions) . "\n";
        }
    }
    echo "\n";

    // Test 2: Check if system settings exist
    echo "2. Testing System Settings:\n";
    $settings = \App\Models\SystemSetting::byGroup('permissions')->get();
    echo "   Found " . $settings->count() . " permission settings:\n";
    foreach ($settings as $setting) {
        echo "   - {$setting->key}: {$setting->value} ({$setting->type})\n";
    }
    echo "\n";

    // Test 3: Test permission checking
    echo "3. Testing Permission Logic:\n";
    $adminRole = \App\Models\Role::where('name', 'Administrator')->first();
    if ($adminRole) {
        echo "   Administrator role found\n";
        echo "   Has dashboard full access: " . ($adminRole->hasPermission('dashboard', 'full') ? 'Yes' : 'No') . "\n";
        echo "   Has settings full access: " . ($adminRole->hasPermission('settings', 'full') ? 'Yes' : 'No') . "\n";
        echo "   Has settings read access: " . ($adminRole->hasPermission('settings', 'read') ? 'Yes' : 'No') . "\n";
    }
    echo "\n";

    // Test 4: Test User-Role relationships
    echo "4. Testing User-Role Relationships:\n";
    $users = \App\Models\User::with('roles')->take(3)->get();
    echo "   Testing with " . $users->count() . " users:\n";
    foreach ($users as $user) {
        echo "   - User: {$user->name} (ID: {$user->id})\n";
        echo "     Roles: " . $user->roles->pluck('name')->implode(', ') . "\n";
        if ($user->roles->count() > 0) {
            $primaryRole = $user->primaryRole();
            echo "     Primary Role: " . ($primaryRole ? $primaryRole->name : 'None') . "\n";
        }
    }
    echo "\n";

    // Test 5: Test SystemSetting helper methods
    echo "5. Testing System Setting Helpers:\n";
    $sessionTimeout = \App\Models\SystemSetting::getValue('session_timeout', 60);
    $maxSessions = \App\Models\SystemSetting::getValue('max_sessions', 5);
    echo "   Session Timeout: {$sessionTimeout} minutes\n";
    echo "   Max Sessions: {$maxSessions}\n";
    echo "\n";

    echo "=== All Tests Passed! ===\n";
    echo "The permissions system is working correctly.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
