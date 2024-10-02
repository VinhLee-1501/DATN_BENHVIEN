<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\UserInterface;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialLoginController extends Controller
{
    protected UserInterface $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // Lấy thông tin người dùng từ Google
            $user = Socialite::driver('google')->user();

            if (!$user) {
                throw new Exception('Unable to get user information from Google.');
            }

            $googleId = $user->id ?? null;
            $email = $user->email ?? null;
            $name = $user->name ?? 'Unknown';
            $avatar = $user->avatar ?? '';


            $nameParts = explode(' ', $name);
            $firstname = array_shift($nameParts);
            $lastname = implode(' ', $nameParts);

            $phone = '0' . rand(100000000, 999999999);


            $finduser = User::where('google_id', $googleId)->first();

            if ($finduser) {
                Auth::login($finduser);
                return redirect()->route('client.profile.index')->with('success', 'Đăng nhập thành công');
            } else {

                $newUser = User::updateOrCreate(['email' => $email], [
                    'user_id' =>  $this->generateUserId(),
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'avatar' => $avatar,
                    'google_id' => $googleId,
                    'remember_token' => Str::random(30),
                    'email_verified_at' => now(),
                    'password' => Hash::make('123456'),
                    'phone' => $phone,
                ]);

                Auth::login($newUser);
                return redirect()->route('client.profile.index')->with('success', 'Đăng nhập thành công');
            }
        } catch (Exception $e) {
            dd('Error:', $e->getMessage());
        }
    }
    protected function generateUserId()
    {
        return strtoupper(Str::random(10)); // Chuỗi 10 ký tự ngẫu nhiên
    }



    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {

            $user = Socialite::driver('facebook')->user();

            if (!$user) {
                throw new Exception('Unable to get user information from Facebook.');
            }


            $facebookId = $user->id ?? null;
            $email = $user->email ?? null;
            $name = $user->name ?? 'Unknown';
            $avatar = $user->avatar ?? '';


            $nameParts = explode(' ', $name);
            $firstname = array_shift($nameParts);
            $lastname = implode(' ', $nameParts);


            $phone = '0' . rand(100000000, 999999999);


            $finduser = User::where('facebook_id', $facebookId)->first();

            if ($finduser) {
                Auth::login($finduser);
                return redirect()->route('client.profile.index')->with('success', 'Đăng nhập thành công');
            } else {

                $newUser = User::updateOrCreate(['email' => $email], [
                    'user_id' => $this->generateUserId(),
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'avatar' => $avatar,
                    'facebook_id' => $facebookId,
                    'remember_token' => Str::random(30),
                    'email_verified_at' => now(),
                    'password' => Hash::make('123456'),
                    'phone' => $phone,
                ]);

                Auth::login($newUser);
                return redirect()->route('client.profile.index')->with('success', 'Đăng nhập thành công');
            }
        } catch (Exception $e) {
            dd('Error:', $e->getMessage());
        }
    }
    public function redirectToZalo()
    {
        return Socialite::driver('zalo')->redirect();
    }

    public function handleZaloCallback()
    {
        try {
            // Sử dụng driver 'zalo' để lấy thông tin người dùng
            $user = Socialite::driver('zalo')->user();

            if (!$user) {
                throw new Exception('Unable to get user information from Zalo.');
            }

            $zaloId = $user->id ?? null;
            $email = $user->email ?? $zaloId . '@gmail.com'; // Tạo email từ zalo_id nếu email không tồn tại
            $name = $user->name ?? 'Unknown';
            $avatar = $user->avatar ?? '';

            $nameParts = explode(' ', $name);
            $firstname = array_shift($nameParts);
            $lastname = implode(' ', $nameParts);

            $phone = '0' . rand(100000000, 999999999);

            $finduser = User::where('zalo_id', $zaloId)->first();

            if ($finduser) {
                Auth::login($finduser);
                return redirect()->route('client.profile.index')->with('success', 'Đăng nhập thành công');
            } else {
                // Tạo hoặc cập nhật người dùng với thông tin mới
                $newUser = User::updateOrCreate(['email' => $email], [
                    'user_id' => $this->generateUserId(),
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'avatar' => $avatar,
                    'zalo_id' => $zaloId,
                    'remember_token' => Str::random(30),
                    'email_verified_at' => now(),
                    'password' => Hash::make('123456'),
                    'phone' => $phone,
                ]);

                Auth::login($newUser);
                return redirect()->route('client.profile.index')->with('success', 'Đăng nhập thành công');
            }
        } catch (Exception $e) {
            dd('Error:', $e->getMessage());
        }
    }
}
