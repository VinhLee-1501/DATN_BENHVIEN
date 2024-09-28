<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Str;
class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('phone', '0787258565')->first();
        $user_2 = User::where('phone', '0787258369')->first();
        Patient::create([
            'patient_id' => strtoupper(Str::random(10)),
            'first_name' => 'User',
            'last_name' => 'Nguyen ',
            'gender' => '1',
            'birthday' => date('2004-05-01'),
            'address' => 'Ngã bảy, Hậu Giang',
            'Insurance_number' => '8612385245',
            'emergency_contact' => '0369852157',
            'occupation'=>'Sinh viên',
            'national'=> 'Việt Name',
            'phone' => $user->phone
        ]);
        Patient::create([
            'patient_id' => strtoupper(Str::random(10)),
            'first_name' => 'Phước Vinh',
            'last_name' => 'Lê ',
            'gender' => '1',
            'birthday' => date('2004-05-02'),
            'address' => 'Ngã bảy, Hậu Giang',
            'Insurance_number' => '8612385245',
            'emergency_contact' => '0369852157',
            'occupation'=>'Sinh viên',
            'national'=> 'Việt Name',
            'phone' => $user_2->phone
        ]);
        Patient::create([
            'patient_id' => strtoupper(Str::random(10)),
            'first_name' => 'Phước Vinh',
            'last_name' => 'Lê ',
            'gender' => '1',
            'birthday' => date('2004-05-02'),
            'address' => 'Ngã bảy, Hậu Giang',
            'Insurance_number' => '8612385245',
            'emergency_contact' => '0369852157',
            'occupation'=>'Sinh viên',
            'national'=> 'Việt Name',
            'phone' => $user_2->phone
        ]);

    }
}
