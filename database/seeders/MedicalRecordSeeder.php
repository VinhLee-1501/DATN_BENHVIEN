<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalRecord;

class MedicalRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // MedicalRecord::create([
        //     'medical_id' => 'MEDICALID1',
        //     'date' => now(),
        //     'diaginsis' => 'Viêm họng cấp tính',
        //     're_examination_date' => now(),
        //     'symptom' => 'ho, đau họng',
        //     'status' => 1,
        //     'advice' => 'Không uống nước đá, uống nhiều nước ấm',
        //     'blood_pressure' => '120/80 mmHg',
        //     'respiratory_rate' => '12/min',
        //     'weight' => '70 kg',
        //     'height' => '1.75 m',
        //     'patient_id' => 'PATIENTID1',
        //     'book_id' => 'BOOKID0001',
        //     'user_id' => 'USERID002' // Thêm user_id của doctor
        // ]);

        // MedicalRecord::create([
        //     'medical_id' => 'MEDICALID2',
        //     'date' => now(),
        //     'diaginsis' => 'Cảm cúm',
        //     're_examination_date' => now(),
        //     'symptom' => 'sốt, đau đầu',
        //     'status' => 1,
        //     'advice' => 'Nghỉ ngơi, uống nhiều nước, bổ sung vitamin C',
        //     'blood_pressure' => '118/76 mmHg',
        //     'respiratory_rate' => '14/min',
        //     'weight' => '68 kg',
        //     'height' => '1.72 m',
        //     'patient_id' => 'PATIENTID2',
        //     'book_id' => 'BOOKID0002',
        //     'user_id' => 'USERID005' // Thêm user_id của doctor
        // ]);

        // MedicalRecord::create([
        //     'medical_id' => 'MEDICALID3',
        //     'date' => now(),
        //     'diaginsis' => 'Dị ứng thời tiết',
        //     're_examination_date' => now(),
        //     'symptom' => 'phát ban, ngứa da',
        //     'status' => 1,
        //     'advice' => 'Tránh tiếp xúc với tác nhân gây dị ứng, dùng thuốc dị ứng',
        //     'blood_pressure' => '122/78 mmHg',
        //     'respiratory_rate' => '16/min',
        //     'weight' => '65 kg',
        //     'height' => '1.70 m',
        //     'patient_id' => 'PATIENTID3',
        //     'book_id' => 'BOOKID0003',
        //     'user_id' => 'USERID006' // Thêm user_id của doctor
        // ]);

        // MedicalRecord::create([
        //     'medical_id' => 'MEDICALID4',
        //     'date' => now(),
        //     'diaginsis' => 'Đau dạ dày',
        //     're_examination_date' => now(),
        //     'symptom' => 'đau bụng, buồn nôn',
        //     'status' => 1,
        //     'advice' => 'Tránh thức ăn cay nóng, chia nhỏ bữa ăn',
        //     'blood_pressure' => '110/70 mmHg',
        //     'respiratory_rate' => '13/min',
        //     'weight' => '75 kg',
        //     'height' => '1.78 m',
        //     'patient_id' => 'PATIENTID4',
        //     'book_id' => 'BOOKID0004',
        //     'user_id' => 'USERID007' // Thêm user_id của doctor
        // ]);

        // MedicalRecord::create([
        //     'medical_id' => 'MEDICALID5',
        //     'date' => now(),
        //     'diaginsis' => 'Viêm xoang',
        //     're_examination_date' => now(),
        //     'symptom' => 'nghẹt mũi, đau đầu',
        //     'status' => 1,
        //     'advice' => 'Xông mũi bằng nước muối sinh lý, giữ ấm vùng mũi',
        //     'blood_pressure' => '115/75 mmHg',
        //     'respiratory_rate' => '15/min',
        //     'weight' => '60 kg',
        //     'height' => '1.65 m',
        //     'patient_id' => 'PATIENTID5',
        //     'book_id' => 'BOOKID0005',
        //     'user_id' => 'USERID008' // Thêm user_id của doctor
        // ]);
    }
}
