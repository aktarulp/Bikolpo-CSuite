<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_rewards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referral_id');
            $table->unsignedBigInteger('referrer_id');
            $table->string('reward_type')->default('subscription_credit');
            $table->decimal('reward_value', 10, 2);
            $table->string('reward_unit')->default('months');
            $table->string('status')->default('pending');
            $table->timestamp('applied_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['referrer_id', 'status'], 'referral_rewards_referrer_id_status_index');
            $table->foreign('referral_id', 'referral_rewards_referral_id_foreign')->references('id')->on('referrals')->onDelete('cascade');
            $table->foreign('referrer_id', 'referral_rewards_referrer_id_foreign')->references('id')->on('partners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referral_rewards');
    }
}
