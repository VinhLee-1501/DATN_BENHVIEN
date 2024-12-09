<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medicine;
use Illuminate\Support\Facades\Storage;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Medicine::create([
            'medicine_id' => 'MEDICINE01',
            'name' => 'Panadol Extra',
            'active_ingredient' => 'paracetamol 500mg, codeine, vitamin C',
            'unit_of_measurement' => 'Bột sủi',
            'status' => 0,
            'medicine_type_id' => 'MEDICINE01' // Đã sửa lại cho khớp với MedicineType
        ]);

        Medicine::create([
            'medicine_id' => 'MEDICINE02',
            'name' => 'Aspirin',
            'active_ingredient' => 'acetylsalicylic acid 500mg',
            'unit_of_measurement' => 'Viên nén',
            'status' => 1,
            'medicine_type_id' => 'MEDICINE02' // Đã sửa lại cho khớp với MedicineType
        ]);

        Medicine::create([
            'medicine_id' => 'MEDICINE03',
            'name' => 'Amoxicillin',
            'active_ingredient' => 'amoxicillin 500mg',
            'unit_of_measurement' => 'Viên nang',
            'status' => 1,
            'medicine_type_id' => 'MEDICINE03' // Đã sửa lại cho khớp với MedicineType
        ]);

        Medicine::create([
            'medicine_id' => 'MEDICINE04',
            'name' => 'Ibuprofen',
            'active_ingredient' => 'ibuprofen 400mg',
            'unit_of_measurement' => 'Viên nén',
            'status' => 1,
            'medicine_type_id' => 'MEDICINE04' // Đã sửa lại cho khớp với MedicineType
        ]);

        Medicine::create([
            'medicine_id' => 'MEDICINE05',
            'name' => 'Clarithromycin',
            'active_ingredient' => 'clarithromycin 250mg',
            'unit_of_measurement' => 'Viên nén',
            'status' => 1,
            'medicine_type_id' => 'MEDICINE05' // Đã sửa lại cho khớp với MedicineType
        ]);


        $json = Storage::get('public/medicines.json');
        $data = json_decode($json, true);

        // Kiểm tra dữ liệu
        if (isset($data['result']['items'])) {
            foreach ($data['result']['items'] as $item) {

                $expirationDate = null;

                // Điều kiện xác định hạn sử dụng theo loại thuốc
                if (isset($item['donViTinh'])) {
                    if (isset($item['donViTinh'])) {
                        if (strpos($item['donViTinh'], 'chai') !== false || strpos($item['donViTinh'], 'hoàn') !== false || strpos($item['donViTinh'], 'viên') !== false || strpos($item['donViTinh'], 'bình') !== false || strpos($item['donViTinh'], 'ống') !== false || strpos($item['donViTinh'], 'viên nén') !== false || strpos($item['donViTinh'], 'viên nang') !== false || strpos($item['donViTinh'], 'viên sủi') !== false || strpos($item['donViTinh'], 'chai/túi') !== false || strpos($item['donViTinh'], 'chai/lọ/túi') !== false) {
                            // Thuốc dạng chai, viên, bình, ống, hoàn, viễn nén, viễn nang, viễn sủi, chai/túi, chai/lọ/túi (24 tháng)
                            $expirationDate = now()->addMonths(24);
                        } elseif (strpos($item['donViTinh'], 'lỏng') !== false || strpos($item['donViTinh'], 'tube') !== false) {
                            // Thuốc dạng lỏng, tube (18 tháng)
                            $expirationDate = now()->addMonths(18);
                        } elseif (strpos($item['donViTinh'], 'tiêm') !== false || strpos($item['donViTinh'], 'đông lạnh') !== false || strpos($item['donViTinh'], 'bơm tiêm') !== false) {
                            // Thuốc dạng tiêm, đông lạnh, bơm tiêm (24 tháng)
                            $expirationDate = now()->addMonths(24);
                        } elseif (strpos($item['donViTinh'], 'bôi') !== false) {
                            // Thuốc dạng bôi tha mỹ phẩm (15 tháng)
                            $expirationDate = now()->addMonths(15);
                        } elseif (strpos($item['donViTinh'], 'xịt') !== false || strpos($item['donViTinh'], 'nhỏ mắt') !== false || strpos($item['donViTinh'], 'bút') !== false) {
                            // Thuốc dạng xịt, nhỏ mắt, bút (2 tháng)
                            $expirationDate = now()->addMonths(2);
                        } elseif (strpos($item['donViTinh'], 'gói') !== false) {
                            // Thuốc dạng gói (24 tháng)
                            $expirationDate = now()->addMonths(24);
                        } elseif (strpos($item['donViTinh'], 'lít') !== false) {
                            // Thuốc dạng lít (24 tháng)
                            $expirationDate = now()->addMonths(24);
                        } else {
                            $expirationDate = now()->addMonths(24);
                        }
                    }



                    // Chèn dữ liệu vào bảng 'medicines'
                    Medicine::create([
                        'medicine_id' => $item['id'],
                        'name' => $item['tenThuoc'],
                        'active_ingredient' => $item['hoatChat'],
                        'unit_of_measurement' => $item['donViTinh'],
                        'price' => $item['giaBanBuonDuKien'] ?? null,

                        'status' => 1,
                        'medicine_type_id' =>  null,

                        'dosage' => $item['hamLuong'] ?? null,
                        'packaging' => $item['quyCachDongGoi'] ?? null,
                        'license_number' => $item['soDangKy'] ?? null,
                        'expiration_date' => $expirationDate ?? null,

                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
