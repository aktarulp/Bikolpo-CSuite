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
            // Basic Info
            $table->string('slug')->nullable()->after('user_id');
            $table->string('cover_photo')->nullable()->after('logo');
            
            // Contact & Location
            $table->string('owner_name')->nullable()->after('description');
            $table->string('mobile')->nullable()->after('owner_name');
            $table->string('alternate_mobile')->nullable()->after('mobile');
            $table->string('website')->nullable()->after('alternate_mobile');
            $table->string('facebook_page')->nullable()->after('website');
            $table->string('division')->nullable()->after('facebook_page');
            $table->string('district')->nullable()->after('division');
            $table->string('upazila')->nullable()->after('district');
            $table->text('map_location')->nullable()->after('address');
            
            // Registration & Legal Info
            $table->year('established_year')->nullable()->after('map_location');
            $table->string('eiin_no')->nullable()->after('established_year');
            $table->string('trade_license_no')->nullable()->after('eiin_no');
            $table->string('tin_no')->nullable()->after('trade_license_no');
            
            // Academic & Service Info
            $table->string('category')->nullable()->after('tin_no');
            $table->string('target_group')->nullable()->after('category');
            $table->text('subjects_offered')->nullable()->after('target_group');
            $table->string('class_range')->nullable()->after('subjects_offered');
            $table->integer('total_teachers')->nullable()->after('class_range');
            $table->integer('total_students')->nullable()->after('total_teachers');
            $table->boolean('batch_system')->default(false)->after('total_students');
            
            // Payment & Subscription
            $table->string('subscription_plan')->nullable()->after('batch_system');
            $table->date('subscription_start_date')->nullable()->after('subscription_plan');
            $table->date('subscription_end_date')->nullable()->after('subscription_start_date');
            $table->enum('payment_status', ['pending', 'paid', 'overdue', 'cancelled'])->default('pending')->after('subscription_end_date');
            
            // System Management
            $table->foreignId('created_by')->nullable()->after('payment_status')->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            // Drop foreign key constraints first
            $table->dropForeign(['created_by']);
            
            // Drop all added columns
            $table->dropColumn([
                'slug',
                'cover_photo',
                'owner_name',
                'mobile',
                'alternate_mobile',
                'website',
                'facebook_page',
                'division',
                'district',
                'upazila',
                'map_location',
                'established_year',
                'eiin_no',
                'trade_license_no',
                'tin_no',
                'category',
                'target_group',
                'subjects_offered',
                'class_range',
                'total_teachers',
                'total_students',
                'batch_system',
                'subscription_plan',
                'subscription_start_date',
                'subscription_end_date',
                'payment_status',
                'created_by'
            ]);
        });
    }
};
