<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medicine;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Medicine::create([
            'medicine_id' => 'MEDICINE01',
            'name' => 'Panadol Extra',
            'active_ingredient' => 'paracetamol 500mg, codeine, vitamin C',
            'unit_of_measurement' => 'Bột sủi',
            'status'=> 0,
            'medicine_type_id' => 'MEDICINE01' // Đã sửa lại cho khớp với MedicineType
        ]);

        Medicine::create([
            'medicine_id' => 'MEDICINE02',
            'name' => 'Aspirin',
            'active_ingredient' => 'acetylsalicylic acid 500mg',
            'unit_of_measurement' => 'Viên nén',
            'status' => 1,
            'medicine_type_id' => 'MEDICINE02' // Đã sửa lại cho khớp với MedicineType
        ]);
        
        Medicine::create([
            'medicine_id' => 'MEDICINE03',
            'name' => 'Amoxicillin',
            'active_ingredient' => 'amoxicillin 500mg',
            'unit_of_measurement' => 'Viên nang',
            'status' => 1,
            'medicine_type_id' => 'MEDICINE03' // Đã sửa lại cho khớp với MedicineType
        ]);
        
        Medicine::create([
            'medicine_id' => 'MEDICINE04',
            'name' => 'Ibuprofen',
            'active_ingredient' => 'ibuprofen 400mg',
            'unit_of_measurement' => 'Viên nén',
            'status' => 1,
            'medicine_type_id' => 'MEDICINE04' // Đã sửa lại cho khớp với MedicineType
        ]);
        
        Medicine::create([
            'medicine_id' => 'MEDICINE05',
            'name' => 'Clarithromycin',
            'active_ingredient' => 'clarithromycin 250mg',
            'unit_of_measurement' => 'Viên nén',
            'status' => 1,
            'medicine_type_id' => 'MEDICINE05' // Đã sửa lại cho khớp với MedicineType
        ]);
        
    }
}
