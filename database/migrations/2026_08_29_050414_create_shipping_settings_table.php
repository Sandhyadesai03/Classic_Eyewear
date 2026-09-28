<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_settings', function (Blueprint $table) {
            $table->id();

            $table->decimal('shipping_charge', 10, 2)
                  ->default(100);

            $table->decimal('free_shipping_amount', 10, 2)
                  ->default(2000);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_settings');
    }
};