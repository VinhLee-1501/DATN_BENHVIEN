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
            'specialty_id' => strtoupper(Str::random(10)),
            'name' => 'Tai mũi họng',
            'status'=> 1,
        ]);
    }
}