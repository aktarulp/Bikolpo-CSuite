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
        // Update the value field to be more flexible for numeric values
        Schema::table('subscription_plan_features', function (Blueprint $table) {
            $table->string('value')->nullable()->change();
            $table->string('limit_value')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the changes
        Schema::table('subscription_plan_features', function (Blueprint $table) {
            $table->string('value')->nullable()->change();
            $table->string('limit_value')->nullable()->change();
        });
    }
};
