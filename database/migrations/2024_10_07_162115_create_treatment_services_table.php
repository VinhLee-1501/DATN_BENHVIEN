<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Validator\Constraints\Length;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('treatment_services', function (Blueprint $table) {
            $table->id();
            $table->string('treatment_id', 10)->nullable();
            $table->string('note', length:255)->nullable();
            $table->string('result', length:255)->nullable();
            $table->foreign('treatment_id')
                ->references('treatment_id')
                ->on('treatment_details')
                ->onDelete('set null');

            $table->string('service_id', 10)->nullable();
            $table->foreign( 'service_id')
                ->references('service_id')
                ->on('services')
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
        Schema::dropIfExists('treatment_services');
    }
};