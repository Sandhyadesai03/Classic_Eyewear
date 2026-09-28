<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add role and permissions safely.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')
                      ->default('user');
            }

            if (!Schema::hasColumn('users', 'permissions')) {
                $table->json('permissions')
                      ->nullable();
            }

        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }

            if (Schema::hasColumn('users', 'permissions')) {
                $table->dropColumn('permissions');
            }

        });
    }
};