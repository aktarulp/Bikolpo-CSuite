<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique('partners_email_unique');
            $table->string('phone')->nullable();
            $table->string('slug')->nullable();
            $table->string('logo')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('flag', ['active', 'deleted'])->default('active');
            $table->string('city')->nullable();
            $table->text('map_location')->nullable();
            $table->string('mobile')->nullable();
            $table->string('alternate_mobile')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook_page')->nullable();
            $table->string('division')->nullable();
            $table->string('district')->nullable();
            $table->year('established_year')->nullable();
            $table->string('subscription_plan')->nullable();
            $table->date('subscription_start_date')->nullable();
            $table->date('subscription_end_date')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'overdue', 'cancelled'])->default('pending');
            $table->unsignedBigInteger('created_by')->nullable()->index('partners_created_by_foreign');
            $table->string('institute_name')->nullable();
            $table->string('primary_contact_person')->nullable();
            $table->string('primary_contact_no')->nullable();
            $table->string('alternate_contact_person')->nullable();
            $table->string('alternate_contact_no')->nullable();
            $table->string('upazila_p_s')->nullable();
            $table->string('post_office')->nullable();
            $table->string('post_code')->nullable();
            $table->string('village_road_no')->nullable();
            $table->string('flat_house_no')->nullable();
            $table->string('subscription_plan_id')->nullable();
            $table->string('institute_name_bangla')->nullable();
            $table->string('slug_bangla')->nullable();
            $table->integer('year_of_establishment')->nullable();
            $table->text('short_address')->nullable();
            $table->json('course_offers')->nullable();
            $table->text('custom_courses')->nullable();
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
        Schema::dropIfExists('partners');
    }
}
