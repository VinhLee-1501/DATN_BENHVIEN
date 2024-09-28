<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Medicine;
use Illuminate\Support\Str;
use App\Models\MedicineType;
class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $type = MedicineType::first();
        Medicine::create([
            'medicine_id' => strtoupper(Str::random(10)),
            'name' => 'Panadol Extra',
            'active_ingredient' => 'paracetamol 500mg, codeine, vitamin C',
            'unit_of_measurement' => 'Bột sủi',
            'status'=> 0,
            'medicine_type_id' => $type->medicine_type_id
        ]);

        Medicine::create([
            'medicine_id' => strtoupper(Str::random(10)),
            'name' => 'Tatanol',
            'active_ingredient' => 'paracetamol 500mg, codeine, vitamin C',
            'unit_of_measurement' => 'Viên nén',
            'status'=> 0,
            'medicine_type_id' => $type->medicine_type_id
        ]);

        Medicine::create([
            'medicine_id' => strtoupper(Str::random(10)),
            'name' => 'LEVOLEO 750',
            'active_ingredient' => 'Levofloxacin hemihydrat 768,7mg',
            'unit_of_measurement' => 'Viên nén',
            'status'=> 0,
            'medicine_type_id' => $type->medicine_type_id
        ]);

        Medicine::create([
            'medicine_id' => strtoupper(Str::random(10)),
            'name' => 'Cefurich 500',
            'active_ingredient' => 'Cefuroxim 500mg',
            'unit_of_measurement' => 'Viên nén',
            'status'=> 0,
            'medicine_type_id' => $type->medicine_type_id
        ]);
    }
}
