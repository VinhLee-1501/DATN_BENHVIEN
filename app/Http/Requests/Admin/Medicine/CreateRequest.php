<?php

namespace App\Http\Requests\Admin\Medicine;

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
            'medicine_type_id' => 'required|max:10',
            'medicine_id' => 'required|max:10|unique:medicines,medicine_id',
            'name' => 'required|max:255|unique:medicines,name',
            'active_ingredient' => 'required|max:255',
            'unit_of_measurement' => 'required|max:255',
            'price' => 'required',
            'amount' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'price.required' => ':attribute không để trống',
            'amount.required' => ':attribute không để trống',

            'medicine_type_id.required' => ':attribute không để trống',
            'medicine_type_id.max' => ':attribute không được vượt quá 10 ký tự',

            'medicine_id.required' => ':attribute không để trống',
            'medicine_id.max' => ':attribute không được vượt quá 10 ký tự',
            'medicine_id.unique' => ':attribute đã tồn tại',
            'name.required' => ':attribute không để trống',

            'name.max' => ':attribute không được vượt quá 255 ký tự',
            'name.unique' => ':attribute đã tồn tại',

            'active_ingredient.required' => ':attribute không để trống',
            'active_ingredient.max' => ':attribute không được vượt quá 255 ký tự',

            'unit_of_measurement.required' => ':attribute không để trống',
            'unit_of_measurement.max' => ':attribute không được vượt quá 255 ký tự',
        ];
    }

    public function attributes(): array
    {
        return [
            'medicine_type_id' => 'Nhóm thuốc',
            'medicine_id' => 'Mã thuốc',
            'name' => 'Tên thuốc',
            'active_ingredient' => 'Hoạt tính',
            'unit_of_measurement' => 'Đơn vị',
            'price' => 'Giá thuốc',
            'amount' => 'Đơn vị thuốc',
        ];
    }
}
