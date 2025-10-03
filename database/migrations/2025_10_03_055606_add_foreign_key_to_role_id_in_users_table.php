<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if foreign key constraint already exists before adding
            if (!Schema::hasColumn('users', 'role_id')) {
                return;
            }
            
            // Check if foreign key constraint already exists
            $foreignKeys = Schema::getConnection()
                ->getDoctrineSchemaManager()
                ->listTableForeignKeys('users');
            
            $constraintExists = false;
            foreach ($foreignKeys as $foreignKey) {
                if (in_array('role_id', $foreignKey->getColumns())) {
                    $constraintExists = true;
                    break;
                }
            }
            
            if (!$constraintExists) {
                $table->foreign('role_id')->references('id')->on('roles')->onDelete('restrict');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['role_id']);
        });
    }
};
