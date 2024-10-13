<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id('row_id');
            $table->string('patient_id', 10)->unique();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->boolean('gender');
            $table->date('birthday');
            $table->string('address', 255);
            $table->integer('insurance_number'); // Sửa lại cho đúng quy tắc đặt tên
            $table->integer('emergency_contact');
            $table->string('occupation', 30);
            $table->string('national');
            $table->string('phone')->nullable();

            $table
                ->foreign('phone')
                ->references('phone')
                ->on('users')
                ->onDelete('set null') // Điều này sẽ đặt phone thành NULL trong bảng patients nếu phone trong bảng users bị xóa
                ->onUpdate('cascade'); // Cập nhật khi phone trong bảng users thay đổi

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
