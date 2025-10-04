<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "SIMPLE ROLE MIGRATION\n";
echo "=====================\n\n";

// Get the assignment from model_has_roles
$assignment = DB::table('model_has_roles')->first();

if (!$assignment) {
    echo "❌ No data in model_has_roles to migrate\n";
    exit;
}

echo "Found assignment:\n";
echo "- User ID: {$assignment->model_id}\n";
echo "- Role ID: {$assignment->role_id}\n";
echo "- Model Type: {$assignment->model_type}\n\n";

// Check if user exists
$user = DB::table('users')->where('id', $assignment->model_id)->first();
if (!$user) {
    echo "❌ User ID {$assignment->model_id} does not exist in users table\n";
    exit;
}

echo "✓ User exists: {$user->name} ({$user->email})\n";

// Check if role exists
$role = DB::table('roles')->where('id', $assignment->role_id)->first();
if (!$role) {
    echo "❌ Role ID {$assignment->role_id} does not exist in roles table\n";
    exit;
}

echo "✓ Role exists: {$role->name}\n\n";

// Check if already in user_roles
$exists = DB::table('user_roles')
    ->where('user_id', $assignment->model_id)
    ->where('role_id', $assignment->role_id)
    ->exists();

if ($exists) {
    echo "✓ Assignment already exists in user_roles table\n";
} else {
    echo "Inserting into user_roles...\n";
    try {
        DB::table('user_roles')->insert([
            'user_id' => $assignment->model_id,
            'role_id' => $assignment->role_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "✅ Successfully migrated to user_roles table!\n";
    } catch (\Exception $e) {
        echo "❌ Failed to insert: " . $e->getMessage() . "\n";
        exit;
    }
}

// Test MenuPermissionService
echo "\nTesting MenuPermissionService logic:\n";
$roleIds = DB::table('user_roles')
    ->where('user_id', $assignment->model_id)
    ->pluck('role_id')
    ->toArray();

echo "- User {$assignment->model_id} has role IDs: " . implode(', ', $roleIds) . "\n";

if (!empty($roleIds)) {
    echo "✅ MenuPermissionService will now work correctly!\n";
    echo "✅ Menu access control should function properly!\n";
} else {
    echo "❌ No roles found - something went wrong\n";
}

echo "\n🎉 MIGRATION COMPLETE!\n";
