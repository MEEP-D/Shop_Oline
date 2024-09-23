<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController, 
    WelcomeController, 
    AdminController, 
    ProductController, 
    CategoryController, 
    CartController,
    OrderController,
    CheckoutController
};

// Trang chủ welcome
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Đăng ký và đăng nhập người dùng
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Routes cho người dùng bình thường
Route::middleware(['auth'])->group(function () {
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update'); 
    Route::get('/cart/products/{product}', [CartController::class, 'show'])->name('cart.show'); 

    // Route cho sản phẩm
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show_normal'])->name('products.show');
    
    // Route cho thanh toán
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
});

// Routes dành cho admin (yêu cầu quyền admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Route quản lý sản phẩm
    Route::resource('/admin/products', ProductController::class, [
        'as' => 'admin' 
    ]);
    
    // Route quản lý danh mục
    Route::resource('/admin/categories', CategoryController::class, [
        'as' => 'admin' 
    ]);

    // Route cho đơn hàng
    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('order.store');
});
