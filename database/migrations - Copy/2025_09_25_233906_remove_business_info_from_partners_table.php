<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn([
                'owner_name',
                'owner_director_name',
                'eiin_no',
                'trade_license_no',
                'tin_no',
                'category',
                'partner_category',
                'target_group',
                'total_teachers',
                'total_students',
                'batch_system',
                'class_range',
                'subjects_offered',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->string('owner_name')->nullable();
            $table->string('owner_director_name')->nullable();
            $table->string('eiin_no')->nullable();
            $table->string('trade_license_no')->nullable();
            $table->string('tin_no')->nullable();
            $table->string('category')->nullable();
            $table->string('partner_category')->nullable();
            $table->string('target_group')->nullable();
            $table->integer('total_teachers')->nullable();
            $table->integer('total_students')->nullable();
            $table->boolean('batch_system')->default(false);
            $table->string('class_range')->nullable();
            $table->text('subjects_offered')->nullable();
        });
    }
};
