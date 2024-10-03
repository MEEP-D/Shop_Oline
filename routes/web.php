<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController, 
    WelcomeController, 
    AdminController, 
    ProductController, 
    CategoryController, 
    OrderController,
    CartController,
    InvoiceController
};
use App\Http\Controllers\Admin\AdminOrderController;


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
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    
    // Sản phẩm
    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index'); 
    Route::get('/products/{product}', [ProductController::class, 'show_normal'])->name('products.show'); 
 
    
    // Thanh toán
    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
    Route::delete('/orders/store', [OrderController::class, 'store'])->name('order.store'); // Lưu đơn hàng
    Route::get('/invoice/{orderId}', [InvoiceController::class, 'generateInvoice'])->name('invoice.generate');

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
    Route::get('/admin/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.orders.index');

    // Cập nhật trạng thái đơn hàng
    Route::patch('/admin/orders/{id}', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::get('/admin/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index');
});


