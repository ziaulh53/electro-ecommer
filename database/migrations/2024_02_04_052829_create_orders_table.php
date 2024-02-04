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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('orderId');
            $table->json('items');
            $table->decimal('totalPrice', 10, 2);
            $table->json('shippingAddress');
            $table->json('billingAddress');
            $table->json('payment');
            $table->enum('status',['Pending', 'Accepted', 'Shipped', 'Cancelled', 'Delivered'])->default('Pending');
            $table->json('logistics')->nullable();
            $table->boolean('refunded')->default(false);
            $table->string('cancelNote')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
