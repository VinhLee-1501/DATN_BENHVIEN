<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServiceDirectory;
use Illuminate\Support\Str;

class ServiceDirectorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        ServiceDirectory::create([
//            'directory_id' => strtoupper(Str::random(10)),
//            'name' => 'Siêu âm',
//            'status' => 'Hoạt động',
//        ]);
//
//        ServiceDirectory::create([
//            'directory_id' => strtoupper(Str::random(10)),
//            'name' => 'Kiểm tra tổng quát',
//            'status' => 'Hoạt động',
//        ]);

        ServiceDirectory::create([
            'directory_id' => strtoupper(Str::random(10)),
            'name' => 'X-Quang',
            'status' => 'Hoạt động',
        ]);
    }
}
