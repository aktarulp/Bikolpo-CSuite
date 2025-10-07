<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_id');
            $table->string('name');
            $table->string('code');
            $table->text('description')->nullable();
            $table->integer('chapter_number')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            
            $table->unique(['partner_id', 'code'], 'topics_partner_id_code_unique');
            $table->foreign('created_by', 'topics_created_by_foreign')->references('id')->on('users')->onDelete('set NULL');
            $table->foreign('partner_id', 'topics_partner_id_foreign')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('subject_id', 'topics_subject_id_foreign')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topics');
    }
}
