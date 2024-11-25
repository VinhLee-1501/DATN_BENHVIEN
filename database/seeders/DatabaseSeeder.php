<?php

namespace Database\Seeders;

use App\Models\TreatmentDetail;
use App\Models\TreatmentService;
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
            TreatmentServiceSeeder::class,
            OrderProductSeeder::class,
            ParentCategorySeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            ImgProductSeeder::class,
            CouponSeeder::class,
            CartProductSeeder::class,
            OrderProductSeeder::class,
            PaymentProductSeeder::class,
            ReviewProductSeeder::class,
            AdminCommentSeeder::class,
            SaleProductSeeder::class,
            OrdersSeeder::class

            
        ]);
    }
}
