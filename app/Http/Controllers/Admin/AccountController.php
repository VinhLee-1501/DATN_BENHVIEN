<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Account\AccountRequest;
use App\Models\Specialty;
use App\Models\User;


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

    public function store(AccountRequest $request)
    {
        // Lấy dữ liệu đã xác thực từ request
        $validatedData = $request->validated();

        // Tạo một đối tượng User mới
        $user = new User();

        // Gán các giá trị từ validated data vào thuộc tính của model
        $user->user_id = $request->input('userid');
        $user->role = $validatedData['role'];
        $user->email = $validatedData['email'];
        $user->phone = $validatedData['phone'];
        $user->password = bcrypt($validatedData['password']); // Mã hóa mật khẩu
        $user->firstname = $validatedData['firstname'];
        $user->lastname = $validatedData['lastname'];
        $user->specialty_id = $request->input('specialty');

        // Lưu vào cơ sở dữ liệu
        $user->save();

        // Chuyển hướng về trang danh sách với thông báo thành công
        return redirect()->route('system.account')->with('success', 'Thêm tài khoản thành công.');
    }




    public function edit($user_id)
    {
//        dd($user_id);
        $account = User::where('user_id', $user_id)->get();
//

        return view('System.accounts.detail', compact('account'));
    }


    public function update(AccountRequest $request, $user_id)
    {
        // Lấy dữ liệu đã được xác thực từ request
        $validatedData = $request->validated();

        // Tìm người dùng cần cập nhật
        $user = User::where('user_id', $user_id)->first();

        // Nếu không tìm thấy người dùng, trả về thông báo lỗi
        if (!$user) {
            return redirect()->route('system.account')->with('error', 'Người dùng không tồn tại!');
        }

        // Chỉ cập nhật nếu các trường đã thay đổi
        if ($user->email !== $validatedData['email']) {
            $user->email = $validatedData['email'];
        }

        if ($user->phone !== $validatedData['phone']) {
            $user->phone = $validatedData['phone'];
        }

        if ($user->role !== $validatedData['role']) {
            $user->role = $validatedData['role'];
        }

        if ($user->firstname !== $validatedData['firstname']) {
            $user->firstname = $validatedData['firstname'];
        }

        if ($user->lastname !== $validatedData['lastname']) {
            $user->lastname = $validatedData['lastname'];
        }

        // Cập nhật mật khẩu nếu người dùng nhập mật khẩu mới
        if ($request->filled('password')) {
            $user->password = bcrypt($validatedData['password']);
        }

        // Lưu thay đổi
        $user->save();

        return redirect()->route('system.account')->with('success', 'Tài khoản đã được cập nhật thành công!');
    }



    public function destroy($user_id)
    {
        $users = User::where('user_id', $user_id);
        $users->delete();
        return redirect()->route('system.account')->with('success', 'Xóa thành công');
    }





}
