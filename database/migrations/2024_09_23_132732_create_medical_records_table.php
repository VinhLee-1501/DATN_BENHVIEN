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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id('row_id')->primary();
            $table->string('medical_id', 10)->unique();
            $table->dateTime('date');
            $table->string('diaginsis', 255);
            $table->date('re_examination_date');
            $table->string('symptom');
            $table->tinyInteger('status');
            $table->string('advice');
            $table->string('blood_pressure', 50);
            $table->string('respiratory_rate', 50);
            $table->string('weight', 50);
            $table->string('height', 50);

            $table->string('patient_id', 10)->nullable();
            $table->foreign('patient_id')
                ->references('patient_id')
                ->on('patients')
                ->onDelete('set null');

            $table->string('book_id', 10)->nullable();
            $table->foreign('book_id')
                ->references('book_id')
                ->on('books')
                ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
