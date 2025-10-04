<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "SYNCING USER ROLES FROM role_id TO ac_user_roles PIVOT TABLE\n";
echo "============================================================\n\n";

// Find users with role_id but no corresponding ac_user_roles record
$usersWithMissingPivot = DB::table('ac_users')
    ->whereNotNull('role_id')
    ->whereNotExists(function ($query) {
        $query->select(DB::raw(1))
              ->from('ac_user_roles')
              ->whereRaw('ac_user_roles.user_id = ac_users.id')
              ->whereRaw('ac_user_roles.role_id = ac_users.role_id');
    })
    ->get();

echo "Found " . $usersWithMissingPivot->count() . " users with role_id but missing pivot records\n\n";

if ($usersWithMissingPivot->count() === 0) {
    echo "✅ All users are properly synced!\n";
    exit(0);
}

foreach ($usersWithMissingPivot as $user) {
    echo "User: {$user->name} ({$user->email}) - Role ID: {$user->role_id}\n";
    
    // Check if role exists
    $role = DB::table('ac_roles')->where('id', $user->role_id)->first();
    if (!$role) {
        echo "  ❌ Role ID {$user->role_id} does not exist in ac_roles table - skipping\n";
        continue;
    }
    
    echo "  ➡️  Role: {$role->name} ({$role->display_name})\n";
    
    // Create pivot record
    try {
        DB::table('ac_user_roles')->insert([
            'user_id' => $user->id,
            'role_id' => $user->role_id,
            'assigned_by' => $user->id, // Self-assigned
            'assigned_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "  ✅ Pivot record created\n";
    } catch (\Exception $e) {
        echo "  ❌ Error creating pivot record: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
}

echo "✅ Sync complete!\n";
echo "\nVerification:\n";

// Verify the sync worked
$stillMissing = DB::table('ac_users')
    ->whereNotNull('role_id')
    ->whereNotExists(function ($query) {
        $query->select(DB::raw(1))
              ->from('ac_user_roles')
              ->whereRaw('ac_user_roles.user_id = ac_users.id')
              ->whereRaw('ac_user_roles.role_id = ac_users.role_id');
    })
    ->count();

if ($stillMissing === 0) {
    echo "✅ All users now have proper pivot records!\n";
} else {
    echo "⚠️  Still {$stillMissing} users missing pivot records\n";
}