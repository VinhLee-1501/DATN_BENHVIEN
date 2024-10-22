<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialty_id = Specialty::first();
        User::create([
            'user_id' => strtoupper(Str::random(10)),
            'firstname' => 'admin',
            'lastname' => 'foo',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'phone' => '0147258369',
            'role' => 1,
            'status' => 1
        ]);

        User::create([
            'user_id' => strtoupper(Str::random(10)),
            'firstname' => 'doctor',
            'lastname' => 'foo',
            'email' => 'doctor@example.com',
            'password' => bcrypt('doctor123'),
            'phone' => '0847258369',
            'specialty_id' => $specialty_id->specialty_id,
            'role' => 2,
            'status' => 1,
        ]);

        User::create([
            'user_id' => strtoupper(Str::random(10)),
            'firstname' => 'Bác sĩ',
            'lastname' => 'Doc',
            'email' => 'bacsi@example.com',
            'password' => bcrypt('123456'),
            'phone' => '0847243242',
            'specialty_id' => $specialty_id->specialty_id,
            'role' => 2,
            'status' => 1,
        ]);
//
        User::create([
            'user_id' => strtoupper(Str::random(10)),
            'firstname' => 'Phước Vinh',
            'lastname' => 'Lê',
            'email' => 'vinh@example.com',
            'password' => bcrypt('test123'),
            'phone' => '0787258369',
            'role' => 0,
            'status' => 1
        ]);

        User::create([
            'user_id' => strtoupper(Str::random(10)),
            'firstname' => 'User',
            'lastname' => 'Nguyen',
            'email' => 'user@example.com',
            'password' => bcrypt('user123'),
            'phone' => '0787258565',
            'role' => 0,
            'status' => 1
        ]);
    }
}
