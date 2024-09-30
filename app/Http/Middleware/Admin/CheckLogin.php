<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->role) {
                return $next($request);
            } else {
                return redirect()->route('system.auth.login')
                    ->with('warning', 'Tài khoản thành viên không có quyền truy cập. Cố ý truy cập sẽ bị khóa tài khoản');
            }
        }   

        return redirect()->route('system.auth.login')
            ->with('warning', 'Vui lòng đăng nhập tài khoản');
    }
}
