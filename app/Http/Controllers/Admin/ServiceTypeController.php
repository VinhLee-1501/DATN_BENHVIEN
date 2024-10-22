<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceDirectory;
use App\Http\Requests\Admin\Blog\ValidationRequest;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ServiceTypeController extends Controller{

    public function index(Request $request)
    {
    
        $search = $request->input('search', '');

        $delete = $request->input('service_type_id', []);

        if (!empty($delete)) {
            ServiceDirectory::whereIn('id', $delete)->delete();
            return redirect()->route('system.serviceType')->with('success', 'Đã xóa các bài viết được chọn.');
        }

        $itemsPerPage = request()->input('itemsPerPage', 5);

        if ($search) {
            $serviceType = ServiceDirectory::where('name', 'LIKE', "%$search%")
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        } else {
            $serviceType = ServiceDirectory::orderBy('created_at', 'desc')->paginate($itemsPerPage);
        }

        return view('System.serviceTypes.index', [
            'serviceType' => $serviceType,
            'search' => $search
        ]);
    }

    public function resetsearch()
    {
        return redirect()->route('system.serviceType');
    }

    public function create() {
        return view('System.serviceTypes.create');
    }
    public function store(Request $request){
        $servicetype = new ServiceDirectory();
        $servicetype->directory_id = $request->input('code');
        $servicetype->name = $request->input('name');
        $servicetype->status = $request->input('status');;

        $servicetype->save();
        // return redirect()->route('system.medicineType')->with('success', 'Thêm mới thành công.');
    }
    public function edit($servicetype_id) {
        $servicetype = ServiceDirectory::where('directory_id', $servicetype_id)->first();
        return view('system.serviceTypes.edit', compact('service'));
    }
}