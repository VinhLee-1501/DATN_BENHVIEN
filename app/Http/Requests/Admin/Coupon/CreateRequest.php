<?php

namespace App\Http\Requests\Admin\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'couponCode' => 'required|unique:coupons,coupon_code|max:10',
            'discount' => 'required|min:1',
            'timeStart' => 'required',
            'timeEnd' => 'required',
        ];
    }

    public function messages(): array{
        return [
            'couponCode.required' => ':attribute không được để trống',
            'couponCode.unique' => ':attribute đã tồn tại',
            'couponCode.max' => ':attribute phải có từ 10 ký tự',
            'discount.required' => ':attribute không được để trống',
            'discount.min' => ':attribute phải lớn hơn 0',
            'timeStart.required' => ':attribute không được để trống',
            'timeEnd.required' => ':attribute không được để trống',
        ];
    }

    public function attributes(): array{
        return [
            'couponCode' => 'Mã coupon',
            'discount' => 'Giảm giá',
            'timeStart' => 'Thời gian bắt đầu',
            'timeEnd' => 'Thời gian kết thúc',
        ];
    }
}
