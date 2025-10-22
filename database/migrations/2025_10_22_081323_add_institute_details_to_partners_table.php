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
            // Add institute detail columns
            $table->string('eiin_no')->nullable()->after('institute_name_bangla');
            $table->string('trade_license_no')->nullable()->after('eiin_no');
            $table->string('tin_no')->nullable()->after('trade_license_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            // Drop the columns
            $table->dropColumn(['eiin_no', 'trade_license_no', 'tin_no']);
        });
    }
};
