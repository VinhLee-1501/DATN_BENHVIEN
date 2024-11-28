<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Medicine\MedicineTypeRequest;
use App\Http\Requests\Admin\Medicine\UpdateMedicineTypeRequest;
use App\Models\MedicineType;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class MedicineTypeController extends Controller
{
    public function index(Request $request)
    {
        // Khởi tạo query gốc
        $query = MedicineType::orderByRaw('status = 0 DESC')->orderBy('row_id', 'desc');

        // Tìm kiếm theo tên thuốc      
        if ($request->filled('name')) {
            $query->where('medicine_types.name', 'like', '%' . $request->name . '%');
        }

        // Tìm kiếm theo trạng thái
        if ($request->filled('status')) {
            $query->where('medicine_types.status', $request->status);
        }

        // Phân trang
        $medicineType = $query->paginate(10)->appends($request->query());


        return view('System.medicineTypes.index', [
            'medicineType' => $medicineType
        ]);
    }


    public function store(MedicineTypeRequest $request)
    {
        $validatedData = $request->validated();
        $medicine = new MedicineType();
        $medicine->medicine_type_id = $request->input('code');
        $medicine->name = $request->input('name');
        $medicine->status = 1;

        $medicine->save();
        return response()->json(['success' => true, 'message' => 'Thêm thành công']);
    }

    public function edit($medicine_type_id)
    {
        $medicineType = MedicineType::where('medicine_type_id', $medicine_type_id)->first();
        return response()->json([
            'success' => true,
            'medicineType' => [
                'medicine_type_id' => $medicineType->medicine_type_id,
                'name' => $medicineType->name,
                'status' => $medicineType->status,
            ],
        ]);
    }


    public function update(UpdateMedicineTypeRequest $request, $row_id)
    {
        $type = MedicineType::where('medicine_type_id', $row_id)->first();
        $type->name = $request->input('name');
        $type->status = $request->input('status');
        $type->update();
        // dd($type);
        return response()->json(['success' => true, 'message' => 'Cập nhật thành công']);
    }
}