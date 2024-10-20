<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\User\RegisterRequest;
use App\Http\Requests\Client\User\LoginRequest;
use App\Http\Requests\Client\User\UpdateProfileRequest;
use App\Http\Requests\Client\User\ChangePasswordRequest;
use App\Models\User;
use App\Models\Book;
use App\Models\Specialty;
use App\Repositories\User\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class UserController extends Controller
{
    protected UserInterface $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function register()
    {
        $showPopup = 'register';
        return view('client.index', ['showPopup' => $showPopup]);
    }

    public function handleRegister(RegisterRequest $request)
    {
        $validatedData = $request->validated();

        $users = $this->userRepository->create([
            'user_id' => $this->generateUserId(), // Tạo user_id random
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'avatar' => 'https://topcode.vn/assets/images/avanta2.png',
            'email_verified_at' => now(),
        ]);

        if ($users) {
            return redirect()->route('client.register')->with('success', 'Đăng ký thành công!');
        } else {
            return redirect()->route('client.register')->with('error', 'Đăng ký thất bại. Vui lòng thử lại.');
        }
    }
    protected function generateUserId()
    {
        return strtoupper(Str::random(10)); // Chuỗi 10 ký tự ngẫu nhiên
    }
    public function login()
    {

        $showPopup = 'login';
        return view('client.index', ['showPopup' => $showPopup]);
    }

    public function authenticateLogin(LoginRequest $request)
    {
        $credentials = [
            'phone' =>  $request->input('phone'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials)) {
            if (!empty(Auth::user()->email_verified_at)) {
                $request->session()->regenerate();

                return redirect()->route('client.profile.index')->with('success', 'Đăng nhập thành công');
            }
        }
        return redirect()->back()
            ->with('error', 'Email hoặc mật khẩu không chinh xác');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('client.login')->with('success', 'Đăng xuất thành công');
    }
    public function index(Request $request)
    {
        $userId = Auth::user()->user_id;


        $medicalHistory = Book::where('user_id', $userId)->get();

        foreach ($medicalHistory as $history) {
            $history->specialty = Specialty::where('specialty_id', $history->specialty_id)
                ->where('status', 1)
                ->first();
        }

        return view('client.profile', [
            'userId' => $userId,
            'medicalHistory' => $medicalHistory,
        ]);
    }
    public function updateProfile(UpdateProfileRequest $request)
    {

        $user = Auth::user();


        if (!$user) {
            return redirect()->route('client.login')->with('error', 'Bạn cần phải đăng nhập để cập nhật hồ sơ.');
        }


        $oldPhone = $user->phone;


        $updatedUser = $user->update([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'), // Cập nhật email
            'birthday' => $request->input('birthday'),
        ]);


        if ($updatedUser && $oldPhone !== $request->input('phone')) {
            $patient = $user->patient;
            if ($patient) {
                $patient->update(['phone' => $request->input('phone')]);
            }
        }


        return $updatedUser
            ? redirect()->route('client.profile.index')->with(['info_success' => 'Cập nhật hồ sơ thành công!', 'activeTab' => 'update_info'])
            : redirect()->route('client.profile.index')->with(['info_error' => 'Cập nhật hồ sơ thất bại, vui lòng thử lại.', 'activeTab' => 'update_info']);
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

        return back()->with('change_password_success', 'Thay đổi mật khẩu thành công')->with('activeTab', 'change_password');
    }
}
