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
            SpecialtySeeder::class,
            UserSeeder::class,
            PatientSeeder::class,
            SclinicSeeder::class,
            ScheduleSeeder::class,
            BookSeeder::class,
            MedicalRecordSeeder::class,
            ServiceDirectorySeeder::class,
            ServiceSeeder::class,
            MedicineTypeSeeder::class,
            MedicineSeeder::class,
            TreatmentDetailSeeder::class,
            TreatmentMedicationSeeder::class,
        ]);
    }
}
