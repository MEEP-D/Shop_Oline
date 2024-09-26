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

// Trang chủ
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Đăng ký và đăng nhập
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Các route yêu cầu người dùng phải đăng nhập
Route::middleware(['auth'])->group(function () {
    // Giỏ hàng
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    
    // Sản phẩm
    Route::get('/products', [ProductController::class, 'index'])->name('products.index'); // Xem danh sách sản phẩm
    Route::get('/products/{product}', [ProductController::class, 'show_normal'])->name('products.show'); // Xem chi tiết sản phẩm
    
    // Thanh toán
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index'); // Trang thanh toán
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process'); // Xử lý thanh toán
    Route::delete('/checkout', [CheckoutController::class, 'destroy'])->name('checkout.destroy');
});

// Các route yêu cầu người dùng phải có quyền admin
Route::middleware(['auth', 'admin'])->group(function () {
    // Bảng điều khiển của Admin
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Quản lý sản phẩm
    Route::resource('/admin/products', ProductController::class, [
        'as' => 'admin' // Định nghĩa các route dưới namespace 'admin'
    ]);
    
    // Quản lý danh mục
    Route::resource('/admin/categories', CategoryController::class, [
        'as' => 'admin'
    ]);

    // Quản lý đơn hàng
    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('order.store');
});
