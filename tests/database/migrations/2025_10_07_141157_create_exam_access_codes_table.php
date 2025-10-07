<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamAccessCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_access_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('student_id')->index('exam_access_codes_student_id_foreign');
            $table->string('access_code', 6)->unique('exam_access_codes_access_code_unique');
            $table->enum('status', ['active', 'used', 'expired'])->default('active');
            $table->string('sms_status')->default('pending');
            $table->timestamp('used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            
            $table->unique(['exam_id', 'student_id'], 'exam_access_codes_exam_id_student_id_unique');
            $table->index(['access_code', 'status'], 'exam_access_codes_access_code_status_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_access_codes');
    }
}
