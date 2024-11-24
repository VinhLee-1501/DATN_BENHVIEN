<?php

namespace App\Http\Requests\Admin\Medicine;

use App\Models\MedicineType;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicineTypeRequest extends FormRequest
{
    protected $medicineType;
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
        $id = $this->route('row_id');
        $this->medicineType = MedicineType::where('medicine_type_id', $id)->first();

        $rule = [
            'status' => 'boolean',
        ];
        
        if ($this->medicineType && $this->input('name') !== $this->medicineType->name) {
            $rule['name'] = 'required|max:255|unique:medicine_types,name';
        } else {
            $rule['name'] = 'required|max:255';
        }

        return $rule;
    }

    public function messages(): array
    {
        return [
            'name.required' => ':attribute không để trống',
            'name.unique' => ':attribute đã tồn tại',
            'name.max' => ':attribute vượt quá ký tự cho phép',
            'status.boolean' => 'Trạng thái không được bỏ trống'
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Tên nhóm thuốc',
        ];
    }
}