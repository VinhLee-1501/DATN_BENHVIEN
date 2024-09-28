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
        Schema::create('patients', function (Blueprint $table) {
            $table->id('row_id')->primary();
            $table->string('patient_id', 10)->unique();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->boolean('gender');
            $table->date('birthday');
            $table->string('address', 255);
            $table->integer('Insurance_number');
            $table->integer('emergency_contact');
            $table->string('occupation', 30);
            $table->string('national');
            $table->string('phone')->nullable();
            $table
                ->foreign('phone')
                ->references('phone')
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
        Schema::dropIfExists('patients');
    }
};
