<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart; // Import model Cart

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $userId = auth()->id(); // Lấy ID người dùng đang đăng nhập
        $cartItems = Cart::where('user_id', $userId)->with('product')->get();
        
        return view('cart.index', compact('cartItems'));
    }

    // Thêm sản phẩm vào giỏ hàng
    public function add(Request $request, Product $product)
    {
        $userId = auth()->id(); // Lấy ID người dùng đang đăng nhập
    
        // Kiểm tra nếu sản phẩm đã tồn tại trong giỏ hàng
        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $product->id) // Sử dụng thuộc tính id từ mô hình product
            ->first();
    
        if ($cartItem) {
            // Cập nhật số lượng
            $cartItem->quantity++;
            $cartItem->save();
        } else {
            // Thêm sản phẩm mới vào giỏ hàng
            Cart::create([
                'user_id' => $userId,
                'product_id' => $product->id, // Đảm bảo $product có thuộc tính id
                'quantity' => 1,
            ]);
        }
    
        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }
    

    // Xoá sản phẩm khỏi giỏ hàng
    public function remove(Cart $cartItem)
    {
        $cartItem->delete(); // Xóa sản phẩm khỏi giỏ hàng

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xoá khỏi giỏ hàng.');
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function update(Request $request, Cart $cartItem)
    {
        $quantity = $request->input('quantity');

        // Kiểm tra nếu số lượng hợp lệ
        if ($quantity > 0) {
            $cartItem->quantity = $quantity;
            $cartItem->save();
        } else {
            // Nếu số lượng <= 0, xóa sản phẩm khỏi giỏ hàng
            $cartItem->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật.');
    }
}
