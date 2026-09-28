<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Category column already exists in products table.
    }

    public function down(): void
    {
        // Nothing to rollback.
    }
};