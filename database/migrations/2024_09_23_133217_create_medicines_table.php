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
            $table->id('row_id')->primary()->comment('Khóa chính của bảng');
            $table->string('medicine_id', 10)->unique()->comment('Mã định danh duy nhất của thuốc');
            $table->string('name', 255)->comment('Tên thuốc');
            $table->text('active_ingredient')->comment('Hoạt chất có trong thuốc');
            $table->string('unit_of_measurement', 255)->comment('Đơn vị đo (ví dụ: mg, ml)');
            $table->float('price')->nullable()->comment('Giá thuốc');

            $table->tinyInteger('status')->comment('Trạng thái của thuốc (đang hoạt động hay không)');

            $table->string('medicine_type_id', 10)->nullable()->comment('Khóa ngoại liên kết với bảng loại thuốc');
            $table->foreign('medicine_type_id')
                ->references('medicine_type_id')
                ->on('medicine_types')
                ->onDelete('set null')
                ->comment('Đặt giá trị null nếu loại thuốc liên kết bị xóa');
            $table->integer('amount')->nullable()->default(10000)->comment('Số lượng thuốc');
            // Các trường mới thêm vào
            $table->text('dosage' )->nullable()->comment('Hàm lượng thuốc (ví dụ: 500mg)');
            $table->text('packaging' )->nullable()->comment('Thông tin về quy cách đóng gói (ví dụ: hộp 10 viên)');
            $table->text('license_number' )->nullable()->comment('Số GPLH/GPNK của thuốc');
            $table->dateTime('expiration_date' )->nullable()->comment('Hạn sử dụng của thuốc (ví dụ: 24 tháng, 2 năm)');

            $table->softDeletes()->comment('Hỗ trợ xóa mềm');
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