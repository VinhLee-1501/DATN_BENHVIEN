<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'service_id' => 'SERVICEID1',
            'name' => 'X-Quang ngực',
            'price' => 165000,
            'directory_id' => 'DIRECTORY1', // X-Quang
        ]);
        
        Service::create([
            'service_id' => 'SERVICEID2',
            'name' => 'Siêu âm bụng',
            'price' => 200000,
            'directory_id' => 'DIRECTORY2', // Siêu âm
        ]);
        
        Service::create([
            'service_id' => 'SERVICEID3',
            'name' => 'Nội soi dạ dày',
            'price' => 350000,
            'directory_id' => 'DIRECTORY3', // Nội soi
        ]);
        
        Service::create([
            'service_id' => 'SERVICEID4',
            'name' => 'Xét nghiệm máu tổng quát',
            'price' => 120000,
            'directory_id' => 'DIRECTORY4', // Xét nghiệm máu
        ]);
        
        Service::create([
            'service_id' => 'SERVICEID5',
            'name' => 'Chụp CT não',
            'price' => 500000,
            'directory_id' => 'DIRECTORY5', // Chụp CT
        ]);
        
    }
}
