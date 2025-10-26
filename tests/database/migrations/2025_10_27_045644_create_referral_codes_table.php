<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referrer_id');
            $table->string('code')->unique('referral_codes_code_unique');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(1);
            $table->integer('max_uses')->nullable();
            $table->integer('used_count')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            
            $table->index(['code', 'is_active'], 'referral_codes_code_is_active_index');
            $table->foreign('referrer_id', 'referral_codes_referrer_id_foreign')->references('id')->on('partners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referral_codes');
    }
}
