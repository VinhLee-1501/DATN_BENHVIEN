<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Patient::create([
        //     'patient_id' => 'PATIENTID1',
        //     'first_name' => 'Nguyễn',
        //     'last_name' => 'Văn A',
        //     'gender' => 1, // Nam
        //     'birthday' => '1990-01-01',
        //     'address' => 'Hà Nội',
        //     'insurance_number' => '1234567890', // Đổi thành giá trị số bảo hiểm hợp lệ
        //     'emergency_contact' => '0901234567',
        //     'occupation' => 'Kỹ sư',
        //     'national' => 'Việt Nam',
        //     'phone' => '0123456780',
        // ]);

        // Patient::create([
        //     'patient_id' => 'PATIENTID2',
        //     'first_name' => 'Trần',
        //     'last_name' => 'Thị B',
        //     'gender' => 0, // Nữ
        //     'birthday' => '1995-05-05',
        //     'address' => 'Đà Nẵng',
        //     'insurance_number' => '0987654321', // Đổi thành giá trị số bảo hiểm hợp lệ
        //     'emergency_contact' => '0912345678',
        //     'occupation' => 'Giáo viên',
        //     'national' => 'Việt Nam',
        //     'phone' => '0376543210',
        // ]);

        // Patient::create([
        //     'patient_id' => 'PATIENTID3',
        //     'first_name' => 'Lê',
        //     'last_name' => 'Thị C',
        //     'gender' => 1, // Nam
        //     'birthday' => '1992-03-15',
        //     'address' => 'TP Hồ Chí Minh',
        //     'insurance_number' => '4567891230', // Đổi thành giá trị số bảo hiểm hợp lệ
        //     'emergency_contact' => '0987654321',
        //     'occupation' => 'Sinh viên',
        //     'national' => 'Việt Nam',
        //     'phone' => '0345678901',
        // ]);

        // Patient::create([
        //     'patient_id' => 'PATIENTID4',
        //     'first_name' => 'Phạm',
        //     'last_name' => 'Văn D',
        //     'gender' => 0, // Nữ
        //     'birthday' => '1988-09-10',
        //     'address' => 'Cần Thơ',
        //     'insurance_number' => '9876543210', // Đổi thành giá trị số bảo hiểm hợp lệ
        //     'emergency_contact' => '0965432109',
        //     'occupation' => 'Nông dân',
        //     'national' => 'Việt Nam',
        //     'phone' => '0356789012',
        // ]);

        // Patient::create([
        //     'patient_id' => 'PATIENTID5',
        //     'first_name' => 'Ngô',
        //     'last_name' => 'Thị E',
        //     'gender' => 1, // Nam
        //     'birthday' => '1985-11-20',
        //     'address' => 'Hải Phòng',
        //     'insurance_number' => '1234567890', // Đổi thành giá trị số bảo hiểm hợp lệ
        //     'emergency_contact' => '0911122233',
        //     'occupation' => 'Nhân viên',
        //     'national' => 'Việt Nam',
        //     'phone' => '0345678901',
        // ]);
    }
}
