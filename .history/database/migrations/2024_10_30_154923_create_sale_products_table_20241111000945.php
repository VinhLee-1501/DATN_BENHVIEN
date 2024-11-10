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
        Schema::create('sale_products', function (Blueprint $table) {
            $table->id('sale_id')->primary();
            $table->string('discount', 10);
            $table->datetime('time_start');
            $table->datetime('time_end');
            $table->boolean('status')->default(0);
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')
            ->references('product_id')
            ->on('products')
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
        Schema::dropIfExists('sale_products');
    }
};
