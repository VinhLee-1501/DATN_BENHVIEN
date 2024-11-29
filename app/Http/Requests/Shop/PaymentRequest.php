<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cho phép request này
    }

    public function rules(): array
    {
        return [
            'order_username' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'order_address' => 'required',
            'order_phone' => 'required|digits_between:10,11',
           
        ];
    }

    /**
     * Custom validation messages for the rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [

            'order_username.required' => 'Tên không được để trống.',
            'order_address.required' => 'Địa chỉ không được để trống.',
            'order_phone.required' => 'Số điện thoại không được để trống.',
            'phoneorder_phone.digits_between' => 'Số điện thoại phải từ 10 đến 11 chữ số.',
            
        ];
    }
}