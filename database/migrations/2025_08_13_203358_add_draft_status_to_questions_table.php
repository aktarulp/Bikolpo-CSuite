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
            // Add draft_status column to track if question is a draft
            if (!Schema::hasColumn('questions', 'draft_status')) {
                $table->enum('draft_status', ['draft', 'published'])->default('published')->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            // Drop the draft_status column
            if (Schema::hasColumn('questions', 'draft_status')) {
                $table->dropColumn('draft_status');
            }
        });
    }
};
