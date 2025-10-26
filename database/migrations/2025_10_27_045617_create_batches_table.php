<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->integer('year');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('created_by')->nullable()->index('batches_created_by_foreign');
            $table->timestamps();
            
            $table->unique(['partner_id', 'course_id', 'name', 'year'], 'batches_partner_id_course_id_name_year_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('batches');
    }
}
