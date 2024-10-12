<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Medicine\CreateRequest;
use App\Models\MedicineType;

class MedicineController extends Controller
{
    public function index()
    {
        $medicine = Medicine::join('medicine_types', 'medicine_types.medicine_type_id', '=', 'medicines.medicine_type_id')
    ->select(
        'medicine_types.name as medicine_types_name',
        'medicines.medicine_id as medicine_id',
        'medicine_types.medicine_type_id as type_id',
        'medicines.name as name',
        'medicines.active_ingredient as active_ingredient',
        'medicines.unit_of_measurement as unit_of_measurement',
        'medicines.status as status',
        'medicines.medicine_type_id as medicine_type_id',
        'medicines.created_at as created_at',
        'medicines.updated_at as updated_at'
    )
    ->where('medicines.status',1)
    ->get();
    $medicineType = MedicineType::get();
        return view('System.medicines.index', [
            'medicine' => $medicine,
            'medicineType' => $medicineType
        ]);
    }

    public function end()
    {
        $medicine = Medicine::join('medicine_types', 'medicine_types.medicine_type_id', '=', 'medicines.medicine_type_id')
    ->select(
        'medicine_types.name as medicine_types_name',
        'medicines.medicine_id as medicine_id',
        'medicine_types.medicine_type_id as type_id',
        'medicines.name as name',
        'medicines.active_ingredient as active_ingredient',
        'medicines.unit_of_measurement as unit_of_measurement',
        'medicines.status as status',
        'medicines.medicine_type_id as medicine_type_id',
        'medicines.created_at as created_at',
        'medicines.updated_at as updated_at'
    )
    ->where('medicines.status',0)
    ->get();
    $medicineType = MedicineType::get();
    return view('System.medicines.index', [
        'medicine' => $medicine,
        'medicineType' => $medicineType
    ]);
    }


    public function create()
    {
        $medicineType = MedicineType::get();
        return view('System.medicines.create', compact('medicineType'));
    }
    public function store(CreateRequest $request)
    {
        $medicine = new Medicine();
        $medicine->medicine_id = $request->input('medicine_id');
        $medicine->medicine_type_id = $request->input('medicine_type_id');
        $medicine->name = $request->input('name');
        $medicine->active_ingredient = $request->input('active_ingredient');
        $medicine->unit_of_measurement = $request->input('unit_of_measurement');
        $medicine->status = 1;
        $medicine->save();
        return redirect()->route('system.medicine')->with('success', 'Thêm mới thành công.');
    }
    public function edit($medicine_id)
    {
        $medicineType = MedicineType::where('status', 1)->get();

        $medicine = Medicine::join('medicine_types', 'medicine_types.medicine_type_id', '=', 'medicines.medicine_type_id')
        ->select(
            'medicine_types.name as medicine_types_name',
            'medicines.medicine_id as medicine_id',
            'medicine_types.medicine_type_id as type_id',
            'medicines.name as name',
            'medicines.active_ingredient as active_ingredient',
            'medicines.unit_of_measurement as unit_of_measurement',
            'medicines.status as status',
            'medicines.medicine_type_id as medicine_type_id',
            'medicines.created_at as created_at',
            'medicines.updated_at as updated_at'
        )

        ->where('medicine_id',$medicine_id)->first();
        return view('System.medicines.edit', compact('medicineType','medicine'));
    }
    public function update(Request $request, $medicine_id)
    {

        $medicine = Medicine::findOrFail($medicine_id);
        $medicine->medicine_id = $request->input('medicine_id');
        $medicine->medicine_type_id = $request->input('medicine_type_id');
        $medicine->name = $request->input('name');
        $medicine->active_ingredient = $request->input('active_ingredient');
        $medicine->unit_of_measurement = $request->input('unit_of_measurement');
        $medicine->status = $request->input('status');
        $medicine->update();
        return redirect()->route('system.medicine')->with('success', 'Cập nhật thành công.');
    }

    public function delete($medicine_id)
    {
        // dd($medicine_id);
        $medicine = Medicine::findOrFail($medicine_id);
        $medicine->delete();
        return redirect()->route('system.medicine')->with('success', 'Xóa thành công.');
    }
}