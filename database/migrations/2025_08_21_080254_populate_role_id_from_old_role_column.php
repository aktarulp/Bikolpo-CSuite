<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get role IDs
        $partnerRoleId = DB::table('roles')->where('name', 'partner')->value('id');
        $studentRoleId = DB::table('roles')->where('name', 'student')->value('id');

        // Update users with partner role
        DB::table('users')
            ->where('role', 'partner')
            ->update(['role_id' => $partnerRoleId]);

        // Update users with student role
        DB::table('users')
            ->where('role', 'student')
            ->update(['role_id' => $studentRoleId]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration only populates data, no need to reverse
    }
};
