<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Specialty;
use Illuminate\Support\Str;
class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Specialty::create([
            'specialty_id' => 'SPECIALTY1',
            'name' => 'Nội tổng quát',
            'status'=> 1,
        ]);
        
        Specialty::create([
            'specialty_id' => 'SPECIALTY2',
            'name' => 'Ngoại khoa',
            'status'=> 1,
        ]);
        
        Specialty::create([
            'specialty_id' => 'SPECIALTY3',
            'name' => 'Nhi khoa',
            'status'=> 1,
        ]);
        
        Specialty::create([
            'specialty_id' => 'SPECIALTY4',
            'name' => 'Da liễu',
            'status'=> 1,
        ]);
        
        Specialty::create([
            'specialty_id' => 'SPECIALTY5',
            'name' => 'Tai mũi họng',
            'status'=> 1,
        ]);
        

       
    }
}
