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
        Schema::create('treatment_details', function (Blueprint $table) {
            $table->id('row_id')->primary();
            $table->string('treatment_id', 10)->unique();
            $table->integer('quantity');
            $table->string('usage', 100);

            $table->string('service_id', 10)->nullable();
            $table->foreign('service_id')
                ->references('service_id')
                ->on('services')
                ->onDelete('set null');

            $table->string('medical_id', 10)->nullable();
            $table->foreign('medical_id')
                ->references('medical_id')
                ->on('medical_records')
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
        Schema::dropIfExists('treatment_details');
    }
};
