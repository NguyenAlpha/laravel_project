<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra xem user có đăng nhập không
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Bạn cần đăng nhập để tiếp tục');
        }

        $user = Auth::user();

        // Nếu là admin mà cố truy cập trang khách hàng, chuyển hướng về trang admin
        if ($user->role == 'admin' || $user->role == 'superadmin') {
            return back()->with('error', 'Admin không thể truy cập trang khách hàng');
        }

        return $next($request);
    }
}
