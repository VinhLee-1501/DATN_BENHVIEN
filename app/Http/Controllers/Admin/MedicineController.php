<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Medicine\CreateRequest;
use App\Http\Requests\Admin\Medicine\UpdateMedicineRequest;
use App\Models\MedicineType;

require_once resource_path('views/data/simple-html-dom.php');

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        // Khởi tạo query gốc
        $query = Medicine::leftjoin('medicine_types', 'medicine_types.medicine_type_id', '=', 'medicines.medicine_type_id')
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
                'medicines.price as price',
                'medicines.amount as amount',
                'medicines.updated_at as updated_at'
            )
            ->orderBy('medicines.row_id', 'desc');

        // Tìm kiếm theo tên thuốc
        if ($request->filled('name')) {
            $query->where('medicines.name', 'like', '%' . $request->name . '%');
        }

        // Tìm kiếm theo đơn vị đo
        if ($request->filled('unit_of_measurement')) {
            $query->where('medicines.unit_of_measurement', $request->unit_of_measurement);
        }

        // Tìm kiếm theo danh mục thuốc
        if ($request->filled('medicine_type_id')) {
            $query->where('medicines.medicine_type_id', $request->medicine_type_id);
        }

        // Phân trang cho thuốc hoạt động (status = 1)
        $medicine = $query->clone()
            ->where('medicines.status', 1)
            ->paginate(10)
            ->appends($request->query());

        // Phân trang cho thuốc hết hạn (status = 0)
        $medicineEnd = $query->clone()
            ->where('medicines.status', 0)
            ->paginate(10)
            ->appends($request->query());

        // Lấy danh sách đơn vị đo
        $unitOfMeasurements = Medicine::select('unit_of_measurement')
            ->distinct()
            ->pluck('unit_of_measurement');

        // Lấy danh sách danh mục thuốc
        $medicineTypes = MedicineType::all();

        return view('System.medicines.index', [
            'medicine' => $medicine,
            'medicineEnd' => $medicineEnd,
            'unitOfMeasurements' => $unitOfMeasurements,
            'medicineTypes' => $medicineTypes,  // Thêm danh mục thuốc
        ]);
    }





    public function create()
    {
        $medicineType = MedicineType::where('status', 1)->get();
        return response()->json(['medicineType' => $medicineType]);
    }
    public function store(CreateRequest $request)
    {
        // Lấy dữ liệu từ request
        $medicine_id = $request->input('medicine_id');
        $name = $request->input('name');
        $medicine_type_id = $request->input('medicine_type_id');
        $active_ingredient = $request->input('active_ingredient');
        $unit_of_measurement = $request->input('unit_of_measurement');
        $price = $request->input('price');  // Giá thuốc
        $amount = $request->input('amount');  // Số lượng

        // Kiểm tra các trường không bị trống (ngoại trừ medicine_id)
        if (!$name || !$medicine_type_id || !$active_ingredient || !$unit_of_measurement || !$price || !$amount) {
            return response()->json(['error' => true, 'message' => 'Vui lòng điền đầy đủ thông tin.']);
        }

        // Tạo đối tượng Medicine và lưu thông tin
        $medicine = new Medicine();
        $medicine->medicine_id = $medicine_id;
        $medicine->medicine_type_id = $medicine_type_id;
        $medicine->name = $name;
        $medicine->active_ingredient = $active_ingredient;
        $medicine->unit_of_measurement = $unit_of_measurement;
        $medicine->price = $price;  // Lưu giá thuốc
        $medicine->amount = $amount;  // Lưu số lượng
        $medicine->status = 1;  // Trạng thái thuốc (có thể là 1: còn hàng)

        // Lưu thông tin vào cơ sở dữ liệu
        $medicine->save();

        return response()->json(['success' => true, 'message' => 'Thuốc đã được thêm thành công']);
    }



    public function edit($medicine_id)
    {
        // Lấy thông tin nhóm thuốc
        $medicineType = MedicineType::where('status', 1)->get();

        // Lấy thông tin thuốc từ cơ sở dữ liệu
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
                'medicines.price as price',
                'medicines.amount as amount',
                'medicines.created_at as created_at',
                'medicines.updated_at as updated_at'
            )
            ->where('medicine_id', $medicine_id)
            ->first();

        // Nếu không tìm thấy thuốc, trả về thông báo lỗi
        if (!$medicine) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy thuốc.']);
        }

        return response()->json([
            'success' => true,
            'medicine' => $medicine,
            'medicineType' => $medicineType,
        ]);
    }

    public function update(UpdateMedicineRequest $request, $medicine_id)
    {
        $medicine = Medicine::find($medicine_id);

        if (!$medicine) {
            return response()->json(['success' => false, 'error' => 'Không tìm thấy thuốc.'], 404);
        }

        // Cập nhật thông tin thuốc
        $medicine->name = $request->input('name');
        $medicine->medicine_type_id = $request->input('medicine_type_id');
        $medicine->status = $request->input('status');
        $medicine->active_ingredient = $request->input('active_ingredient');
        $medicine->unit_of_measurement = $request->input('unit_of_measurement');
        $medicine->price = $request->input('price');
        $medicine->amount = $request->input('amount');

        $medicine->save();

        return response()->json(['success' => true, 'message' => 'Cập nhật thành công']);
    }

    public function delete($medicine_id)
    {
        // dd($medicine_id);
        $medicine = Medicine::findOrFail($medicine_id);
        $medicine->delete();
        return redirect()->route('system.medicine')->with('success', 'Xóa thành công.');
    }
}
