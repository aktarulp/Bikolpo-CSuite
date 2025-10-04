<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\EnhancedUser;
use App\Models\EnhancedRole;
use App\Models\EnhancedPermission;
use Illuminate\Support\Facades\DB;

echo "=== Complete Partner Menu Fix ===\n\n";

try {
    DB::beginTransaction();

    // Step 1: Ensure partner role exists
    echo "Step 1: Checking partner role...\n";
    $partnerRole = EnhancedRole::where('name', 'partner')->first();
    if (!$partnerRole) {
        echo "❌ Partner role not found. Creating...\n";
        $partnerRole = EnhancedRole::create([
            'name' => 'partner',
            'display_name' => 'Partner',
            'description' => 'Organization Partner with full access',
            'level' => 3,
            'status' => 'active',
            'is_system' => false,
            'is_default' => false,
            'inherit_permissions' => false,
            'permissions_inheritance_mode' => 'none'
        ]);
        echo "✅ Partner role created\n";
    } else {
        echo "✅ Partner role exists: {$partnerRole->display_name}\n";
    }

    // Step 2: Create all menu permissions
    echo "\nStep 2: Creating menu permissions...\n";
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

    $createdPermissions = [];
    foreach ($menuPermissions as $name => $description) {
        $permission = EnhancedPermission::where('name', $name)->first();
        if (!$permission) {
            $permission = EnhancedPermission::create([
                'name' => $name,
                'display_name' => $description,
                'description' => $description,
                'module' => str_replace('menu-', '', $name),
                'action' => 'menu',
                'status' => 'active'
            ]);
            echo "✅ Created: {$name}\n";
        } else {
            echo "⚪ Exists: {$name}\n";
        }
        $createdPermissions[] = $permission;
    }

    // Step 3: Assign permissions to partner role
    echo "\nStep 3: Assigning permissions to partner role...\n";
    foreach ($createdPermissions as $permission) {
        // Check if already assigned
        $exists = DB::table('role_permissions')
            ->where('enhanced_role_id', $partnerRole->id)
            ->where('enhanced_permission_id', $permission->id)
            ->exists();

        if (!$exists) {
            DB::table('role_permissions')->insert([
                'enhanced_role_id' => $partnerRole->id,
                'enhanced_permission_id' => $permission->id,
                'granted_by' => 1,
                'granted_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            echo "✅ Assigned: {$permission->name}\n";
        } else {
            echo "⚪ Already assigned: {$permission->name}\n";
        }
    }

    // Step 4: Fix user-role assignment
    echo "\nStep 4: Fixing user-role assignments...\n";
    $partnerUsers = EnhancedUser::where('role', 'partner')->get();
    
    foreach ($partnerUsers as $user) {
        echo "Processing user: {$user->name}\n";
        
        // Update role_id field
        if ($user->role_id != $partnerRole->id) {
            $user->update(['role_id' => $partnerRole->id]);
            echo "  ✅ Updated role_id\n";
        }

        // Check user_roles pivot table
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
            echo "  ✅ Added to user_roles pivot\n";
        } else {
            echo "  ⚪ Already in user_roles pivot\n";
        }
    }

    DB::commit();
    echo "\n🎉 All fixes applied successfully!\n";

    // Step 5: Final verification
    echo "\n=== Final Verification ===\n";
    $testUser = EnhancedUser::where('role', 'partner')->first();
    if ($testUser) {
        echo "Testing user: {$testUser->name}\n";
        
        // Test a few permissions
        $testPermissions = ['menu-dashboard', 'menu-courses', 'menu-students'];
        $passedTests = 0;
        
        foreach ($testPermissions as $perm) {
            $canAccess = $testUser->hasPermission($perm);
            $status = $canAccess ? '✅' : '❌';
            echo "{$status} {$perm}\n";
            if ($canAccess) $passedTests++;
        }
        
        if ($passedTests === count($testPermissions)) {
            echo "\n🎉 SUCCESS! Partner users can now access menu items!\n";
            echo "The 'not all menu shown on partner role' issue has been resolved.\n";
        } else {
            echo "\n⚠️  Some permissions still not working. Check the permission system configuration.\n";
        }
    }

} catch (Exception $e) {
    DB::rollback();
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
