<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/search', [HomeController::class, 'search'])->name('search');

// GET: Hiển thị form đăng ký (trang HTML)
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name("register");
// POST: Xử lý dữ liệu form đăng ký (tạo user)
Route::post('/register', [AuthController::class, 'register'])->name("register.submit");

// GET: Hiển thị form đăng nhập (trang HTML)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// POST: Xử lý dữ liệu form đăng nhập
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show');


/*
  route này hiển thị sản phẩm theo danh mục

  name('product.indexByCategory') phần product.indexByCategory để gọi trong view chỉ đến route này
  tại view khi gọi route này phải truyền vào them số categoryId
  ví dụ: {{route(product.indexByCategory, ['categoryId' => "Laptop])}}
*/
Route::get("/{category}", [ProductController::class, 'indexByCategory'])->name('product.indexByCategory');

Route::get('/product/{productId}', [ProductController::class, 'show'])->name('product.show');

// Route::resource('user', UserController::class);

Route::get('/user/show', [UserController::class, 'show'])->name('user.show');
