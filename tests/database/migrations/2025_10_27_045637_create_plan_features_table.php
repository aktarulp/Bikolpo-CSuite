<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_features', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique('plan_features_slug_unique');
            $table->text('description')->nullable();
            $table->string('category')->default('general');
            $table->enum('feature_for', ['partner', 'student', 'both'])->default('both');
            $table->string('type')->default('boolean');
            $table->longText('options')->nullable();
            $table->string('unit')->nullable();
            $table->boolean('is_active')->default(1);
            $table->integer('sort_order')->default(0)->index('plan_features_sort_order_index');
            $table->timestamps();
            
            $table->index(['category', 'is_active'], 'plan_features_category_is_active_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_features');
    }
}
