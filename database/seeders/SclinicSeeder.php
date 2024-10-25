<?php

namespace Database\Seeders;

use App\Models\Sclinic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SclinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Sclinic::create([
            'sclinic_id' => 'SCLINICID1',
            'name' => 'Phòng 301',
            'description' => 'phòng khám chuyên khoa',

        ]);
        Sclinic::create([
            'sclinic_id' => 'SCLINICID2',
            'name' => 'Phòng 302',
            'description' => 'phòng khám nội tổng quát',
        ]);
        
        Sclinic::create([
            'sclinic_id' => 'SCLINICID3',
            'name' => 'Phòng 303',
            'description' => 'phòng khám nhi khoa',
        ]);
        
        Sclinic::create([
            'sclinic_id' => 'SCLINICID4',
            'name' => 'Phòng 304',
            'description' => 'phòng khám da liễu',
        ]);
        
        Sclinic::create([
            'sclinic_id' => 'SCLINICID5',
            'name' => 'Phòng 305',
            'description' => 'phòng khám tai mũi họng',
        ]);
        
    }
}