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
        Schema::create('books', function (Blueprint $table) {
            $table->id('row_id')->primary();
            $table->string('book_id', 10)->unique();
            $table->dateTime('day');
            $table->string('name', 50);
            $table->integer('phone');
            $table->string('email', 255);
            $table->string('symptoms', 255);
            $table->string('shift_id', 10)->nullable();
            $table->foreign('shift_id')
                ->references('shift_id')
                ->on('schedules')
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
        Schema::dropIfExists('books');
    }
};
