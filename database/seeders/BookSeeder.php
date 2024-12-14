<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Specialty;
use App\Models\Schedule;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Book::create([
        //     'book_id' => 'BOOKID0001',
        //     'day' => now(),
        //     'name' => 'Lê Phước Vinh',
        //     'phone' => '0787258369',
        //     'hour'  => now(),
        //     'email' => 'vinh@example.com',
        //     'symptoms' => 'đau họng, nhức đầu',
        //     'specialty_id' => 'SPECIALTY1',
        //     'shift_id' => 'SHIFTID001'
        // ]);
        // Book::create([
        //     'book_id' => 'BOOKID0002',
        //     'day' => now(),
        //     'name' => 'Nguyễn Thị Hồng',
        //     'phone' => '0987654321',
        //     'hour'  => now(),
        //     'email' => 'hong@example.com',
        //     'symptoms' => 'ho, khó thở',
        //     'specialty_id' => 'SPECIALTY2',
        //     'shift_id' => 'SHIFTID002'
        // ]);

        // Book::create([
        //     'book_id' => 'BOOKID0003',
        //     'day' => now(),
        //     'name' => 'Trần Văn Minh',
        //     'phone' => '0123456789',
        //     'hour'  => now(),
        //     'email' => 'minh@example.com',
        //     'symptoms' => 'sốt cao, đau cơ',
        //     'specialty_id' => 'SPECIALTY3', // id chuyên khoa phù hợp
        //     'shift_id' => 'SHIFTID003' // id ca làm phù hợp
        // ]);

        // Book::create([
        //     'book_id' => 'BOOKID0004',
        //     'day' => now(),
        //     'name' => 'Phạm Văn An',
        //     'phone' => '0909090909',
        //     'hour'  => now(),
        //     'email' => 'an@example.com',
        //     'symptoms' => 'đau bụng, buồn nôn',
        //     'specialty_id' => 'SPECIALTY4', // id chuyên khoa phù hợp
        //     'shift_id' => 'SHIFTID004'
        // ]);

        // Book::create([
        //     'book_id' => 'BOOKID0005',
        //     'day' => now(),
        //     'name' => 'Lê Thị Hoa',
        //     'phone' => '0777888999',
        //     'hour'  => now(),
        //     'email' => 'hoa@example.com',
        //     'symptoms' => 'mệt mỏi, chóng mặt',
        //     'specialty_id' => 'SPECIALTY5', // id chuyên khoa phù hợp
        //     'shift_id' => 'SHIFTID005' // id ca làm phù hợp
        // ]);
    }
}
