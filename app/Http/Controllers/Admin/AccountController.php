<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Account\AccountRequest;
use App\Http\Requests\Admin\Account\EditAccountRequest;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        // Truy vấn người dùng với status = 1
        $usersQuery = User::where('status', 1);

        // Tìm kiếm theo họ
        if ($request->filled('firstname')) {
            $usersQuery->where('firstname', 'like', '%' . $request->firstname . '%');
        }

        // Tìm kiếm theo tên
        if ($request->filled('lastname')) {
            $usersQuery->where('lastname', 'like', '%' . $request->lastname . '%');
        }

        // Tìm kiếm theo số điện thoại
        if ($request->filled('phone')) {
            $usersQuery->where('phone', 'like', '%' . $request->phone . '%');
        }

        // Lấy giá trị tab từ query string nếu có
        $activeTab = $request->query('tab', 'nav-home'); // Tab mặc định là 'nav-home'

        // Truy vấn người dùng có role = 0 (Người dùng)
        $users = clone $usersQuery; // Tạo bản sao của truy vấn
        $users = $users->where('role', 0)->orderBy('row_id', 'desc')->paginate(10)->appends($request->query());

        // Truy vấn admin có role = 1 (Quản trị)
        $admin = clone $usersQuery; // Tạo bản sao của truy vấn
        $admin = $admin->where('role', 1)->orderBy('row_id', 'desc')->paginate(10)->appends($request->query());

        // Truy vấn người dùng có role = 0 (Người dùng)
        $staff = clone $usersQuery; // Tạo bản sao của truy vấn
        $staff = $staff->where('role', 3)->orderBy('row_id', 'desc')->paginate(10)->appends($request->query());

        return view('System.accounts.index', compact('users', 'admin', 'staff' ,'activeTab'));
    }


    public function create()
    {
        $users = user::all();
        $specialties = specialty::all();

        return view('System.accounts.create', compact('users', 'specialties'));
    }
    //
    public function store(AccountRequest $request)
    {

        $user = new User();
        $role = $request->input('role');
        $specialtyId = $role == 2 ? $request->input('specialty_id') : null;


        $user->user_id = $request->input('userid');
        $user->role = $request->input('role');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->password = bcrypt($request->input('password')); // Mã hóa mật khẩu
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->specialty_id = $specialtyId;


        $user->save();
        return redirect()->route('system.account')->with('success', 'Thêm tài khoản thành công.');
    }




    public function edit($user_id)
    {

        // Join bảng users với bảng specialties
        $account = User::where('users.user_id', $user_id)
            ->first(); // Lấy bản ghi đầu tiên
        $specialties = specialty::all();
        // Nếu không tìm thấy tài khoản, trả về thông báo lỗi
        if (!$account) {
            return redirect()->route('system.account')->with('error', 'Tài khoản không tồn tại!');
        }
        // Trả về view với thông tin account
        return view('System.accounts.detail', compact('account', 'specialties'));
    }




    public function update(EditAccountRequest $request, $user_id)
    {
        // Tìm user theo user_id
        $user = User::where('user_id', $user_id)->firstOrFail();

        // Kiểm tra xem mật khẩu mới có được nhập không
        if ($request->filled('password')) {
            // Nếu có mật khẩu mới, mã hóa nó
            $user->password = bcrypt($request->input('password'));
        }

        // Kiểm tra role và gán specialty_id
        $role = $request->input('role');
        $specialtyId = $role == 2 ? $request->input('specialty_id') : null;

        // Cập nhật các trường khác từ request vào user
        $user->update([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'role' => $role,
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'specialty_id' => $specialtyId,
        ]);

        // Chuyển hướng về trang tài khoản với thông báo thành công
        return redirect()->route('system.account')->with('success', 'Cập nhật tài khoản thành công.');
    }







    public function destroy($user_id1)
    {
        $users = User::where('user_id', $user_id1);

        $users->delete();
        return redirect()->route('system.account')->with('success', 'Xóa thành công');
    }
}