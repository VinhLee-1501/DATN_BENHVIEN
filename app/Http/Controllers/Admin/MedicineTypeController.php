<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Medicine\MedicineTypeRequest;
use App\Models\MedicineType;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class MedicineTypeController extends Controller
{
    public function index()
    {
        $medicineType = MedicineType::orderBy('created_at', 'desc')->paginate(5);
        return view('System.medicineTypes.index', compact('medicineType'));

    }
    public function create(){
        return view('System.medicineTypes.create');
    }
    public function store(MedicineTypeRequest $request){
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
        $medicineType = MedicineType::where('medicine_type_id',$medicine_type_id)->first();
        return response()->json([
            'success' => true,
            'medicineType' => [
                'medicine_type_id' => $medicineType->medicine_type_id,
                'name' => $medicineType->name,
                'status' => $medicineType->status,
            ],
        ]);
    }


    public function update(Request $request, $row_id)
    {
        $type = MedicineType::where('medicine_type_id', $row_id)->first();
        // $type->medicine_type_id = $request->input('code');
        $type->name = $request->input('name');
        $type->status = $request->input('status');
        // dd($type->status);
        $type->update();
        // Log::info('JJJ', $type);
        // return redirect()->route('system.medicineType')->with('success', 'Cập nhật thành công.');
        return response()->json(['success' => true, 'message' => 'Cập nhật thành công']);
    }

    

}
