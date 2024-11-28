<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceDirectory;

class ServiceDirectorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        ServiceDirectory::create([
            'directory_id' => 'DIRECTORY1',
            'name' => 'X-Quang',
            'status' => 0,
        ]);

        ServiceDirectory::create([
            'directory_id' => 'DIRECTORY2',
            'name' => 'Siêu âm',
            'status' => 0,
        ]);
        
        ServiceDirectory::create([
            'directory_id' => 'DIRECTORY3',
            'name' => 'Nội soi',
            'status' => 0,
        ]);
        
        ServiceDirectory::create([
            'directory_id' => 'DIRECTORY4',
            'name' => 'Xét nghiệm máu',
            'status' => 0,
        ]);
        
        ServiceDirectory::create([
            'directory_id' => 'DIRECTORY5',
            'name' => 'Chụp CT',
            'status' => 0,
        ]);
        
    }
}
