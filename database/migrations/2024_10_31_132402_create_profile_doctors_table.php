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
        Schema::create('profile_doctors', function (Blueprint $table) {
            $table->id('row_id')->primary();
            $table->text('description')->nullable();
            $table->text('work_experience')->nullable();
            $table->text('degree')->nullable()->comment('bằng cấp');
            $table->string('user_id')->nullable();
            $table->foreign('user_id')
                ->references('user_id')
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
        Schema::dropIfExists('profile_doctors');
    }
};
