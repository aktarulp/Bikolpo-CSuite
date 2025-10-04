<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "TABLE STRUCTURES\n";
echo "================\n\n";

echo "role_permissions table:\n";
$cols = DB::select('SHOW COLUMNS FROM role_permissions');
foreach ($cols as $c) {
    echo "  - {$c->Field} ({$c->Type})\n";
}

echo "\nSample data:\n";
$sample = DB::table('role_permissions')->first();
if ($sample) {
    print_r($sample);
} else {
    echo "  No data\n";
}
