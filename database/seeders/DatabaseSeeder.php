<?php

namespace Database\Seeders;

use App\Models\TreatmentDetail;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BookSeeder::class,
            MedicalRecordSeeder::class,
            MedicineSeeder::class,
            MedicineTypeSeeder::class,
            PatientSeeder::class,
            ScheduleSeeder::class,
            ServiceDirectorySeeder::class,
            ServiceSeeder::class,
            SpecialtySeeder::class,
            TreatmentDetail::class,
            TreatmentMedicationSeeder::class,
            UserSeeder::class
        ]);
    }
}
