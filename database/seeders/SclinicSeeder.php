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
            'sclinic_id' => strtoupper(Str::random(10)),
            'name' => 'Phòng 301',
            'description' => 'phòng khám chuyên khoa',

        ]);
        Sclinic::create([
            'sclinic_id' => strtoupper(Str::random(10)),
            'name' => 'Phòng 103',
            'description' => 'phòng khám chuyên khoa mắt',

        ]);
        Sclinic::create([
            'sclinic_id' => strtoupper(Str::random(10)),
            'name' => 'Phòng 108',
            'description' => 'phòng khám chuyên khoa mắt ngoại',

        ]);
    }
}