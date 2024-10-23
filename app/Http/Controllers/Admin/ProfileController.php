<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Profile\UpdateProfileRequest;
use App\Http\Requests\Admin\Profile\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Specialty;
use Illuminate\Support\Facades\Hash;
use Psy\Command\WhereamiCommand;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Lấy tất cả các chuyên khoa từ cơ sở dữ liệu
        $specialties = Specialty::all();

        return view('System.profile.index', [
            'specialties' => $specialties,
            'user' => $user, // Truyền thông tin người dùng để sử dụng trong view
        ]);
    }
    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('system.auth.login')->with('error', 'Bạn cần phải đăng nhập để cập nhật hồ sơ.');
        }

        $oldPhone = $user->phone;

        // Lấy specialty_id từ request
        $specialty_id = $request->input('specialty_id');

        // Cập nhật thông tin người dùng
        $updatedUser = $user->update([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'birthday' => $request->input('birthday'),
            'specialty_id' => $specialty_id,  // sử dụng specialty_id từ request
        ]);

        // Kiểm tra cập nhật thành công
        if (!$updatedUser) {
            return redirect()->back()->withErrors(['update' => 'Không thể cập nhật thông tin.']);
        }

        // Cập nhật thông tin bệnh nhân nếu số điện thoại thay đổi
        if ($oldPhone !== $request->input('phone')) {
            $patient = $user->patient;
            if ($patient) {
                $patient->update(['phone' => $request->input('phone')]);
            }
        }

        return redirect()->route('system.profile')->with('success', 'Cập nhật thông tin thành công');
    }


    public function changePasswordForm()
    {
        return view('System.profile.changepassword');
    }
    public function changePassword(ChangePasswordRequest $request)
    {

        $user = Auth::user();


        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
        }


        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors(['new_password' => 'Mật khẩu mới không được giống với mật khẩu cũ.']);
        }


        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Thay đổi mật khẩu thành công');
    }
}
