<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicineType;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Medicine\CreateRequest;
class MedicineTypeController extends Controller
{
    public function index()
    {
        $medicineType = MedicineType::get();
        return view('Admin.medicineTypes.index', compact('medicineType'));

    }
    public function create(){
        return view('admin.medicineTypes.create');
    }
    public function store(CreateRequest $request){
        $validatedData = $request->validated();
        $medicine = new MedicineType();
            $medicine->medicine_type_id = $request->input('code');
            $medicine->name = $request->input('name');
            $medicine->status = 1;

            $medicine->save();
            return redirect()->route('admin.medicineType')->with('success', 'Thêm mới thành công.');
    }
    public function edit($medicine_type_id)
    {
        $medicine = MedicineType::where('medicine_type_id',$medicine_type_id)->first();
        return view('admin.medicineTypes.edit', compact( 'medicine'));
    }
    public function update(Request $request, $row_id)
    {
        $type = MedicineType::findOrFail($row_id);
        $type->fill($request->all());
        $type->update();
        // dd($type);
        return redirect()->route('admin.medicineType')->with('success', 'Cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($row_id)
    {
        dd($row_id);
        $category = MedicineType::findOrFail($row_id);
        $category->delete();

        return redirect()->route('admin.medicineTypes')->with('success', 'Thêm mới thành công.');
    }
}