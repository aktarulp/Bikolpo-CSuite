<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTeacherIdToAcUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ac_users', function (Blueprint $table) {
            $table->unsignedBigInteger('teacher_id')->nullable()->after('student_id');
            $table->foreign('teacher_id', 'ac_users_teacher_id_foreign')->references('id')->on('teachers')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ac_users', function (Blueprint $table) {
            $table->dropForeign('ac_users_teacher_id_foreign');
            $table->dropColumn('teacher_id');
        });
    }
}