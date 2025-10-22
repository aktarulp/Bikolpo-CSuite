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
        Schema::table('partners', function (Blueprint $table) {
            // Add owner_director_name column
            $table->string('owner_director_name')->nullable()->after('institute_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            // Remove owner_director_name column
            $table->dropColumn('owner_director_name');
        });
    }
};
