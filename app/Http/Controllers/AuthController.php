<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validate dữ liệu
        $request->validate([
            'username'      => 'required|string|min:6|max:255',
            'password'      => 'required|string|min:6|max:35',
            'repassword'    => 'required|string|same:password',
            'email'         => 'required|email|unique:user,email',
            'role'          => 'in:customer,admin',
            'sex'           => 'nullable|in:nam,nữ',
            'dob'           => 'nullable|date',
            'phone_number'  => 'nullable|string|max:10',
            'status'        => 'in:mở,khóa,đã xóa'
        ], [
            'username.required' => 'Vui lòng nhập tên đăng nhập.',
            'username.min'      => 'Tên đăng nhập phải ít nhất 6 ký tự.',
            'username.max'      => 'Tên đăng nhập không quá 255 ký tự.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min'      => 'Mật khẩu phải ít nhất 6 ký tự.',
            'password.max'      => 'Mật khẩu không quá 35 ký tự.',
            'repassword.same'   => 'Mật khẩu nhập lại không khớp với mật khẩu đã nhập.',
            'email.required'    => 'Vui lòng nhập email.',
            'email.email'       => 'Email không đúng định dạng.',
            'email.unique'      => 'Email này đã được sử dụng, vui lòng chọn email khác.',
            'phone_number'      => 'Số điện thoại phải 10 chữ số.'
        ]);

        // 2. Tạo user
        User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'email' => $request->email,
            'role' => $request->role ?? 'customer',
            'sex' => $request->sex,
            'dob' => $request->dob,
            'phone_number' => $request->phone_number,
            'status' => $request->status ?? 'mở',
        ]);

        // 3. Redirect sau khi thành công
        return redirect('/login')->with('success', 'Đăng ký thành công!');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    // thêm kiểm tra trạng thái tài khoảng
    // nhớ đăng nhập
    public function login(Request $request)
    {
        // Validate dữ liệu
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'password.required' => 'Vui lòng nhập mật khẩu'
        ]);

        // Kiểm tra đăng nhập
        if (Auth::attempt($credentials)) {
            // ĐĂNG NHẬP THÀNH CÔNG
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        // Đăng nhập thất bại - GIỮ LẠI DỮ LIỆU CŨ
        return back()
            ->withInput($request->only('email', 'password'))
            ->withErrors([
                'error' => 'Thông tin đăng nhập không chính xác.'
            ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
