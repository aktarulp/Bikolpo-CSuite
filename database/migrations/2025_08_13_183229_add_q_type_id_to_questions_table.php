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
        Schema::table('questions', function (Blueprint $table) {
            // Add q_type_id column if it doesn't exist
            if (!Schema::hasColumn('questions', 'q_type_id')) {
                $table->unsignedBigInteger('q_type_id')->nullable()->after('question_type');
                
                // Add foreign key constraint
                $table->foreign('q_type_id')
                      ->references('q_type_id')
                      ->on('question_types')
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
        Schema::table('questions', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['q_type_id']);
            
            // Drop the column
            $table->dropColumn('q_type_id');
        });
    }
};
