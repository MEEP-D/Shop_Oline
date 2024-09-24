<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem giỏ hàng.');
        }

        // Lấy giỏ hàng của người dùng đang đăng nhập
        $cartItems = CartItem::where('user_id', Auth::id())->with(['product.category'])->get();
        
        return view('cart.index', compact('cartItems'));
    }

    public function add(Request $request, $productId)
{
    try {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($productId);

        // Tìm giỏ hàng của người dùng hiện tại
        $cartItem = CartItem::where('user_id', Auth::id())
                             ->where('product_id', $productId)
                             ->first();

        if ($cartItem) {
            // Nếu sản phẩm đã có trong giỏ, cập nhật số lượng
            $cartItem->quantity += $request->quantity;
            $cartItem->price = $product->price; // Cập nhật giá nếu cần
            $cartItem->save();
        } else {
            // Nếu sản phẩm chưa có trong giỏ, thêm mới
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Thêm sản phẩm vào giỏ hàng thành công!');
    } catch (\Exception $e) {
        Log::error('Error adding to cart: ' . $e->getMessage());
        return redirect()->route('cart.index')->with('error', 'Đã xảy ra lỗi khi thêm sản phẩm vào giỏ hàng.');
    }
}


    public function update(Request $request, $id)
    {
        // Cập nhật số lượng sản phẩm trong giỏ hàng
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Tìm giỏ hàng theo ID
        $cartItem = CartItem::findOrFail($id);
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->route('cart.index')->with('success', 'Cập nhật số lượng thành công!');
    }

    public function remove($id)
    {
        // Xóa sản phẩm khỏi giỏ hàng
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Xóa sản phẩm thành công!');
    }
}
