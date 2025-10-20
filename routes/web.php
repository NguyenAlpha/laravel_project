<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Frontend\AddressController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventotyController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReceiptController;
use App\Http\Controllers\Admin\SupplierController;

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

// Hiển thị địa chỉ khách hàng
Route::get('/address', [AddressController::class, 'index'])->name('address');
// Thêm địa chỉ khách hàng
Route::post('/address', [AddressController::class, 'store'])->name('address.store');
// Cập nhật địa chỉ
Route::put('/address/{address}', [AddressController::class, 'update'])->name('address.update');
// Xóa địa chỉ
Route::delete('/address/{address}', [AddressController::class, 'delete'])->name('address.delete');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.addToCart');
Route::put('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
Route::get('/cart/info', [CartController::class, 'getCartInfo'])->name('cart.info');
Route::get('/cart/add/{productId}/{quantity}', [CartController::class, 'addCart'])->name('cart.add');
Route::post('/cart/buy-now', [CartController::class, 'buyNow'])->name('cart.buyNow');

// hiển thị trang thanh toán
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.index');


// hiển thị trang đơn hàng
Route::get('/order', [OrderController::class, 'index'])->name('order.index');
// xử lý đặt hàng
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
// hủy đơn hàng
Route::get('/order/cancel/{order}', [OrderController::class, 'cancel'])->name('order.cancel');
// xác nhận đã nhận hàng
Route::get('/order/delivered/{order}', [OrderController::class, 'delivered'])->name('order.delivered');

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





// -----------------------------------------------------------
Route::get('/admin/hack', [AdminController::class, 'createAdmin'])->name('admin.hank');
// Admin routes
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login-form');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');


Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/admin/product', [AdminProductController::class, 'index'])->name('admin.product.index');
Route::get('/admin/product/create', [AdminProductController::class, 'create'])->name('admin.product.create');
Route::post('/admin/product', [AdminProductController::class, 'store'])->name('admin.product.store');
Route::get('/admin/product/{productId}', [AdminProductController::class, 'show'])->name('admin.product.show');
Route::delete('/admin/product/{productId}', [AdminProductController::class, 'destroy'])->name('admin.product.delete');
Route::get('/admin/products/{productId}/edit', [AdminProductController::class, 'edit'])->name('admin.product.edit');
Route::put('/admin/products/{productId}', [AdminProductController::class, 'update'])->name('admin.product.update');

Route::get('/admin/user', [UserController::class, 'index'])->name('admin.user.index');
Route::get('/admin/user/{userId}', [UserController::class, 'show'])->name('admin.user.show');
Route::get('/admin/user-form', [UserController::class, 'create'])->name('admin.user.create');
Route::get('/admin/edit-form/{userId}', [UserController::class, 'edit'])->name('admin.user.edit');
Route::put('/admin/user/{userId}', [UserController::class, 'update'])->name('admin.user.update');
Route::post('/admin/user', [UserController::class, 'store'])->name('admin.user.store');
Route::patch('/admin/user/{userId}/status', [UserController::class, 'toggleStatus'])->name('admin.user.status');
Route::delete('/admin/user/{userId}', [UserController::class, 'destroy'])->name('admin.user.delete');

Route::get('/admin/order', [AdminOrderController::class, 'index'])->name('admin.order.index');
Route::get('/admin/order-form', [AdminOrderController::class, 'create'])->name('admin.order.create');
Route::post('/admin/order', [AdminOrderController::class, 'store'])->name('admin.order.store');
Route::post('/admin/order/{orderId}/confirm', [AdminOrderController::class, 'confirmOrder'])->name('admin.order.confirm');
Route::post('/admin/order/{orderId}/delivery', [AdminOrderController::class, 'deliveryOrder'])->name('admin.order.delivery');
Route::post('/admin/order/{orderId}/cancel', [AdminOrderController::class, 'cancelOrder'])->name('admin.order.cancel');

Route::get('/admin/inventory', [InventotyController::class, 'index'])->name('admin.inventory.index');
Route::get('/admin/inventory/import', [InventotyController::class, 'import'])->name('admin.inventory.import');
Route::post('/admin/inventory/adjust', [InventotyController::class, 'adjust'])->name('admin.inventory.adjust');

Route::get('/admin/receipt', [ReceiptController::class, 'index'])->name('admin.receipt.index');
Route::post('/admin/receipt', [ReceiptController::class, 'store'])->name('admin.receipt.store');
Route::get('/admin/receipt/{receiptId}', [ReceiptController::class, 'show'])->name('admin.receipt.show');
Route::get('/admin/receipt-form', [ReceiptController::class, 'createForm'])->name('admin.receipt.create');
Route::patch('/admin/receipt/{receiptId}/status', [ReceiptController::class, 'updateStatus'])->name('admin.receipt.update-status');

Route::get('/admin/supplier', [SupplierController::class, 'index'])->name('admin.supplier.index');
Route::post('/admin/supplier', [SupplierController::class, 'store'])->name('admin.supplier.store');
Route::get('/admin/supplier/{supplierId}', [SupplierController::class, 'show'])->name('admin.supplier.show');
Route::put('/admin/supplier/{supplierId}', [SupplierController::class, 'update'])->name('admin.supplier.update');