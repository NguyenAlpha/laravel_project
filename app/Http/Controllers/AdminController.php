<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;   // dùng auth của Laravel
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login'); // view form login
    }

    public function login(Request $request)
    {
        // validate dữ liệu đầu vào
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // kiểm tra thông tin đăng nhập
        if (Auth::attempt([
            'username' => $request->username,
            'password' => $request->password
        ])) {
            // Nếu đúng → lưu session
            Session::put('admin', Auth::user());
            return redirect()->route('admin.dashboard');
        }

        // Nếu sai
        return back()->withErrors([
            'login_error' => 'Tên hoặc mật khẩu không chính xác',
        ]);
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function logout()
    {
        Auth::logout();
        Session::forget('admin');
        return redirect()->route('admin.login');
    }
//     public function checkUser($username, $password)
// {
//     $user_id = User_id::where('username', $username)->first();

//     if ($user_id && Hash::check($password, $user_id->password)) {
//         return $user_id; // Trả về thông tin user
//     }
    // return null;
}

