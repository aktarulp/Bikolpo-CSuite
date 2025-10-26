<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referrer_id');
            $table->unsignedBigInteger('referred_id');
            $table->unsignedBigInteger('referral_code_id');
            $table->string('status')->default('pending');
            $table->timestamp('referred_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->longText('metadata')->nullable();
            $table->timestamps();
            
            $table->unique(['referrer_id', 'referred_id'], 'referrals_referrer_id_referred_id_unique');
            $table->index(['referrer_id', 'status'], 'referrals_referrer_id_status_index');
            $table->index(['referred_id', 'status'], 'referrals_referred_id_status_index');
            $table->foreign('referral_code_id', 'referrals_referral_code_id_foreign')->references('id')->on('referral_codes')->onDelete('cascade');
            $table->foreign('referred_id', 'referrals_referred_id_foreign')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('referrer_id', 'referrals_referrer_id_foreign')->references('id')->on('partners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referrals');
    }
}
