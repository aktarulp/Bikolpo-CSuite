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
            // Add upazila column
            $table->unsignedBigInteger('upazila')->nullable()->after('district');
            
            // Add foreign key constraint
            $table->foreign('upazila')->references('id')->on('upazilas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['upazila']);
            // Drop the column
            $table->dropColumn('upazila');
        });
    }
};
