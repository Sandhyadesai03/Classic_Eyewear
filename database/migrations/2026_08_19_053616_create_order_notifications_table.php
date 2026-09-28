<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_notifications', function (Blueprint $table) {

            $table->id();

            // Which user should receive notification
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Related order
            $table->foreignId('order_id')
                ->constrained('orders')
                ->onDelete('cascade');

            // Order status
            $table->string('status');

            // Notification message
            $table->text('message');

            // Whether notification was read
            $table->boolean('is_read')
                ->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_notifications');
    }
};