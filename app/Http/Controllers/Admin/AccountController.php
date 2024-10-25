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
    public function index()
    {
        $users = User::where('role', 0)
            ->orderBy('users.row_id', 'desc')
            ->get();

        $admin = User::where('role', 1)
            ->orderby('row_id' , 'desc')
            ->get();

        $doctors = User::join('specialties', 'specialties.specialty_id', '=', 'users.specialty_id')
            ->where('role', 2)
            ->select('users.*', 'specialties.name as specialty_name')
            ->get();


        return view('System.accounts.index', compact('admin', 'doctors', 'users'));
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
//        // Lấy dữ liệu đã xác thực từ request
//        $validatedData = $request->validated();
//
//        // Tạo một đối tượng User mới
        $user = new User();
        // Kiểm tra role và gán specialty_id
        $role = $request->input('role');
        $specialtyId = $role == 2 ? $request->input('specialty_id') : null;


        // Gán các giá trị từ validated data vào thuộc tính của model
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
        return view('System.accounts.detail', compact('account' , 'specialties'));
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
            'firstname'   => $request->input('firstname'),
            'lastname'    => $request->input('lastname'),
            'role'        => $role,
            'email'       => $request->input('email'),
            'phone'       => $request->input('phone'),
            'specialty_id' => $specialtyId,
        ]);

        // Chuyển hướng về trang tài khoản với thông báo thành công
        return redirect()->route('system.account')->with('success', 'Cập nhật tài khoản thành công.');
    }







    public function destroy($user_id1)
    {
//        dd($user_id1);
        $users = User::where('user_id', $user_id1);
//        dd($users);

        $users->delete();
        return redirect()->route('system.account')->with('success', 'Xóa thành công');
    }


}
