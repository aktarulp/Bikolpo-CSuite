<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    DB::connection('testing')->table('ac_roles')->get()->each(function ($role) {
        echo "ID: {$role->id}, Name: {$role->name}\n";
    });
    echo "\nSuccessfully dumped ac_roles table from testing database.\n";
} catch (\Exception $e) {
    echo "Error dumping ac_roles table: " . $e->getMessage() . "\n";
}