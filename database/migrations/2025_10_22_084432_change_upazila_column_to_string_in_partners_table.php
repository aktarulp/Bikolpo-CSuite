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
            // Drop the foreign key constraint first
            $table->dropForeign(['upazila']);
            // Change the column type from integer to string
            $table->string('upazila')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            // Change back to integer and add foreign key
            $table->unsignedBigInteger('upazila')->nullable()->change();
            $table->foreign('upazila')->references('id')->on('upazilas')->onDelete('set null');
        });
    }
};
