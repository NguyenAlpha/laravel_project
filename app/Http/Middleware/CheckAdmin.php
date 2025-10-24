<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // kiểm tra đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Bạn cần đăng nhập');
        }

        $user = Auth::user();

        if($user->role != 'admin') {
            return back()->with('error', 'Bạn không có quyền truy cập trang này');
        }

        return $next($request);
    }
}
