<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/search', [HomeController::class, 'search'])->name('search');

Route::get('/register', [UserController::class, 'register']);

Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show');


/*
  route này hiển thị sản phẩm theo danh mục

  name('product.indexByCategory') phần product.indexByCategory để gọi trong view chỉ đến route này
  tại view khi gọi route này phải truyền vào them số categoryId
  ví dụ: {{route(product.indexByCategory, ['categoryId' => "Laptop])}}
*/
Route::get("/{category}", [ProductController::class, 'indexByCategory'])->name('product.indexByCategory');

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

Route::resource('user', UserController::class);
