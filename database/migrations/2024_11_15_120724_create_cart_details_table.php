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
        Schema::create('cart_details', function (Blueprint $table) {
            $table->id('cart_detail_id')->primary();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')
                ->references('product_id')
                ->on('products')
                ->onDelete('set null');

            $table->integer('quantity');
            $table->unsignedBigInteger('cart_id')->nullable();
            $table->foreign('cart_id')
                ->references('cart_id')
                ->on('cart_products')
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
        Schema::dropIfExists('cart_details');
    }
};
