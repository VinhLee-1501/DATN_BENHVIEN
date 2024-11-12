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
        Schema::create('services', function (Blueprint $table) {
            $table->id('row_id')->primary();
            $table->string('service_id', 10)->unique();
            $table->string('name', 50);
            $table->float('price');
            $table->tinyInteger('status')->default(0);
            $table->string('directory_id', 10)->nullable();
            $table->foreign('directory_id')
                ->references('directory_id')
                ->on('service_directories')
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
        Schema::dropIfExists('services');
    }
};