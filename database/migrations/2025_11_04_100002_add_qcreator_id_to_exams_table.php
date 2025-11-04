<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQcreatorIdToExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exams', function (Blueprint $table) {
            // Add qcreator_id column as foreign key to qcreators table
            $table->unsignedBigInteger('qcreator_id')->nullable()->after('partner_id');
            $table->foreign('qcreator_id')->references('id')->on('qcreators')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropForeign(['qcreator_id']);
            $table->dropColumn('qcreator_id');
        });
    }
}