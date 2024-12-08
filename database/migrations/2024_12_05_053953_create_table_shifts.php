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
        Schema::create('table_shifts', function (Blueprint $table) {
            $table->id('row_id')->primary();
            $table->string('name', 50)->nullable();
            $table->boolean('status')->nullable();
            $table->string('note', 100)->nullable();

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
        Schema::dropIfExists('table_shifts');
    }
};
