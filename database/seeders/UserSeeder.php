<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'user_id' => 'USERID0001',
            'firstname' => 'admin',
            'lastname' => 'foo',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'phone' => '0147258369',
            'role' => 1,
            'status' => 1
        ]);

        User::create([
            'user_id' => 'USERID002',
            'firstname' => 'doctor',
            'lastname' => 'foo',
            'email' => 'doctor@example.com',
            'password' => bcrypt('doctor123'),
            'phone' => '0847258369',
            'specialty_id' => 'SPECIALTY1', // Nội tổng quát
            'role' => 2,
            'status' => 1,
        ]);

        User::create([
            'user_id' => 'USERID003',
            'firstname' => 'User',
            'lastname' => 'Member',
            'email' => 'user@example.com',
            'password' => bcrypt('user123'),
            'phone' => '0123456789', // Số điện thoại duy nhất
            'role' => 0,
            'status' => 1,
        ]);

        // Thêm tài khoản admin
        User::create([
            'user_id' => 'USERID0004',
            'firstname' => 'admin2',
            'lastname' => 'bar',
            'email' => 'admin2@example.com',
            'password' => bcrypt('admin123'),
            'phone' => '0987654321',
            'role' => 1, // Role 1: admin
            'status' => 1
        ]);

        // Thêm 4 tài khoản doctor
        User::create([
            'user_id' => 'USERID005',
            'firstname' => 'doctor1',
            'lastname' => 'bar',
            'email' => 'doctor1@example.com',
            'password' => bcrypt('doctor123'),
            'phone' => '0912345678',
            'specialty_id' => 'SPECIALTY2', // Ngoại khoa
            'role' => 2,
            'status' => 1,
        ]);

        User::create([
            'user_id' => 'USERID006',
            'firstname' => 'doctor2',
            'lastname' => 'bar',
            'email' => 'doctor2@example.com',
            'password' => bcrypt('doctor123'),
            'phone' => '0912345679',
            'specialty_id' => 'SPECIALTY3', // Nhi khoa
            'role' => 2,
            'status' => 1,
        ]);

        User::create([
            'user_id' => 'USERID007',
            'firstname' => 'doctor3',
            'lastname' => 'bar',
            'email' => 'doctor3@example.com',
            'password' => bcrypt('doctor123'),
            'phone' => '0912345680',
            'specialty_id' => 'SPECIALTY4', // Da liễu
            'role' => 2,
            'status' => 1,
        ]);

        User::create([
            'user_id' => 'USERID008',
            'firstname' => 'doctor4',
            'lastname' => 'bar',
            'email' => 'doctor4@example.com',
            'password' => bcrypt('doctor123'),
            'phone' => '0912345681',
            'specialty_id' => 'SPECIALTY5', // Tai mũi họng
            'role' => 2,
            'status' => 1,
        ]);

        // Thêm 4 tài khoản user
        User::create([
            'user_id' => 'USERID009',
            'firstname' => 'Vinh',
            'lastname' => 'Lâm Lê',
            'email' => 'vinh@example.com',
            'password' => bcrypt('user123'),
            'phone' => '0123456780', // Đổi thành số điện thoại duy nhất
            'role' => 0,
            'status' => 1,
        ]);

        User::create([
            'user_id' => 'USERID010',
            'firstname' => 'Hồng',
            'lastname' => 'Nguyễn Thị',
            'email' => 'hong@example.com',
            'password' => bcrypt('user123'),
            'phone' => '0376543210',
            'role' => 0,
            'status' => 1,
        ]);

        User::create([
            'user_id' => 'USERID011',
            'firstname' => 'Minh',
            'lastname' => 'Trần Văn',
            'email' => 'minh@example.com',
            'password' => bcrypt('user123'),
            'phone' => '0345678901',
            'role' => 0,
            'status' => 1,
        ]);

        User::create([
            'user_id' => 'USERID012',
            'firstname' => 'Hoa',
            'lastname' => 'Lê Thị',
            'email' => 'hoa@example.com',
            'password' => bcrypt('user123'),
            'phone' => '0356789012',
            'role' => 0,
            'status' => 1,
        ]);
    }
}

