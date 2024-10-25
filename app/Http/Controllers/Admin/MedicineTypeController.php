<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Medicine\MedicineTypeRequest;
use App\Models\MedicineType;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

require_once resource_path('views/data/simple-html-dom.php');
class MedicineTypeController extends Controller
{
    public function index()
    {
        $content = file_get_html('http://benhvientimmachangiang.vn/Thu%E1%BB%91c-DVYT-BYT/Danh-m%E1%bb%A5c-Thu%E1%BB%91c-VTYTTH/Danh-m%E1%bb%A5c-thu%E1%BB%91c-N%E1%BB%99i-tr%C3%BA');

        // Tìm tất cả các hàng trong bảng
        $rows = $content->find('tr');

        // Mảng để lưu trữ danh mục thuốc đã xuất hiện
        $unique_categories = [];

        // Duyệt qua từng hàng để lấy danh mục
        foreach ($rows as $row) {
            // Tìm tất cả các ô trong hàng
            $cells = $row->find('td');
        
            // Kiểm tra nếu ô chứa danh mục
            if (count($cells) > 0 && isset($cells[2]) && stripos($cells[2]->plaintext, 'THUỐC') !== false) {
                // Lấy danh mục từ ô chứa
                $current_category = trim($cells[2]->plaintext);
        
                // Xóa từ "THUỐC" ở đầu chuỗi
                $current_category = preg_replace('/^THUỐC\s*/i', '', $current_category);
        
                // Xóa chuỗi "&nbsp;"
                $current_category = str_replace('&nbsp;', '', $current_category);
        
                // Thêm danh mục vào mảng nếu chưa có
                if (!in_array($current_category, $unique_categories)) {
                    $unique_categories[] = $current_category;
                }
            }
        }
        
        $medicineType = MedicineType::orderBy('created_at', 'desc')->paginate(5);
        return view('System.medicineTypes.index', [
            'medicineType' => $medicineType,
            'unique_categories' => $unique_categories
        ]);
    }
    public function create() {}
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
