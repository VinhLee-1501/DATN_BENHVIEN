<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceDirectory;
use App\Http\Requests\Admin\ServiceType\ServiceTypeRequest;
use App\Models\Service;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ServiceTypeController extends Controller
{

    public function index(Request $request)
    {
        $tab = $request->input('tab');
        $search = $request->input('search', '');
        $delete = $request->input('row_id', []);
        $directory_id = $request->input('directory_id', []);
        $itemsPerPage = $request->input('itemsPerPage', 5);



        if (!empty($delete)) {
            $serviceExists = Service::where('directory_id', $directory_id)
                ->whereNull('deleted_at')
                ->exists();

            if (!$serviceExists) {
                ServiceDirectory::whereIn('row_id', $delete)->delete();
                return redirect()->route('system.serviceType')->with('success', 'Xóa thành công.');
            }
            return redirect()->route('system.serviceType')->with('error', 'Không thể xóa nhóm dịch vụ này vì đã có dịch vụ thuộc nó.');
        }
    

        $serviceTypeQuery = ServiceDirectory::where('status', 0)
            ->orderBy('created_at', 'desc');

        if ($search && $tab == 0) {
            $serviceTypeQuery->where('name', 'LIKE', "%$search%");
        }

        $serviceType = $serviceTypeQuery->paginate($itemsPerPage)->appends([
            'search' => $search, 
            'itemsPerPage' => $itemsPerPage 
        ]);

        $serviceTypeInactiveQuery = ServiceDirectory::where('status', 1)
        ->orderBy('created_at', 'desc');

        // Nếu có từ khóa tìm kiếm, thêm vào điều kiện cho dịch vụ không hoạt động
        if ($search && $tab == 1) {
            $serviceTypeInactiveQuery->where('name', 'LIKE', "%$search%");
        }

        $serviceTypeInactive = $serviceTypeInactiveQuery->paginate($itemsPerPage)->appends([
            'search' => $search,
            'itemsPerPage' => $itemsPerPage
        ]);


        return view('System.serviceTypes.index', [
            'serviceType' => $serviceType,
            'serviceTypeInactive' => $serviceTypeInactive,
            'itemsPerPage' => $itemsPerPage,
            'search' => $search
        ]);
    }


    public function resetsearch()
    {
        return redirect()->route('system.serviceType');
    }


    public function create()
    {
        return view('System.serviceTypes.create');
    }


    public function store(ServiceTypeRequest $request)
    {
        $servicetype = new ServiceDirectory();
        $servicetype->directory_id = $request->input('code');
        $servicetype->name = $request->input('name');
        $servicetype->status = $request->input('status');;

        $servicetype->save();
        return response()->json(['success' => true, 'message' => 'Thêm mới nhóm dịch vụ thành công.']);
    }


    public function edit($row_id)
    {
        $servicetype = ServiceDirectory::find($row_id);

        if ($servicetype) {
            return response()->json([
                'success' => true,
                'servicetype' => $servicetype,
                'old_name' => $servicetype->name
            ]);
        } else {
            return response()->json(['success' => false], 404);
        }
    }


    public function update(ServiceTypeRequest $request, $row_id)
    {
        // Kiểm tra nếu dữ liệu ServiceDirectory với row_id đó có tồn tại không
        $servicetype = ServiceDirectory::where('row_id', $row_id)->first();

        if (!$servicetype) {
            // Nếu không tìm thấy thì trả về lỗi JSON (trong trường hợp gọi API)
            return response()->json(['error' => 'Nhóm dịch vụ không tồn tại.'], 404);
        }

        // Cập nhật thông tin
        $servicetype->name = $request->input('name');
        $servicetype->status = $request->input('status');

        // Lưu thông tin cập nhật
        $servicetype->update();

        // Trả về response JSON nếu sử dụng AJAX, hoặc có thể trả về redirect trong trường hợp không phải AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành công.'
            ]);
        }
        return response()->json(['success' => true, 'message' => 'Cập nhật nhóm dịch vụ thành công.']);
    }


    public function delete($row_id, $directory_id)
    {
        $serviceExists = Service::where('directory_id', $directory_id)
            ->whereNull('deleted_at')
            ->exists();
        if (!$serviceExists) {
            $servicetype = ServiceDirectory::where('row_id', $row_id)->first();
            $servicetype->delete();
            return redirect()->route('system.serviceType')->with('success', 'Xóa danh mục dich vụ thành công.');
        }
        return redirect()->back()->with('error', 'Không thể xóa nhóm dịch vụ này vì đã có dịch vụ thuộc nó.');
    }
}
