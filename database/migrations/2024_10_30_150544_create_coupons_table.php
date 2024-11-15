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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id('coupon_id')->primary();
            $table->string('discount_code', 10);
            $table->integer('type')->default(0)->comment('0 bill, 1 sản phẩm, 2 danh mục');
            $table->integer('percent');
            $table->integer('use_limit');
            $table->integer('min_purchase')->nullable();
            $table->string('note');
            $table->date('time_start'); 
            $table->date('time_end');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};

