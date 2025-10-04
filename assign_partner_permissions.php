<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Assigning All Permissions to Partner Role ===\n\n";

try {
    // Get partner role ID
    $partnerRole = DB::table('roles')->where('name', 'partner')->first();
    
    if (!$partnerRole) {
        echo "❌ Partner role not found in database\n";
        echo "Creating partner role...\n";
        
        $roleId = DB::table('roles')->insertGetId([
            'name' => 'partner',
            'display_name' => 'Partner',
            'description' => 'Organization Partner',
            'level' => 3,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        echo "✅ Partner role created with ID: {$roleId}\n";
        $partnerRole = DB::table('roles')->find($roleId);
    } else {
        echo "✅ Partner role found: {$partnerRole->display_name} (ID: {$partnerRole->id})\n";
    }

    // Create menu permissions if they don't exist
    echo "\n=== Creating Menu Permissions ===\n";
    
    $menuPermissions = [
        'menu-dashboard' => 'Access Dashboard Menu',
        'menu-courses' => 'Access Courses Menu',
        'menu-subjects' => 'Access Subjects Menu',
        'menu-topics' => 'Access Topics Menu',
        'menu-batches' => 'Access Batches Menu',
        'menu-students' => 'Access Students Menu',
        'menu-teachers' => 'Access Teachers Menu',
        'menu-questions' => 'Access Questions Menu',
        'menu-exams' => 'Access Exams Menu',
        'menu-analytics' => 'Access Analytics Menu',
        'menu-sms' => 'Access SMS Menu',
        'menu-settings' => 'Access Settings Menu'
    ];

    $permissionIds = [];
    
    foreach ($menuPermissions as $name => $description) {
        $permission = DB::table('permissions')->where('name', $name)->first();
        
        if (!$permission) {
            $permId = DB::table('permissions')->insertGetId([
                'name' => $name,
                'display_name' => $description,
                'description' => $description,
                'module' => str_replace('menu-', '', $name),
                'action' => 'menu',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            echo "✅ Created: {$name} (ID: {$permId})\n";
            $permissionIds[$name] = $permId;
        } else {
            echo "⚪ Exists: {$name} (ID: {$permission->id})\n";
            $permissionIds[$name] = $permission->id;
        }
    }

    // Assign permissions to partner role
    echo "\n=== Assigning Permissions to Partner Role ===\n";
    
    $assignedCount = 0;
    foreach ($permissionIds as $name => $permId) {
        // Check if already assigned
        $exists = DB::table('role_permissions')
            ->where('enhanced_role_id', $partnerRole->id)
            ->where('enhanced_permission_id', $permId)
            ->exists();

        if (!$exists) {
            DB::table('role_permissions')->insert([
                'enhanced_role_id' => $partnerRole->id,
                'enhanced_permission_id' => $permId,
                'granted_by' => 1,
                'granted_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            echo "✅ Assigned: {$name}\n";
            $assignedCount++;
        } else {
            echo "⚪ Already assigned: {$name}\n";
        }
    }

    // Assign partner role to partner users
    echo "\n=== Assigning Partner Role to Users ===\n";
    
    $partnerUsers = DB::table('users')->where('role', 'partner')->get();
    
    foreach ($partnerUsers as $user) {
        echo "Processing user: {$user->name} (ID: {$user->id})\n";
        
        // Update role_id
        DB::table('users')->where('id', $user->id)->update([
            'role_id' => $partnerRole->id
        ]);
        
        // Add to user_roles pivot
        $pivotExists = DB::table('user_roles')
            ->where('user_id', $user->id)
            ->where('role_id', $partnerRole->id)
            ->exists();

        if (!$pivotExists) {
            DB::table('user_roles')->insert([
                'user_id' => $user->id,
                'role_id' => $partnerRole->id,
                'assigned_by' => 1,
                'assigned_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            echo "  ✅ Added to user_roles\n";
        } else {
            echo "  ⚪ Already in user_roles\n";
        }
    }

    echo "\n🎉 SUCCESS!\n";
    echo "- Created/verified {count($menuPermissions)} menu permissions\n";
    echo "- Assigned {$assignedCount} new permissions to partner role\n";
    echo "- Updated " . count($partnerUsers) . " partner user(s)\n";
    echo "\n✅ Partner users should now see all menu items!\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
