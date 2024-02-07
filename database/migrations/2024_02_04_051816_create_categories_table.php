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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('coverImage')->nullable();
            $table->timestamps();
        });

        Schema::create('category_brand', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained();
            $table->foreignId('brand_id')->constrained('brands');
            $table->primary(['category_id', 'brand_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('category_brand');
    }
};
