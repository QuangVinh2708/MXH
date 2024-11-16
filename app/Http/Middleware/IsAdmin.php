<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        // Kiểm tra xem người dùng có đăng nhập và có role_id = 2 (Admin)
        if (Auth::check() && Auth::user()->role_id == 2) {
            return $next($request);
        }

        // Nếu không phải Admin, chặn truy cập và báo lỗi 403
        abort(403, 'Bạn không có quyền truy cập.');
        return redirect('/home'); // Chuyển hướng nếu không phải admin
    }
}


