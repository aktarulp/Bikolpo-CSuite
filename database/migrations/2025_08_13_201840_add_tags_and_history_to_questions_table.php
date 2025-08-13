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
            // Add tags column to store question tags as JSON
            if (!Schema::hasColumn('questions', 'tags')) {
                $table->json('tags')->nullable()->after('status');
            }
            
            // Add appearance_history column to store question appearance history as JSON
            if (!Schema::hasColumn('questions', 'appearance_history')) {
                $table->json('appearance_history')->nullable()->after('tags');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            // Drop the columns in reverse order
            if (Schema::hasColumn('questions', 'appearance_history')) {
                $table->dropColumn('appearance_history');
            }
            if (Schema::hasColumn('questions', 'tags')) {
                $table->dropColumn('tags');
            }
        });
    }
};
