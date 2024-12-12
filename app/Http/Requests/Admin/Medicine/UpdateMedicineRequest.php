<?php

namespace App\Http\Requests\Admin\Medicine;

use App\Models\Medicine;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicineRequest extends FormRequest
{
    protected $medicine;
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
        $id = $this->route('medicine_id');
        $this->medicine = Medicine::where('medicine_id', $id)->first();

        $rule = [
            'medicine_type_id' => 'required',
            'active_ingredient' => 'required|max:255',
            'unit_of_measurement' => 'required|max:255',
        ];

        if ($this->medicine && $this->input('name') !== $this->medicine->name) {
            $rule['name'] = 'required|max:255|unique:medicines,name';
        } else {
            $rule['name'] = 'required|max:255';
        }
        return $rule;
    }

    public function messages(): array
    {
        return [

            'medicine_type_id.required' => ':attribute không để trống',
            'medicine_id.required' => ':attribute không để trống',

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

        ];
    }
}
