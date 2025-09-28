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
            'phone_number'  => 'required|string|max:10',
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

        // Tìm user theo email và kiểm tra trạng thái trước
        $user = User::where('email', $credentials['email'])->first();

        if ($user && in_array($user->status, ['khóa', 'đã xóa'])) {
            return back()
                ->withInput($request->only('email', 'password'))
                ->withErrors([
                    'error' => 'Tài khoản này đã bị vô hiệu hóa.'
                ]);
        }

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

    public function showProfile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    public function update(Request $request, $user_id)
    {
        // validate thông tin cập nhật
        $request->validate([
            'username'      => 'required|string|min:6|max:255',
            'email'         => 'required|email|unique:user,email,' . $user_id . ',user_id',
            'sex'           => 'nullable|in:nam,nữ',
            'dob'           => 'nullable|date',
            'phone_number'  => 'required|string|min:8|max:10',
        ], [
            'username.required' => 'Vui lòng nhập tên đăng nhập.',
            'username.min'      => 'Tên đăng nhập phải ít nhất 6 ký tự.',
            'username.max'      => 'Tên đăng nhập không quá 255 ký tự.',
            'email.required'    => 'Vui lòng nhập email.',
            'email.email'       => 'Email không đúng định dạng.',
            'email.unique'      => 'Email này đã được sử dụng, vui lòng chọn email khác.',
            'phone_number'      => 'Số điện thoại không hợp lệ.'
        ]);

        $user = User::findOrFail($user_id);

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'sex' => $request->sex,
            'dob' => $request->dob,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('profile.show')->with('success', 'Cập nhật user thành công');
    }
}
