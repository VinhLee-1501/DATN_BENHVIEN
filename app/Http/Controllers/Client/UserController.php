<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\User\RegisterRequest;
use App\Http\Requests\Client\User\LoginRequest;
use App\Models\User;
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
            'email' =>  $request->input('email'),
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
    public function index()
    {

        return view('client.profile');
    }
}
