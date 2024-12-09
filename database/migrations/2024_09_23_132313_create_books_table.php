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
        Schema::create('books', function (Blueprint $table) {
            $table->id('row_id')->primary();
            $table->string('book_id', 10)->unique();
            $table->dateTime('day');
            $table->time('hour')->nullable();
            $table->string('name', 50);
            $table->string('phone',10);
            $table->string('email', 255)->nullable();
            $table->string('symptoms', 255)->nullable();
            $table->string('shift_id', 10)->nullable();

            // Thêm cột specialty_id
            $table->string('specialty_id');
            //
            $table->string('url', 255)->nullable();
            $table->boolean('role')->default(0)->comment('0: off; 1: onl');

            // Thêm cột user_id làm khóa ngoại
            $table->string('user_id')->nullable(); // Nullable để có thể không có người dùng

            // Khóa ngoại cho specialty_id
            $table->foreign('specialty_id')
                ->references('specialty_id')
                ->on('specialties')
                ->onDelete('cascade'); // Xóa các bản ghi liên quan khi chuyên khoa bị xóa

            // Khóa ngoại cho shift_id
            $table->foreign('shift_id')
                ->references('shift_id')
                ->on('schedules')
                ->onDelete('set null');

            // Khóa ngoại cho user_id
            $table->foreign('user_id')
                ->references('user_id') // 'id' là khóa chính trong bảng 'users'
                ->on('users')
                ->onDelete('set null'); // Xóa các bản ghi liên quan khi người dùng bị xóa

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};