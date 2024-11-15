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
        Schema::create('category_sale', function (Blueprint $table) {
            $table->id('row_id')->primary();

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')
                ->references('category_id')
                ->on('categories')
                ->onDelete('set null');

            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->foreign('coupon_id')
                ->references('coupon_id')
                ->on('coupons')
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
        Schema::dropIfExists('category_sale');
    }
};
