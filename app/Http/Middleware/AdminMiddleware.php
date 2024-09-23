<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra xem người dùng có đăng nhập hay không
        if (Auth::check()) {
            // Kiểm tra quyền admin của người dùng
            if (Auth::user()->role !== 'admin') {
                // Nếu không phải admin, chuyển hướng
                return redirect()->route('welcome');
            }

            // Nếu admin, tiếp tục yêu cầu
            return $next($request);
        }

        // Nếu không đăng nhập, chuyển hướng đến trang login
        return redirect()->route('login');
    }
}
