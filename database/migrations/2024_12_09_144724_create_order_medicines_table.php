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
        Schema::create('order_medicines', function (Blueprint $table) {
            $table->id('row_id')->primary();   
            $table->string('order_medicine_id', 10)->unique();
            $table->boolean('status')->default(0);
            $table->integer('price_service')->default(150000)->comment('phí khám');
            $table->integer('total_price')->nullable();
            $table->integer('cash_received')->nullable()->comment('tiền nhận');
            $table->integer('change')->nullable()->comment("tiền thừa");
            $table->string('user_id', 10)->nullable();
            $table->foreign('user_id')
            ->references('user_id')
            ->on('users')
            ->onDelete('set null');

            $table->string('treatment_id', 10)->nullable();
            $table->foreign('treatment_id')
            ->references('treatment_id')
            ->on('treatment_details')
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
        Schema::dropIfExists('order_medicines');
    }
};