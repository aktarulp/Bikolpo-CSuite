<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "PERMISSIONS TABLE STRUCTURE:\n";
$cols = DB::select('SHOW COLUMNS FROM permissions');
foreach($cols as $c) {
    echo "- {$c->Field} ({$c->Type})\n";
}

echo "\nSPATIE_PERMISSIONS TABLE STRUCTURE:\n";
$cols2 = DB::select('SHOW COLUMNS FROM spatie_permissions');
foreach($cols2 as $c) {
    echo "- {$c->Field} ({$c->Type})\n";
}
