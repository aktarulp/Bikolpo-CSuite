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
            // Missing fields from the edit form
            $table->string('institute_name_bangla')->nullable()->after('institute_name');
            $table->string('slug_bangla')->nullable()->after('slug');
            $table->integer('year_of_establishment')->nullable()->after('established_year');
            $table->text('short_address')->nullable()->after('flat_house_no');
            
            // Course offers fields
            $table->json('course_offers')->nullable()->after('short_address');
            $table->text('custom_courses')->nullable()->after('course_offers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn([
                'institute_name_bangla',
                'slug_bangla',
                'year_of_establishment',
                'short_address',
                'course_offers',
                'custom_courses'
            ]);
        });
    }
};
