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

    public function update(Request $request, $id)
{
    // Xác thực dữ liệu đầu vào
    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    // Tìm sản phẩm trong giỏ hàng của người dùng hiện tại
    $cartItem = Cart::where('user_id', Auth::id())->where('product_id', $id)->first();

    if ($cartItem) {
        // Lấy sản phẩm dựa trên ID sản phẩm
        $product = Product::where('id', $cartItem->product_id)->first();

        // Cập nhật số lượng
        $cartItem->quantity = $request->input('quantity');

        // Nếu số lượng = 0, xóa sản phẩm khỏi giỏ hàng
        if ($cartItem->quantity <= 0) {
            $cartItem->delete();
            return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
        }

        // Lưu thay đổi
        $cartItem->save();

        // Tính tổng tiền của giỏ hàng
        $totalAmount = 0;
        $cartItems = Cart::where('user_id', Auth::id())->get();
        foreach ($cartItems as $item) {
            $productPrice = Product::where('id', $item->product_id)->value('price'); // Lấy giá sản phẩm
            $totalAmount += $productPrice * $item->quantity; // Cộng tổng tiền
        }

        // Cập nhật giá trị tổng vào session (hoặc tùy thuộc vào cách bạn muốn xử lý)
        session(['total_amount' => $totalAmount]);

        return redirect()->route('cart.index')->with('success', 'Cập nhật giỏ hàng thành công! Bạn đã cập nhật số lượng sản phẩm.');
    }

    return redirect()->route('cart.index')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
}

    // Xoá tất cả sản phẩm trong giỏ hàng
    public function clear()
{
    $userId = Auth::id();

    // Kiểm tra xem giỏ hàng có sản phẩm hay không
    $cartItemsCount = Cart::where('user_id', $userId)->count();

    if ($cartItemsCount > 0) {
        // Xóa tất cả sản phẩm trong giỏ hàng của người dùng hiện tại
        Cart::where('user_id', $userId)->delete();
        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được làm sạch.');
    } else {
        return redirect()->route('cart.index')->with('warning', 'Giỏ hàng của bạn hiện đang trống.');
    }
}

}
