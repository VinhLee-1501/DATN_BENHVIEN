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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id('row_id')->primary();
            $table->string('medicine_id', 10)->unique();
            $table->string('name', 255);
            $table->string('active_ingredient', 255);
            $table->string('unit_of_measurement', 255);
            $table->tinyInteger('status');

            $table->string('medicine_type_id', 10)->nullable();
            $table->foreign('medicine_type_id')
                ->references('medicine_type_id')
                ->on('medicine_types')
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
        Schema::dropIfExists('medicines');
    }
};
