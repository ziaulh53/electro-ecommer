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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(0);
            $table->decimal('discountPrice', 10, 2)->nullable();
            $table->json('default_images')->nullable();
            $table->boolean('discountAvailable')->default(false);
            $table->boolean('newArrival')->default(false);
            $table->boolean('is_variation')->default(false);
            $table->text('description')->nullable();
            $table->foreignId('brands_id')->constrained('brands');
            $table->foreignId('category_id')->constrained('categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
