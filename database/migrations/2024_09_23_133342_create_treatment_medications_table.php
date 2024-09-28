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
        Schema::create('treatment_medications', function (Blueprint $table) {
            $table->id('row_id')->primary();
            $table->string('treatment_id', 10)->nullable();
            $table->foreign('treatment_id')
                ->references('treatment_id')
                ->on('treatment_details')
                ->onDelete('set null');

            $table->string('medicine_id', 10)->nullable();
            $table->foreign('medicine_id')
                ->references('medicine_id')
                ->on('medicines')
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
        Schema::dropIfExists('treatment_medications');
    }
};
