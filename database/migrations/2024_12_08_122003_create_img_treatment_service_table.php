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
        Schema::create('img_treatment_service', function (Blueprint $table) {
            $table->id('img_id')->primary();
            $table->longText('img');
            $table->string('treatment_id', length:10)->nullable();
            $table->string('service_id', length:10)->nullable();
            $table->foreign('treatment_id')
                ->references('treatment_id')
                ->on('treatment_services')
                ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('img_treatment_service');
    }
};
