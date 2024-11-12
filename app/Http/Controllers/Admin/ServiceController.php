<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceDirectory;
use App\Http\Requests\Admin\Service\ValidationRequest;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{

    public function index(Request $request)
    {
        // Lấy giá trị tìm kiếm, nếu không có thì mặc định là rỗng
        $search = $request->input('search', '');

        // Lấy giá trị row_id để xóa, nếu có
        $delete = $request->input('row_id', []);

        // Kiểm tra và xử lý việc xóa
        if (!empty($delete)) {
            Service::whereIn('row_id', $delete)->delete();
            return redirect()->route('system.service')->with('success', 'Đã xóa các dịch vụ được chọn.');
        }

        // Số mục trên mỗi trang, mặc định là 5 nếu không có tham số trong request
        $itemsPerPage = $request->input('itemsPerPage', 5);

        // Xây dựng truy vấn tìm kiếm và phân trang
        $serviceQuery = Service::with('serviceDirectoryForeignKey')
            ->where('status', 0)
            ->orderBy('created_at', 'desc');

        // Nếu có từ khóa tìm kiếm, thêm vào điều kiện
        if ($search) {
            $serviceQuery->where('service_id', 'LIKE', "%$search%");
        }

        // Lấy kết quả phân trang và giữ lại tham số tìm kiếm và số lượng mục trên mỗi trang trong URL
        $service = $serviceQuery->paginate($itemsPerPage)->appends([
            'search' => $search, // Giữ lại tham số tìm kiếm trong URL phân trang
            'itemsPerPage' => $itemsPerPage // Giữ lại số mục trên mỗi trang trong URL phân trang
        ]);

        return view('System.service.index', [
            'service' => $service,
            'search' => $search
        ]);
    }


    public function indexinactive(Request $request)
    {

        $search = $request->input('search', '');

        $delete = $request->input('row_id', []);

        if (!empty($delete)) {
            Service::whereIn('row_id', $delete)->delete();
            return redirect()->route('system.service')->with('success', 'Đã xóa các dịch được chọn.');
        }

        $itemsPerPage = request()->input('itemsPerPage', 5);

        if ($search) {
            $service_inactive = Service::with('serviceDirectoryForeignKey')
                ->where('service_id', 'LIKE', "%$search%")
                ->where('status', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        } else {
            $service_inactive = Service::with('serviceDirectoryForeignKey')
                ->where('status', 1)
                ->orderBy('created_at', 'desc')
                ->paginate($itemsPerPage);
        }
        return view('System.service.index', [
            'service_inactive' => $service_inactive,
            'search' => $search
        ]);
    }

    public function resetsearch()
    {
        return redirect()->route('system.service');
    }


    public function create()
    {

        return view('System.service.create');
    }


    public function store(ValidationRequest $request)
    {
        $service = new Service();
        $service->service_id = $request->input('code');
        $service->name = $request->input('name');
        $service->status = $request->input('status');
        $service->price = $request->input('price');
        $service->directory_id = $request->input('directory');
        $service->save();
        if($service){
            return response()->json(['success' => true, 'message' => 'Thêm dịch vụ thành công']);
        }else{
            return response()->json(['error' => false, 'message' => 'Thêm dịch vụ thất bại']);
        }
        
    }
    public function edit($row_id)
    {
        $service = Service::with(['serviceDirectoryForeignKey' => function ($query) {
            $query->select('directory_id', 'name'); 
        }])->where('row_id', $row_id)->first();
        if (!$service) {
            return response()->json(['success' => false, 'message' => 'Dịch vụ không tồn tại.'], 404);
        }
        return response()->json([
            'success' => true,
            'service' => $service,
            'old_name' => $service->name 
        ]);

    }


    public function update(ValidationRequest $request, $row_id)
    {
        
        $service = Service::where('row_id', $row_id)->first();

        $service->name = $request->input('name');
        $service->price = $request->input('price');
        $service->directory_id = $request->input('directory');
        $service->status = $request->input('status');
      
        $service->update();

        return response()->json([
            'success' => true,
            'message' => 'Dịch vụ đã được cập nhật thành công.',
            'service' => $service 
        ]);
    }


    public function delete($row_id)
    {
        $service = Service::where('row_id', $row_id)->first();
        $service->delete();
        return redirect()->route('system.service')->with('success', 'Xóa thành công.');
    }

    // Kiểm tra lại controller của bạn
    public function listservice(Request $request)
    {
        $search = $request->input('searchItem');

        $query = ServiceDirectory::select('directory_id', 'name');


        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $categories = $query->paginate(10);

        return response()->json([
            'data' => $categories->items(), // Đảm bảo trả về 'data' thay vì 'items'
            'last_page' => $categories->lastPage(), // Trả về số trang cuối cùng
        ]);
    }
    public function checkDuplicateName(Request $request)
    {
        $name = $request->input('name');
        $exists = Service::where('name', $name)->exists();

        return response()->json(['exists' => $exists]);
    }
}
