<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Reference\Reference;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('row_id')->primary();
            $table->string('order_id', 10)->unique();
            $table->integer('total_price');
            $table->tinyInteger('status')->default(0)
                ->comment('0 là chưa thanh toán' . '1 là đã thanh toán');
            $table->tinyInteger('payment')->default(0);
            $table->string('cashier', length: 20)->comment('Thu ngân')->nullable();
            $table->integer('cash_received')->comment('tiền khách đưa')->nullable();
            $table->integer('change_amount')->comment('tiền thừa')->nullable();
            $table->integer('total_amount')->comment('tổng tiền thu của dao dịch')->nullable();

            $table->string('book_id')->nullable(); 
            $table->foreign('book_id')
                ->references('book_id') 
                ->on('books')
                ->onDelete('set null');

            $table->string('treatment_id')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
