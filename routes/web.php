<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Hiển thi trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');
// Hiển thị trang tìm kiếm sản phẩm
Route::get('/search', [HomeController::class, 'search'])->name('search');

// GET: Hiển thị form đăng ký khách hàng (trang HTML)
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name("register");
// POST: Xử lý dữ liệu form đăng ký khách hàng(tạo user)
Route::post('/register', [AuthController::class, 'register'])->name("register.submit");
// GET: Hiển thị form đăng nhập khách hàng (trang HTML)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// POST: Xử lý dữ liệu form đăng nhập khách hàng
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
// PÓT: Xử lý đăng xuất khách hàng
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// GET: Trang cá nhân khách hàng 
Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile.show');
// PUT: Cập nhật thông tin của khách hàng
Route::put('/profile/{user_id}', [AuthController::class, 'update'])->name('profile.update');
// PUT: Cập nhật ảnh đại diện khách hàng

// hiển thị danh sách sản phẩm theo phân loại
Route::get('/category/{category_id}', [CategoryController::class, 'show'])->name('category.show');


/*
  Hiển thị sản phẩm theo phân loại có filter
  Phần 'product.indexByCategory' để gọi trong view chỉ đến route này
  tại view khi gọi route này phải truyền vào tham số category_id
  ví dụ: {{route(product.indexByCategory, ['category_id' => "Laptop])}}
*/
Route::get("/{category_id}", [ProductController::class, 'indexByCategory'])->name('product.indexByCategory');
// hiển thị chi tiết sản phẩm
Route::get('/product/{productId}', [ProductController::class, 'show'])->name('product.show');

// Route::resource('user', UserController::class);

Route::get('/user/show', [UserController::class, 'show'])->name('user.show');
