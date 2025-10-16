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
        // Copy data from is_enabled to enabled column
        DB::table('subscription_plan_features')
            ->whereNotNull('is_enabled')
            ->update(['enabled' => DB::raw('is_enabled')]);
        
        // Drop the is_enabled column
        Schema::table('subscription_plan_features', function (Blueprint $table) {
            $table->dropColumn('is_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back the is_enabled column
        Schema::table('subscription_plan_features', function (Blueprint $table) {
            $table->boolean('is_enabled')->default(false)->after('plan_feature_id');
        });
        
        // Copy data back from enabled to is_enabled
        DB::table('subscription_plan_features')
            ->whereNotNull('enabled')
            ->update(['is_enabled' => DB::raw('enabled')]);
    }
};