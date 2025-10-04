<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "USER_ROLES TABLE STRUCTURE\n";
echo "==========================\n\n";

$cols = DB::select('SHOW COLUMNS FROM user_roles');
echo "Columns:\n";
foreach ($cols as $col) {
    echo "- {$col->Field} ({$col->Type}) " . ($col->Null === 'NO' ? 'NOT NULL' : 'NULL') . "\n";
}

echo "\nSample insert test:\n";
try {
    // Test what columns we can actually insert
    DB::table('user_roles')->insert([
        'user_id' => 999,
        'role_id' => 2,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    echo "✓ Test insert successful with role_id\n";
    DB::table('user_roles')->where('user_id', 999)->delete();
} catch (\Exception $e) {
    echo "❌ Test with role_id failed: " . $e->getMessage() . "\n";
}

try {
    DB::table('user_roles')->insert([
        'user_id' => 999,
        'enhanced_role_id' => 2,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    echo "✓ Test insert successful with enhanced_role_id\n";
    DB::table('user_roles')->where('user_id', 999)->delete();
} catch (\Exception $e) {
    echo "❌ Test with enhanced_role_id failed: " . $e->getMessage() . "\n";
}
