<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Lấy tất cả sản phẩm cùng với thông tin danh mục
        $products = Product::with('category')->get();
        return view('admin.products.index', compact('products'));
    }
    public function search(Request $request)
    {
        // Khởi tạo biến chứa sản phẩm
        $products = collect();

        // Xử lý tìm kiếm nếu có từ khóa
        if ($request->has('keyword') && !empty($request->input('keyword'))) {
            $keyword = $request->input('keyword');
            // Tìm kiếm sản phẩm theo tên hoặc mô tả có chứa từ khóa
            $products = Product::with('category')
                                ->where(function($query) use ($keyword) {
                                    $query->where('name', 'like', "%$keyword%")
                                          ->orWhere('description', 'like', "%$keyword%");
                                })
                                ->paginate(10);
            // Đính kèm từ khóa vào URL phân trang để giữ lại kết quả tìm kiếm khi chuyển trang
            $products->appends(['keyword' => $keyword]);
        }  else {

            $products = Product::with('category')->paginate(10);
    }

        // Trả về view với danh sách sản phẩm tìm được
        return view('welcome', compact('products'));
    }
    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Lấy tất cả các danh mục để chọn
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // Create a new product
        Product::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'category_id' => $request->input('category_id'),
        ]);

        // Redirect to the products index page with a success message
        return redirect()->route('admin.products.index')->with('success', 'Tạo sản phẩm thành công.');
    }

    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        // Lấy tất cả các danh mục để chọn
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // Update the product
        $product->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'category_id' => $request->input('category_id'),
        ]);

        // Redirect to the products index page with a success message
        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công.');
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // Delete the product
        $product->delete();

        // Redirect to the products index page with a success message
        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công.');
    }
    //Người bình thường
        public function show_normal(Product $product){
            return	view('products.show', compact('product'));
        // Trả về view cho người dùng bình thường 
        }

}
