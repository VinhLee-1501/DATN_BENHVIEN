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
        Schema::create('order_products', function (Blueprint $table) {
            $table->id('order_id')->primary();
            $table->integer('quantity');
            $table->integer('price_old');
            $table->integer('price_sale')->nullable();
            $table->tinyInteger('order_status');
            $table->string('order_username',255)->nullable();
            $table->string('order_phone',10)->nullable();
            $table->string('order_address',255)->nullable();
            $table->string('note', 10)->nullable();

            $table->unsignedBigInteger('cart_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->string('user_id',10)->nullable();

            $table->foreign('cart_id')
            ->references('cart_id')
            ->on('cart_products')
            ->onDelete('set null');

            $table->foreign('product_id')
            ->references('product_id')
            ->on('products')
            ->onDelete('set null');

            $table->foreign('coupon_id')
            ->references('coupon_id')
            ->on('coupons')
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
        Schema::dropIfExists('order_products');
    }
};
