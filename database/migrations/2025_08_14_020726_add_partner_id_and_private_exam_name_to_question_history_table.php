<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('question_history', function (Blueprint $table) {
            // Add partner_id column after question_id
            $table->foreignId('partner_id')->after('question_id')->nullable();
            
            // Add private_exam_name column after public_exam_name
            $table->string('private_exam_name')->nullable()->after('public_exam_name');
        });

        // Populate partner_id for existing records
        // Get the first partner ID or use a default value
        $defaultPartnerId = DB::table('partners')->first()->id ?? 1;
        
        // Update existing records to have a partner_id
        DB::table('question_history')->update(['partner_id' => $defaultPartnerId]);
        
        // Make partner_id not nullable and add foreign key constraint
        Schema::table('question_history', function (Blueprint $table) {
            $table->foreignId('partner_id')->nullable(false)->change();
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
            
            // Add index for better performance
            $table->index(['partner_id', 'exam_year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('question_history', function (Blueprint $table) {
            // Drop the index first
            $table->dropIndex(['partner_id', 'exam_year']);
            
            // Drop the foreign key constraint
            $table->dropForeign(['partner_id']);
            
            // Drop the columns
            $table->dropColumn(['partner_id', 'private_exam_name']);
        });
    }
};
