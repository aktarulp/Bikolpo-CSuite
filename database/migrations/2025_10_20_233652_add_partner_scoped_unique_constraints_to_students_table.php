<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPartnerScopedUniqueConstraintsToStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            // Drop existing global unique constraints
            $table->dropUnique('students_student_id_unique');
            $table->dropUnique('students_email_unique');
            
            // Add composite unique constraints that include partner_id
            // This allows different partners to use the same student_id, email, etc.
            $table->unique(['partner_id', 'student_id'], 'students_partner_student_id_unique');
            $table->unique(['partner_id', 'email'], 'students_partner_email_unique');
            $table->unique(['partner_id', 'phone'], 'students_partner_phone_unique');
            
            // Add unique constraints for parent/guardian information within partner
            $table->unique(['partner_id', 'father_phone'], 'students_partner_father_phone_unique');
            $table->unique(['partner_id', 'mother_phone'], 'students_partner_mother_phone_unique');
            $table->unique(['partner_id', 'guardian_phone'], 'students_partner_guardian_phone_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            // Drop the composite unique constraints
            $table->dropUnique('students_partner_student_id_unique');
            $table->dropUnique('students_partner_email_unique');
            $table->dropUnique('students_partner_phone_unique');
            $table->dropUnique('students_partner_father_phone_unique');
            $table->dropUnique('students_partner_mother_phone_unique');
            $table->dropUnique('students_partner_guardian_phone_unique');
            
            // Restore the original global unique constraints
            $table->unique('student_id', 'students_student_id_unique');
            $table->unique('email', 'students_email_unique');
        });
    }
}