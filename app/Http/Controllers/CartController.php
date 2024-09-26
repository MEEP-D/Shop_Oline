<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart; // Thêm import cho model Cart
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get(); // Lấy sản phẩm trong giỏ hàng của người dùng hiện tại
        return view('cart.index', compact('cartItems')); // Truyền giỏ hàng vào view
    }

    // Thêm sản phẩm vào giỏ hàng
    public function add(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($id);
        $userId = Auth::id();

        // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
        $cartItem = Cart::where('user_id', $userId)->where('product_id', $product->id)->first();

        if ($cartItem) {
            // Cập nhật số lượng sản phẩm
            $cartItem->quantity += $request->quantity;
        } else {
            // Thêm sản phẩm mới vào giỏ hàng
            $cartItem = new Cart([
                'user_id' => $userId,
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ]);
        }
        $cartItem->save(); // Lưu thay đổi

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }

    // Xoá sản phẩm khỏi giỏ hàng
    public function remove($id)
    {
        // Tìm sản phẩm trong giỏ hàng của người dùng hiện tại và xoá
        Cart::where('user_id', Auth::id())->where('product_id', $id)->delete();
        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xoá khỏi giỏ hàng.');
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function update(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    // Tìm sản phẩm trong giỏ hàng của người dùng hiện tại
    $cartItem = Cart::where('user_id', Auth::id())->where('product_id', $id)->first();

    if ($cartItem) {
        // Cập nhật số lượng
        $cartItem->quantity = $request->quantity;
        $cartItem->save(); // Lưu thay đổi
    }

    // Thêm logic thanh toán nếu số lượng > 0
    if ($cartItem->quantity > 0) {
        return redirect()->route('cart.index')->with('success', 'Cập nhật giỏ hàng thành công! Bạn đã cập nhật số lượng sản phẩm.');
    } else {
        // Nếu số lượng = 0, xóa sản phẩm khỏi giỏ hàng
        $cartItem->delete();
        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }
}

    // Xoá tất cả sản phẩm trong giỏ hàng
    public function clear()
    {
        // Xoá tất cả sản phẩm trong giỏ hàng của người dùng hiện tại
        Cart::where('user_id', Auth::id())->delete();
        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được làm sạch.');
    }
}
