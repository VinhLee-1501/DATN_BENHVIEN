<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServiceDirectory;
use Illuminate\Support\Str;
use App\Models\Service;
class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $directory = ServiceDirectory::first();
//        Service::create([
//            'service_id' => strtoupper(Str::random(10)),
//            'name' => 'Siêu âm bụng',
//            'price' => 165.00,
//            'directory_id' => $directory->directory_id,
//        ]);

        Service::create([
            'service_id' => strtoupper(Str::random(10)),
            'name' => 'Chụp X-Quang',
            'price' => 165.00,
            'directory_id' => $directory->directory_id,
        ]);
    }
}
