<?php

namespace App\Http\Requests\Admin\Coupon;

use App\Models\Products\Coupon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    protected $coupon;
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
        $id = $this->route('id');
        $this->coupon = Coupon::where('coupon_id', $id)->first();
        $rules = [
            'discount' => 'required|min:1',
            'timeStart' => 'required',
            'timeEnd' => 'required'
        ];

        if($this->coupon && $this->input('couponCode') !== $this->coupon->coupon_code){
            $rules['couponCode'] = 'required|unique:coupons,coupon_code|max:10';
        }else{
            $rules['couponCode'] = 'required|max:10';
        }

        return $rules;
    }

    public function messages(): array{
        return [
            'couponCode.required' => ':attribute không để trống',
            'couponCode.unique' => ':attribute đã tồn tại',
            'couponCode.max' => ':attribute tối đa 10 ký tự',
            'discount.required' => ':attribute không để trống',
            'discount.min' => ':attribute phải lớn hơn 0',
            'timeStart.required' => ':attribute không để trống',
            'timeEnd.required' => ':attribute không để trống',
        ];
    }

    public function attributes(): array{
        return [
            'couponCode' => 'Mã giảm giá',
            'discount' => 'Giảm giá',
            'timeStart' => 'Thời gian bắt đầu',
            'timeEnd' => 'Thời gian kết thúc',
        ];
    }
}
