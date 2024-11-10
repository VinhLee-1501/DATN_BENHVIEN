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
            $table->id('product_id')->primary();
            $table->string('name', 255);
            $table->string('code_product', 20);
            $table->string('unit_of_measurement', 255);
            $table->string('active_ingredient', 255);
            $table->string('used', 255);
            $table->text('description');
            $table->integer('price');
            $table->string('brand', 255);
            $table->string('manufacture', 255);
            $table->string('registration_number', 255);
            $table->boolean('status')->comment('0 là hết, 1 là còn');
            $table->unsignedBigInteger('category_id')->nullable();;
            $table->foreign('category_id')
                ->references('category_id')
                ->on('categories')
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
        Schema::dropIfExists('products');
    }
};
