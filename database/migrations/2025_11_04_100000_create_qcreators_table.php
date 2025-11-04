<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQcreatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qcreators', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('designation')->nullable();
            $table->string('organization')->nullable();
            $table->text('experiences')->nullable();
            $table->text('remarks')->nullable();
            $table->string('photo')->nullable();
            $table->string('email')->unique('teachers_email_unique');
            $table->string('phone')->unique('teachers_phone_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qcreators');
    }
}