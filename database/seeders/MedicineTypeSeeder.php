<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\MedicineType;
class MedicineTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MedicineType::create([
            'medicine_type_id' => strtoupper(Str::random(10)),
            'name' => 'Giảm đau',
            'status' => 0,
        ]);
        MedicineType::create([
            'medicine_type_id' => strtoupper(Str::random(10)),
            'name' => 'Kháng viêm',
            'status' => 0,
        ]);
        MedicineType::create([
            'medicine_type_id' => strtoupper(Str::random(10)),
            'name' => 'Dạ dày',
            'status' => 0,
        ]);
    }
}
