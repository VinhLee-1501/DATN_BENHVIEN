<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Book;
use Illuminate\Support\Str;

class MedicalRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $book = Book::first();
        $patient = Patient::first();
        MedicalRecord::create([
            'medical_id' => strtoupper(Str::random(10)),
            'date' => '2024-10-05 09:00:00',
            'diaginsis' => 'Viêm họng cấp tính',
            're_examination_date' => '2024-10-05',
            'symptom' => 'ho, đau họng',
            'status' => 1,
            'advice' => 'Không uống nước đá, uống nhiều nước ấm',
            'blood_pressure' => '120/80 mmHg',
            'respiratory_rate' => '12/min',
            'weight' => '70 kg',
            'height' => '1.75 m',
            'patient_id' => $patient->patient_id,
            'book_id' => $book->book_id,
        ]);
    }
}
