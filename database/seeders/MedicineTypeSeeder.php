<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicineType;
class MedicineTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MedicineType::create([
            'medicine_type_id' => 'MEDICINE01',
            'name' => 'Giảm đau',
            'status' => 0,
        ]);
        MedicineType::create([
            'medicine_type_id' => 'MEDICINE02',
            'name' => 'Kháng sinh',
            'status' => 1,
        ]);
        
        MedicineType::create([
            'medicine_type_id' => 'MEDICINE03',
            'name' => 'Hạ sốt',
            'status' => 1,
        ]);
        
        MedicineType::create([
            'medicine_type_id' => 'MEDICINE04',
            'name' => 'Kháng viêm',
            'status' => 1,
        ]);
        
        MedicineType::create([
            'medicine_type_id' => 'MEDICINE05',
            'name' => 'Chống dị ứng',
            'status' => 1,
        ]);
        
    }
}
