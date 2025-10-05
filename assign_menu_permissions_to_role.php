<?php

require_once __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

$roleId = isset($argv[1]) ? (int)$argv[1] : 0;
$permissions = array_slice($argv, 2);

if (!$roleId || empty($permissions)) {
    fwrite(STDERR, "Usage: php assign_menu_permissions_to_role.php <role_id> <permission1> <permission2> ...\n");
    exit(1);
}

$createdPerms = 0;
$assigned = 0;
$skippedAssign = 0;
$errors = 0;

echo "Assigning permissions to role_id={$roleId}\n";

echo "Processing permissions: ".implode(', ', $permissions)."\n\n";

foreach ($permissions as $name) {
    try {
        // Ensure permission exists in ac_permissions
        $perm = DB::table('ac_permissions')->where('name', $name)->first();
        if (!$perm) {
            $display = Str::title(str_replace(['menu-', '-'], ['',' '], $name));
            $permId = DB::table('ac_permissions')->insertGetId([
                'name' => $name,
                'display_name' => $display ?: $name,
                'description' => "Auto-created permission for {$name}",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $createdPerms++;
            echo "✓ Created permission: {$name} (ID: {$permId})\n";
        } else {
            $permId = $perm->id;
            echo "• Permission exists: {$name} (ID: {$permId})\n";
        }

        // Assign to role in ac_role_permissions if not already
        $exists = DB::table('ac_role_permissions')
            ->where('enhanced_role_id', $roleId)
            ->where('enhanced_permission_id', $permId)
            ->exists();

        if (!$exists) {
            DB::table('ac_role_permissions')->insert([
                'enhanced_role_id' => $roleId,
                'enhanced_permission_id' => $permId,
                'granted_by' => auth()->id() ?? null,
                'granted_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $assigned++;
            echo "  → Assigned to role {$roleId}: {$name}\n";
        } else {
            $skippedAssign++;
            echo "  → Already assigned to role {$roleId}: {$name}\n";
        }
    } catch (Throwable $e) {
        $errors++;
        fwrite(STDERR, "Error processing {$name}: ".$e->getMessage()."\n");
    }
}

echo "\nSummary:\n";
echo "  Created new permissions: {$createdPerms}\n";
echo "  Newly assigned to role: {$assigned}\n";
echo "  Already assigned: {$skippedAssign}\n";
echo "  Errors: {$errors}\n";
