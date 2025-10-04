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
        Schema::table('user_roles', function (Blueprint $table) {
            if (!Schema::hasColumn('user_roles', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            }
        });

        // Backfill user_id from legacy enhanced_user_id if present
        if (Schema::hasColumn('user_roles', 'enhanced_user_id')) {
            DB::statement('UPDATE user_roles SET user_id = COALESCE(user_id, enhanced_user_id)');
        }

        // Add indexes and foreign key if not already present
        Schema::table('user_roles', function (Blueprint $table) {
            if (Schema::hasColumn('user_roles', 'user_id')) {
                // Adding index explicitly helps even if FK is skipped in some envs
                $table->index('user_id');

                // Wrap FK in try/catch style by letting database ignore if exists
                try {
                    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                } catch (\Throwable $e) {
                    // noop: FK may already exist
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_roles', function (Blueprint $table) {
            if (Schema::hasColumn('user_roles', 'user_id')) {
                // Drop FK if exists
                try {
                    $table->dropForeign(['user_id']);
                } catch (\Throwable $e) {
                    // noop
                }

                // Drop index if exists (Laravel will ignore if not present)
                try {
                    $table->dropIndex(['user_id']);
                } catch (\Throwable $e) {
                    // noop
                }

                $table->dropColumn('user_id');
            }
        });
    }
};
