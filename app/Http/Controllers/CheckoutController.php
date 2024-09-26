<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        // Lấy thông tin giỏ hàng từ cơ sở dữ liệu
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        $total = 0;

        // Tính tổng tiền
        foreach ($cartItems as $item) {
            $total += $item->product->price * $item->quantity;
        }

        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function process(Request $request)
    {
        // Logic xử lý thanh toán

        // Giả sử bạn muốn giảm số lượng sản phẩm trong kho
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        foreach ($cartItems as $item) {
            $item->product->decrement('quantity', $item->quantity); // Giảm số lượng sản phẩm
        }

        // Xóa giỏ hàng sau khi thanh toán thành công
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('cart.index')->with('success', 'Thanh toán thành công.');
    }
    public function destroy(Request $request)
{
    // Kiểm tra xem có 'cart_id' trong request hay không
    $cartId = $request->input('cart_id');

    // Kiểm tra nếu có id giỏ hàng và tìm nó trong database
    if ($cartId) {
        // Tìm cart item với ID đã cho
        $cartItem = Cart::find($cartId);

        // Nếu không tìm thấy cart item, trả về lỗi 404
        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found.'], 404);
        }

        // Xóa cart item
        $cartItem->delete();

        // Trả về phản hồi thành công
        return response()->json(['message' => 'Cart item deleted successfully.']);
    }

    // Nếu không có cart_id trong request, trả về lỗi 400
    return response()->json(['message' => 'Cart ID is required.'], 400);
}

}

