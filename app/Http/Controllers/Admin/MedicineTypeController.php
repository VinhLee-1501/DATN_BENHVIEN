<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Medicine\MedicineTypeRequest;
use App\Models\MedicineType;

class MedicineTypeController extends Controller
{
    public function index()
    {
        $medicineType = MedicineType::get();
        return view('System.medicineTypes.index', compact('medicineType'));

    }
    public function create(){
        return view('system.medicineTypes.create');
    }
    public function store(MedicineTypeRequest $request){
        $validatedData = $request->validated();
        $medicine = new MedicineType();
            $medicine->medicine_type_id = $request->input('code');
            $medicine->name = $request->input('name');
            $medicine->status = 1;

            $medicine->save();
            return redirect()->route('system.medicineType')->with('success', 'Thêm mới thành công.');
    }
    public function edit($medicine_type_id)
    {
        $medicine = MedicineType::where('medicine_type_id',$medicine_type_id)->first();
        return view('system.medicineTypes.edit', compact( 'medicine'));
    }

    public function update(MedicineTypeRequest $request, $row_id)
    {
        $type = MedicineType::findOrFail($row_id);
        $type->fill($request->all());
        $type->update();
        // dd($type);
        return redirect()->route('system.medicineType')->with('success', 'Cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */

}
