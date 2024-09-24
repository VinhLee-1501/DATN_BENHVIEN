<?php

namespace Database\Seeders;

use App\Models\Medicine;
use App\Models\TreatmentDetail;
use App\Models\TreatmentMedication;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TreatmentMedicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $treatment = TreatmentDetail::first();
        $medicine = Medicine::first();
        TreatmentMedication::create([
            'treatment_id' => $treatment->treatment_id,
            'medicine_id' =>$medicine->medicine_id,
            'quantity' => 20,
            'usage' => '2/ngày',
        ]);
    }
}