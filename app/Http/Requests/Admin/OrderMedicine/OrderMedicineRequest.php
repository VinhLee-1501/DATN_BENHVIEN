<?php

namespace App\Http\Requests\Admin\OrderMedicine;

use Illuminate\Foundation\Http\FormRequest;

class OrderMedicineRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true; // Cho phép request
    }

    public function rules()
    {
        $rules = [
            'payment_method' => ['required', 'in:0,1,2'], // Yêu cầu payment_method là 0 hoặc 1
        ];

        // Nếu payment_method là 0, yêu cầu nhập cash_received
        if ($this->input('payment_method') == 0) {
            $rules['cash_received'] = ['required', 'numeric', 'min:0']; // cash_received phải >= 0
            $rules['total_amount'] = ['required', 'numeric', 'min:0']; // total_amount bắt buộc
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'payment_method.required' => 'Hình thức thanh toán là bắt buộc.',
            'payment_method.in' => 'Hình thức thanh toán không hợp lệ.',
            'cash_received.required' => 'Vui lòng nhập số tiền khách đưa.',
            'cash_received.numeric' => 'Số tiền khách đưa phải là một số.',
            'cash_received.min' => 'Số tiền khách đưa không thể nhỏ hơn 0.',
            'total_amount.required' => 'Tổng số tiền là bắt buộc.',
            'total_amount.numeric' => 'Tổng số tiền phải là một số.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->input('payment_method') == 0) {
                $cashReceived = $this->input('cash_received');
                $totalAmount = $this->input('total_amount');

                // Kiểm tra nếu số tiền khách đưa nhỏ hơn tổng tiền và đảm bảo các giá trị hợp lệ
                if (is_numeric($cashReceived) && is_numeric($totalAmount) && $cashReceived < $totalAmount) {
                    $validator->errors()->add(
                        'cash_received',
                        'Số tiền khách đưa phải lớn hơn hoặc bằng tiền cần thanh toán.'
                    );
                }
            }
        });
    }
}
