<?php

namespace App\Http\Requests\Admin\SaleProduct;

use App\Models\Products\SaleProduct;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    protected $saleProduct;
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
        $this->saleProduct = SaleProduct::where('sale_id', $id)->first();
        $rules = [
            'discount' => 'required|min:1',
            'timeStart' => 'required',
            'timeEnd' => 'required',
            'productId' => 'required'
        ];

        if ($this->saleProduct && $this->input('saleCode') !== $this->saleProduct->sale_code) {
            $rules['saleCode'] = 'required|unique:sale_products,sale_code|max:10';
        } else {
            $rules['saleCode'] = 'required|max:10';
        }

        return $rules;
    }

    public function messages(): array{
        return [
            'saleCode.required' => 'Mã giảm giá không được bỏ trống',
            'saleCode.unique' => 'Mã giảm giá đã tồn tại',
            'saleCode.max' => 'Mã giảm giá tối đa 10 ký tự',
            'discount.required' => 'Phần trăm giảm giá không được bỏ trống',
            'discount.min' => 'Phần trăm giảm giá phải lớn hơn 0',
            'timeStart.required' => 'Hãy chọn ngày bắt đầu giảm giá',
            'timeEnd.required' => 'Hãy chọn ngày kết thúc giảm giá',
            'productId.required' => 'Hãy chọn sản phẩm cần giảm giá'
        ];
    }
}
