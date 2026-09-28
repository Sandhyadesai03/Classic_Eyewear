<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('name');

            $table->string('email');

            $table->string('mobile', 20);

            $table->string('pincode', 10);

            $table->text('address');

            $table->string('city');

            $table->string('state');

            $table->string('payment_method');

            $table->decimal('total_amount', 10, 2);

            $table->string('status')
                  ->default('Pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};