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
        Schema::create('cart_products', function (Blueprint $table) {
            $table->id('cart_id')->primary();
            $table->string('name', 255);
            $table->integer('quantity');
            $table->integer('total_price')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('user_id',10)->nullable();
            $table->foreign('product_id')
            ->references('product_id')
            ->on('products')
            ->onDelete('set null');
            $table->foreign('user_id')
            ->references('user_id')
            ->on('users')
            ->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_products');
    }
};
