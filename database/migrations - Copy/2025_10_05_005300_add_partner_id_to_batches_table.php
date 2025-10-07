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
        Schema::table('batches', function (Blueprint $table) {
            // Check if column doesn't exist before adding
            if (!Schema::hasColumn('batches', 'partner_id')) {
                $table->unsignedBigInteger('partner_id')->nullable()->after('id');
                
                // Add foreign key constraint
                $table->foreign('partner_id')
                      ->references('id')
                      ->on('partners')
                      ->onDelete('set null')
                      ->onUpdate('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            // Drop foreign key first to avoid constraint errors
            if (Schema::hasColumn('batches', 'partner_id')) {
                $table->dropForeign(['partner_id']);
                $table->dropColumn('partner_id');
            }
        });
    }
};
