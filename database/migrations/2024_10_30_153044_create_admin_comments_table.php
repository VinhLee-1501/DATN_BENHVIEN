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
        Schema::create('admin_comments', function (Blueprint $table) {
            $table->id('ad_comment_id')->primary();
            $table->string('response_text',255);

            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('user_id', 10)->nullable();
 
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
        Schema::dropIfExists('admin_comments');
    }
};
