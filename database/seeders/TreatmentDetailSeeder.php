<?php

namespace Database\Seeders;

use App\Models\MedicalRecord;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TreatmentDetail;
use Illuminate\Support\Str;
class TreatmentDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $service = Service::first();
        $medical = MedicalRecord::first();
        TreatmentDetail::create([
            'treatment_id' => strtoupper(Str::random(10)),
            'service_id' =>$service->service_id,
            'medical_id' => $medical->medical_id,
        ]);
    }
}
