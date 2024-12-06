<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceDirectory;
use App\Http\Requests\Admin\Service\ServiceRequest;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{

    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 0);

        $serviceQuery = Service::with('serviceDirectoryForeignKey')
            ->orderBy('created_at', 'desc');
        if ($request->filled('name')) {
            $serviceQuery->where('services.name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('code_service')) {
            $serviceQuery->where('services.service_id', 'like', '%' . $request->code_order . '%');
        }

        if ($request->filled('price_from')) {
            $serviceQuery->where('orders.price', '>=', $request->price_from);
        }
        if ($request->filled('price_to')) {
            $serviceQuery->where('orders.price', '<=', $request->price_to);
        }
        if($request->filled('directory')) {
            $serviceQuery->where('services.directory_id', $request->directory);     
        }

        $service = $serviceQuery->clone()->where('services.status', 0)->paginate(10)->appends($request->query());

        $serviceInactive = $serviceQuery->clone()->where('services.status', 1)->paginate(10)->appends($request->query());
        return view('System.service.index', [
            'service' => $service,
            'service_inactive' => $serviceInactive,
            'activeTab' => $activeTab,
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


    public function store(ServiceRequest $request)
    {
        $service = new Service();
        $service->service_id = $request->input('code');
        $service->name = $request->input('name');
        $service->status = $request->input('status');
        $service->price = $request->input('price');
        $service->directory_id = $request->input('directory');
        $service->save();
        if ($service) {
            return response()->json(['success' => true, 'message' => 'Thêm dịch vụ thành công']);
        } else {
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


    public function update(ServiceRequest $request, $row_id)
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
        return redirect()->route('system.service')->with('success', 'Xóa dịch vụ thành công.');
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
