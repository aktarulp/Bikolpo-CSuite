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
        // Update sort_order to make 'users' category appear first
        DB::table('plan_features')->where('category', 'users')->update(['sort_order' => DB::raw('sort_order - 9')]);
        
        // Update other categories to maintain proper order
        DB::table('plan_features')->where('category', 'dashboard')->update(['sort_order' => DB::raw('sort_order + 3')]);
        DB::table('plan_features')->where('category', 'analytics')->update(['sort_order' => DB::raw('sort_order + 3')]);
        DB::table('plan_features')->where('category', 'communication')->update(['sort_order' => DB::raw('sort_order + 3')]);
        DB::table('plan_features')->where('category', 'storage')->update(['sort_order' => DB::raw('sort_order + 3')]);
        DB::table('plan_features')->where('category', 'api')->update(['sort_order' => DB::raw('sort_order + 3')]);
        DB::table('plan_features')->where('category', 'support')->update(['sort_order' => DB::raw('sort_order + 3')]);
        DB::table('plan_features')->where('category', 'security')->update(['sort_order' => DB::raw('sort_order + 3')]);
        DB::table('plan_features')->where('category', 'customization')->update(['sort_order' => DB::raw('sort_order + 3')]);
        DB::table('plan_features')->where('category', 'general')->update(['sort_order' => DB::raw('sort_order + 3')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the changes
        DB::table('plan_features')->where('category', 'users')->update(['sort_order' => DB::raw('sort_order + 9')]);
        
        DB::table('plan_features')->where('category', 'dashboard')->update(['sort_order' => DB::raw('sort_order - 3')]);
        DB::table('plan_features')->where('category', 'analytics')->update(['sort_order' => DB::raw('sort_order - 3')]);
        DB::table('plan_features')->where('category', 'communication')->update(['sort_order' => DB::raw('sort_order - 3')]);
        DB::table('plan_features')->where('category', 'storage')->update(['sort_order' => DB::raw('sort_order - 3')]);
        DB::table('plan_features')->where('category', 'api')->update(['sort_order' => DB::raw('sort_order - 3')]);
        DB::table('plan_features')->where('category', 'support')->update(['sort_order' => DB::raw('sort_order - 3')]);
        DB::table('plan_features')->where('category', 'security')->update(['sort_order' => DB::raw('sort_order - 3')]);
        DB::table('plan_features')->where('category', 'customization')->update(['sort_order' => DB::raw('sort_order - 3')]);
        DB::table('plan_features')->where('category', 'general')->update(['sort_order' => DB::raw('sort_order - 3')]);
    }
};
