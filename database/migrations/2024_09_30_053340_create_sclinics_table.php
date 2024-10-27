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
        Schema::create('sclinics', function (Blueprint $table) {
            $table->id('row_id')->primary();
            $table->string('sclinic_id', 10)->unique();
            $table->string('name', 50);
            $table->string('description', 255);
            $table->tinyInteger('status')->default(0);

            $table->string('specialty_id', 10)->nullable();
            $table->foreign('specialty_id')
                ->references('specialty_id')
                ->on('specialties')
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
        Schema::dropIfExists('sclinics');
    }
};
