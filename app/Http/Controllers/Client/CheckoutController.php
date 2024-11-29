<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{

    public function calculateShippingFee(Request $request)
    {
        // Default pickup address
        $defaultPickProvince = 'Cần Thơ';
        $defaultPickDistrict = 'Thường Thạnh';
        $defaultPickWeight = 100;
        $defaultPickDeliverOption = 'none';


        $validatedData = $request->validate([
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
        ]);


        $provinceCode = $validatedData['province'];
        $districtCode = $validatedData['district'];
        $wardCode = $validatedData['ward'];


        $provinceName = $this->getProvinceName($provinceCode);
        $districtName = $this->getDistrictName($districtCode, $provinceCode);
        $wardName = $this->getWardName($wardCode, $districtCode);


        $data = [
            "pick_province" => $defaultPickProvince,
            "pick_district" => $defaultPickDistrict,
            "province" => $provinceName,
            "district" => $districtName,
            "ward" => $wardName,
            "weight" => $defaultPickWeight,
            "deliver_option" => $defaultPickDeliverOption,
        ];

        try {

            $response = Http::withHeaders([
                'Token' => '4Bg6v8jOpSuZycjCLBx61pzJtBBVtvj5o1OZv5',
            ])->get('https://services.giaohangtietkiem.vn/services/shipment/fee', $data);

            if ($response->successful()) {
                $result = $response->json();
                if (isset($result['success']) && $result['success'] == 1) {
                    $shippingFee = $result['fee']['fee'] ?? 0;
                    $shippingText = $result['fee']['options'][0]['shipMoneyText'] ?? 'No shipping options available';

                    session()->flash('formData', request()->all());

                    return response()->json([
                        'shippingFee' => $shippingFee,
                        'shippingText' => $shippingText,
                        'oldInput' => request()->all(),
                    ]);
                } else {
                    return response()->json(['error' => 'Không thể lấy thông tin phí vận chuyển.'], 400);
                }
            } else {
                $errorMessage = $response->body();
                return response()->json(['error' => 'Lỗi khi kết nối với API: ' . $errorMessage], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }


    private function getProvinceName($provinceCode)
    {
        try {
            $response = Http::get("https://provinces.open-api.vn/api/?depth=2");
            if ($response->successful()) {
                $responseData = $response->json();
                foreach ($responseData as $province) {
                    if ($province['code'] == $provinceCode) {
                        return $province['name'];
                    }
                }
            }
            return 'Unknown Province';
        } catch (\Exception $e) {
            return 'Unknown Province';
        }
    }


    private function getDistrictName($districtCode, $provinceCode)
    {
        try {
            $response = Http::get("https://provinces.open-api.vn/api/?depth=2");
            if ($response->successful()) {
                $responseData = $response->json();
                foreach ($responseData as $province) {
                    if ($province['code'] == $provinceCode) {
                        foreach ($province['districts'] as $district) {
                            if ($district['code'] == $districtCode) {
                                return $district['name'];
                            }
                        }
                    }
                }
            }
            return 'Unknown District';
        } catch (\Exception $e) {
            return 'Unknown District';
        }
    }


    private function getWardName($wardCode, $districtCode)
    {
        try {
            $response = Http::get("https://provinces.open-api.vn/api/?depth=2");
            if ($response->successful()) {
                $responseData = $response->json();
                foreach ($responseData as $province) {
                    foreach ($province['districts'] as $district) {
                        if ($district['code'] == $districtCode) {
                            foreach ($district['wards'] as $ward) {
                                if ($ward['code'] == $wardCode) {
                                    return $ward['name'];
                                }
                            }
                        }
                    }
                }
            }
            return 'Unknown Ward';
        } catch (\Exception $e) {

            return 'Unknown Ward';
        }
    }
}
