<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ParentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('parent_categories')->insert([
            [
                'Parent_id' => 1,
                'name' => 'Thuốc',
                'description' => 'Các loại thuốc',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'Parent_id' => 2,
                'name' => 'Thực phẩm chức năng',
                'description' => 'Các loại thực phẩm chức năng',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'Parent_id' => 3,
                'name' => 'Thiết bị y tế',
                'description' => 'Các loại thiết bị y tế',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'Parent_id' => 4,
                'name' => 'Chăm sóc cá nhân',
                'description' => 'Các loại chăm sóc cá nhân',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'Parent_id' => 5,
                'name' => 'Khác',
                'description' => 'Chưa phân loại',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
