<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionPlanFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_plan_features', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscription_plan_id');
            $table->unsignedBigInteger('plan_feature_id');
            $table->boolean('enabled')->default(1);
            $table->string('value')->nullable();
            $table->string('limit_value')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->foreign('plan_feature_id', 'subscription_plan_features_plan_feature_id_foreign')->references('id')->on('plan_features')->onDelete('cascade');
            $table->foreign('subscription_plan_id', 'subscription_plan_features_subscription_plan_id_foreign')->references('id')->on('subscription_plans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_plan_features');
    }
}
