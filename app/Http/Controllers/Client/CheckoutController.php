<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{

    public function calculateShippingFee(Request $request)
    {
        // Default pickup address
        $defaultPickProvince = 'Cần Thơ';
        $defaultPickDistrict = 'Thường Thạnh';
        $defaultPickWeight = 100;  // weight in grams
        $defaultPickDeliverOption = 'none';

        // Validate form inputs
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
        ]);

        // Retrieve form inputs (province, district, ward codes)
        $provinceCode = $validatedData['province'];
        $districtCode = $validatedData['district'];
        $wardCode = $validatedData['ward'];

        // Get the province, district, and ward names based on the codes
        $provinceName = $this->getProvinceName($provinceCode);
        $districtName = $this->getDistrictName($districtCode, $provinceCode);
        $wardName = $this->getWardName($wardCode, $districtCode);

        // Prepare data for API request
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
            // Make API request using Http facade
            $response = Http::withHeaders([
                'Token' => '4Bg6v8jOpSuZycjCLBx61pzJtBBVtvj5o1OZv5',
            ])->get('https://services.giaohangtietkiem.vn/services/shipment/fee', $data);

            if ($response->successful()) {
                $result = $response->json();

                if ($result['success'] == 1) {
                    $shippingFee = $result['fee']['fee'] ?? 0;
                    $shippingText = $result['fee']['options'][0]['shipMoneyText'] ?? 'No shipping options available';
                    
                    session()->flash('formData', request()->all());
                    // Return the view with calculated shipping fee, text, and form data
                    return view('shop.checkout', [
                        'shippingFee' => $shippingFee,
                        'shippingText' => $shippingText,
                        'provinceCode' => $provinceCode,
                        'districtCode' => $districtCode,
                        'wardCode' => $wardCode,
                        'oldInput' => request()->all()
                    ]); 
                } else {
                    return back()->withErrors(['error' => 'Không thể lấy thông tin phí vận chuyển.'])->withInput();
                }
            } else {
                return back()->withErrors(['error' => 'Lỗi khi kết nối với API.'])->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()])->withInput();
        }
    }



    // Helper method to get the province name by code
    private function getProvinceName($provinceCode)
    {
        $response = Http::get("https://vn-public-apis.fpo.vn/provinces/getAll?limit=-1");

        if ($response->successful()) {
            $responseData = $response->json();

            // Check if "data" and "data.data" exist in the response
            if (isset($responseData['data']['data']) && !empty($responseData['data']['data'])) {
                $provinces = $responseData['data']['data'];
                foreach ($provinces as $province) {
                    if ($province['code'] == $provinceCode) {
                        return $province['name']; // Return province name
                    }
                }
            }
        }

        return 'Unknown Province'; // Default if not found or API fails
    }

    // Helper method to get the district name by code
    private function getDistrictName($districtCode, $provinceCode)
    {
        $response = Http::get("https://vn-public-apis.fpo.vn/districts/getByProvince?provinceCode={$provinceCode}&limit=-1");

        if ($response->successful()) {
            $responseData = $response->json();

            // Check if "data" and "data.data" exist in the response
            if (isset($responseData['data']['data']) && !empty($responseData['data']['data'])) {
                $districts = $responseData['data']['data'];
                foreach ($districts as $district) {
                    if ($district['code'] == $districtCode) {
                        return $district['name']; // Return district name
                    }
                }
            }
        }

        return 'Unknown District'; // Default if not found or API fails
    }

    // Helper method to get the ward name by code
    private function getWardName($wardCode, $districtCode)
    {
        $response = Http::get("https://vn-public-apis.fpo.vn/wards/getByDistrict?districtCode={$districtCode}&limit=-1");

        if ($response->successful()) {
            $responseData = $response->json();

            // Check if "data" and "data.data" exist in the response
            if (isset($responseData['data']['data']) && !empty($responseData['data']['data'])) {
                $wards = $responseData['data']['data'];
                foreach ($wards as $ward) {
                    if ($ward['code'] == $wardCode) {
                        return $ward['name']; // Return ward name
                    }
                }
            }
        }

        return 'Unknown Ward'; // Default if not found or API fails
    }
}
