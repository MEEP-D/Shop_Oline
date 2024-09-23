<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Lấy số lượng sản phẩm và danh mục
        $productCount = Product::count();
        $categoryCount = Category::count();

        // Truyền dữ liệu vào view
        return view('admin.dashboard', [
            'productCount' => $productCount,
            'categoryCount' => $categoryCount,
        ]);
    }
    public function products(){
        return app(ProductController::class)->index();
    }
    public function categories(){
        return app(CategoryController::class)->index();
    }
}
