<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ensure student, teacher, operator are direct children of partner_admin and set level = 3
        DB::table('roles')
            ->whereIn('name', ['student', 'teacher', 'operator'])
            ->update(['parent_role_id' => 2, 'level' => 3]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to previous defaults if needed: teacher level 4, operator 5; parent remains 2
        DB::table('roles')->where('name', 'student')->update(['level' => 3]);
        DB::table('roles')->where('name', 'teacher')->update(['level' => 4]);
        DB::table('roles')->where('name', 'operator')->update(['level' => 5]);
    }
};
