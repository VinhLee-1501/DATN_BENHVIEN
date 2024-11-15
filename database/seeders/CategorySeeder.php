<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert(
            [
                ['category_id' => 1,  'name' => 'Thuốc nhỏ mắt - tra mắt', 'parent_id' => 1,         'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 2,  'name' => 'Tiêu hóa - gan mật', 'parent_id' => 1,              'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 3,  'name' => 'Giảm đau - hạ sốt', 'parent_id' => 1,               'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 4,  'name' => 'Xương khớp - gout', 'parent_id' => 1,               'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 5,  'name' => 'Thuốc bổ', 'parent_id' => 1,                       'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 6,  'name' => 'Tim mạch - tiểu đường', 'parent_id' => 1,           'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 7,  'name' => 'Da liễu - dị ứng', 'parent_id' => 1,                'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 8,  'name' => 'Chống bệnh truyền nhiễm', 'parent_id' => 1,        'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 9,  'name' => 'Thần kinh - não bộ', 'parent_id' => 1,              'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 10, 'name' => 'Tiết niệu - sinh dục', 'parent_id' => 1,            'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 11, 'name' => 'Chế phẩm dùng trong phẫu thuật', 'parent_id' => 1, 'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 12, 'name' => 'Nội tiết tố', 'parent_id' => 1,                    'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 13, 'name' => 'Ung thư - ung bướu', 'parent_id' => 1,              'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 14, 'name' => 'Dinh dưỡng', 'parent_id' => 2,                     'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 15, 'name' => 'Vitamin và khoáng chất', 'parent_id' => 2,         'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 16, 'name' => 'Thảo dược và dược phẩm tự nhiên', 'parent_id' => 2,'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 17, 'name' => 'Hỗ trợ điều trị', 'parent_id' => 2,                'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 18, 'name' => 'Hỗ trợ tiêu hóa', 'parent_id' => 2,                'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 19, 'name' => 'Tăng cường chức năng', 'parent_id' => 2,           'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 20, 'name' => 'Hỗ trợ làm đẹp', 'parent_id' => 2,                 'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 21, 'name' => 'Hỗ trợ sức khỏe tim mạch', 'parent_id' => 2,       'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 22, 'name' => 'Sinh lý - Nội tiết', 'parent_id' => 2,             'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 23, 'name' => 'Gel bôi các loại', 'parent_id' => 3,               'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 24, 'name' => 'Dụng cụ sơ cứu', 'parent_id' => 3,                 'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 25, 'name' => 'Dụng cụ vệ sinh tai, mũi, họng', 'parent_id' => 3, 'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 26, 'name' => 'Dụng cụ kiểm tra sức khỏe', 'parent_id' => 3,      'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 27, 'name' => 'Dụng cụ y tế', 'parent_id' => 3,                   'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 28, 'name' => 'Miếng dán các loại', 'parent_id' => 3,             'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 29, 'name' => 'Khẩu trang', 'parent_id' => 3,                     'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 30, 'name' => 'Chăm sóc phụ nữ', 'parent_id' => 4,                'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 31, 'name' => 'Chăm sóc trẻ em', 'parent_id' => 4,                'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 32, 'name' => 'Chăm sóc răng miệng', 'parent_id' => 4,            'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 33, 'name' => 'Lăn xịt khử mùi', 'parent_id' => 4,                'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 34, 'name' => 'Đồ chăm sóc khác', 'parent_id' => 4,               'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 35, 'name' => 'Vệ sinh cá nhân', 'parent_id' => 4,                'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 36, 'name' => 'Khăn giấy', 'parent_id' => 4,                      'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['category_id' => 37, 'name' => 'Nhà cửa - đời sống', 'parent_id' => 4,              'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ]

        );

    }

}
