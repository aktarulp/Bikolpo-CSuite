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
            // Remove primary_contact_person column
            $table->dropColumn('primary_contact_person');
            
            // Rename primary_contact_no to owner_director_contact
            $table->renameColumn('primary_contact_no', 'owner_director_contact');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            // Add back primary_contact_person column
            $table->string('primary_contact_person')->nullable();
            
            // Rename owner_director_contact back to primary_contact_no
            $table->renameColumn('owner_director_contact', 'primary_contact_no');
        });
    }
};
