<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "=== Partner Role Permissions Check ===\n";

$partnerRole = Role::where('name', 'Partner')->first();
if ($partnerRole) {
    echo "Partner role found with " . $partnerRole->permissions->count() . " permissions\n";
    
    if ($partnerRole->permissions->count() == 0) {
        echo "❌ Partner role has no permissions! Fixing...\n";
        
        // Get all permissions
        $allPermissions = Permission::all();
        echo "Total permissions available: " . $allPermissions->count() . "\n";
        
        // Assign all permissions to Partner role
        $partnerRole->syncPermissions($allPermissions);
        echo "✅ Assigned all permissions to Partner role\n";
        
        // Verify
        $partnerRole = $partnerRole->fresh();
        echo "Partner role now has " . $partnerRole->permissions->count() . " permissions\n";
    } else {
        echo "✅ Partner role already has permissions\n";
    }
} else {
    echo "❌ Partner role not found\n";
}

// Also check lowercase partner role
$partnerRoleLower = Role::where('name', 'partner')->first();
if ($partnerRoleLower) {
    echo "\nLowercase partner role found with " . $partnerRoleLower->permissions->count() . " permissions\n";
    
    if ($partnerRoleLower->permissions->count() == 0) {
        echo "❌ Lowercase partner role has no permissions! Fixing...\n";
        
        // Get all permissions
        $allPermissions = Permission::all();
        
        // Assign all permissions to partner role
        $partnerRoleLower->syncPermissions($allPermissions);
        echo "✅ Assigned all permissions to lowercase partner role\n";
    }
} else {
    echo "\nNo lowercase partner role found\n";
}
