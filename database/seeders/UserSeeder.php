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
            'firstname' => 'Cao',
            'lastname' => 'Nguyễn',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'phone' => '0147258369',
            'role' => 1,
            'status' => 1
        ]);

        User::create([
            'user_id' => 'USERID0002',
            'firstname' => 'Ngọc',
            'lastname' => 'Nguyễn',
            'email' => 'staff@example.com',
            'password' => bcrypt('staff123'),
            'phone' => '0978258273',
            'role' => 3,
            'status' => 1
        ]);
    }
}
