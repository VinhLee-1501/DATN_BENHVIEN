<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Medicine\CreateRequest;
use App\Models\MedicineType;

require_once resource_path('views/data/simple-html-dom.php');

class MedicineController extends Controller
{
    public function index()
    {
        // Lấy nội dung HTML từ trang web
        $content = file_get_html('http://benhvientimmachangiang.vn/Thu%E1%BB%91c-DVYT-BYT/Danh-m%E1%BB%A5c-Thu%E1%BB%91c-VTYTTH/Danh-m%E1%BB%A5c-thu%E1%BB%91c-N%E1%BB%99i-tr%C3%BA');
        $rows = $content->find('tr');

        // Mảng lưu trữ các tên thuốc và đơn vị đã xuất hiện
        $unique_medicine_names = [];
        $unique_units = [];

        // Bỏ qua 8 hàng đầu tiên nếu không cần thiết
        $rows = array_slice($rows, 8);

        foreach ($rows as $row) {
            // Tìm tất cả các ô trong hàng
            $cells = $row->find('td');

            // Kiểm tra nếu ô chứa tên thuốc (ô thứ 5)
            if (isset($cells[4]) && trim($cells[4]->plaintext) !== '&nbsp;' && !empty(trim($cells[4]->plaintext))) {
                // Lấy và xử lý tên thuốc
                $medicine_name = trim($cells[4]->plaintext);
                $medicine_name = str_replace('&nbsp;', '', $medicine_name);

                // Kiểm tra nếu tên thuốc chưa tồn tại trong mảng
                if (!in_array($medicine_name, $unique_medicine_names)) {
                    // Thêm tên thuốc vào mảng
                    $unique_medicine_names[] = $medicine_name;

                    // Kiểm tra và lấy đơn vị từ ô thứ 11 nếu có
                    if (isset($cells[10])) {
                        $units = trim($cells[10]->plaintext);

                        // Chuyển đơn vị thành chữ thường để tránh trùng lặp do phân biệt hoa thường
                        $units_lowercase = strtolower($units);

                        // Kiểm tra nếu đơn vị chưa tồn tại trong mảng
                        if (!in_array($units_lowercase, $unique_units)) {
                            // Thêm đơn vị vào mảng và hiển thị
                            $unique_units[] = $units_lowercase;
                        }
                    }
                }
            }
        }


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
            ->where('medicines.status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        $medicineType = MedicineType::get();
        return view('System.medicines.index', [
            'medicine' => $medicine,
            'medicineType' => $medicineType,
            'unique_medicine_names' => $unique_medicine_names,
            'unique_units' => $unique_units
        ]);
    }

    public function end()
    {
        $content = file_get_html('http://benhvientimmachangiang.vn/Thu%E1%BB%91c-DVYT-BYT/Danh-m%E1%BB%A5c-Thu%E1%BB%91c-VTYTTH/Danh-m%E1%BB%A5c-thu%E1%BB%91c-N%E1%BB%99i-tr%C3%BA');
        $rows = $content->find('tr');

        // Mảng lưu trữ các tên thuốc và đơn vị đã xuất hiện
        $unique_medicine_names = [];
        $unique_units = [];

        // Bỏ qua 8 hàng đầu tiên nếu không cần thiết
        $rows = array_slice($rows, 8);

        foreach ($rows as $row) {
            // Tìm tất cả các ô trong hàng
            $cells = $row->find('td');

            // Kiểm tra nếu ô chứa tên thuốc (ô thứ 5)
            if (isset($cells[4]) && trim($cells[4]->plaintext) !== '&nbsp;' && !empty(trim($cells[4]->plaintext))) {
                // Lấy và xử lý tên thuốc
                $medicine_name = trim($cells[4]->plaintext);
                $medicine_name = str_replace('&nbsp;', '', $medicine_name);

                // Kiểm tra nếu tên thuốc chưa tồn tại trong mảng
                if (!in_array($medicine_name, $unique_medicine_names)) {
                    // Thêm tên thuốc vào mảng
                    $unique_medicine_names[] = $medicine_name;

                    // Kiểm tra và lấy đơn vị từ ô thứ 11 nếu có
                    if (isset($cells[10])) {
                        $units = trim($cells[10]->plaintext);

                        // Chuyển đơn vị thành chữ thường để tránh trùng lặp do phân biệt hoa thường
                        $units_lowercase = strtolower($units);

                        // Kiểm tra nếu đơn vị chưa tồn tại trong mảng
                        if (!in_array($units_lowercase, $unique_units)) {
                            // Thêm đơn vị vào mảng và hiển thị
                            $unique_units[] = $units_lowercase;
                        }
                    }
                }
            }
        }
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
            ->where('medicines.status', 0)
            ->orderBy('created_at', 'desc')->paginate(5);
        $medicineType = MedicineType::get();
        return view('System.medicines.index', [
            'medicine' => $medicine,
            'medicineType' => $medicineType,
            'unique_medicine_names' => $unique_medicine_names,
            'unique_units' => $unique_units
        ]);
    }


    public function create()
    {
        $medicineType = MedicineType::where('status', 1)->get();
        return response()->json(['medicineType' => $medicineType]);
    }
    public function store(CreateRequest $request)
    {
        $medicineType = MedicineType::where('status', 1)->get();
        $medicine = new Medicine();
        $medicine->medicine_id = $request->input('medicine_id');
        $medicine->medicine_type_id = $request->input('medicine_type_id');
        $medicine->name = $request->input('name');
        $medicine->active_ingredient = $request->input('active_ingredient');
        $medicine->unit_of_measurement = $request->input('unit_of_measurement');
        $medicine->status = 1;
        $medicine->save();

        return response()->json(['success' => true, 'message' => 'Thuốc đã được thêm thành công']);
    }

    public function edit($medicine_id)
    {
        $medicineType = MedicineType::where('status', 1)->get();

        // dd($medicineType);
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
            ->where('medicine_id', $medicine_id)->first();

        // Kiểm tra nếu có thuốc không
        if (!$medicine) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy thuốc.']);
        }

        return response()->json([
            'success' => true,
            'medicine' => $medicine,
            'medicineType' => $medicineType,
        ]);
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
