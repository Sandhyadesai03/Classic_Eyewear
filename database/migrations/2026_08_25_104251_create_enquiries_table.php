<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {

            $table->boolean('admin_read')
                ->default(false)
                ->after('status');

            $table->boolean('user_read')
                ->default(true)
                ->after('admin_read');

        });
    }

    public function down(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {

            $table->dropColumn([
                'admin_read',
                'user_read',
            ]);

        });
    }
};