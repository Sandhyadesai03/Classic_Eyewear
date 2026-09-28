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
        /*
        |--------------------------------------------------------------------------
        | ADMIN READ
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('enquiries', 'admin_read')) {

            Schema::table('enquiries', function (Blueprint $table) {

                $table->boolean('admin_read')
                    ->default(false)
                    ->after('status');

            });
        }


        /*
        |--------------------------------------------------------------------------
        | USER READ
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('enquiries', 'user_read')) {

            Schema::table('enquiries', function (Blueprint $table) {

                $table->boolean('user_read')
                    ->default(true)
                    ->after('admin_read');

            });
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | REMOVE USER READ
        |--------------------------------------------------------------------------
        */

        if (Schema::hasColumn('enquiries', 'user_read')) {

            Schema::table('enquiries', function (Blueprint $table) {

                $table->dropColumn('user_read');

            });
        }


        /*
        |--------------------------------------------------------------------------
        | REMOVE ADMIN READ
        |--------------------------------------------------------------------------
        */

        if (Schema::hasColumn('enquiries', 'admin_read')) {

            Schema::table('enquiries', function (Blueprint $table) {

                $table->dropColumn('admin_read');

            });
        }
    }
};