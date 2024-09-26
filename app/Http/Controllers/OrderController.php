<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class OrderController extends Controller
{
    // Hiển thị danh sách các đơn hàng của người dùng hiện tại
    public function index()
    {
        // Lấy tất cả đơn hàng của người dùng hiện tại
        $orders = Orders::where('user_id', Auth::id())->get();
        
        // Trả về view 'orders.index' với danh sách đơn hàng
        return view('orders.index', compact('orders'));
    }

    // Xử lý đặt hàng
    public function store(Request $request)
    {
        dd($request->all());
        // Xác thực dữ liệu từ form
        $validatedData = $request->validate([
            'selected_products' => 'required|array',
            'quantity' => 'required|integer|min:1', // thêm điều kiện cho quantity
            'total' => 'required|numeric',
            'payment_method' => 'required|string',
        ]);
        

        // Lấy thông tin giỏ hàng từ session
        $cart = session()->get('cart', []);
        
        // Kiểm tra nếu giỏ hàng trống
        if (count($cart) == 0) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn trống.');
        }

        // Tạo đơn hàng mới
        $order = Orders::create([
            'user_id' => Auth::id(), 
            'total' => $validatedData['total'], 
            'status' => 'processing', 
            'payment_method' => $validatedData['payment_method'], 
        ]);

        // Lưu các sản phẩm trong đơn hàng
        foreach ($request->selected_products as $index => $productId) {
            OrderItems::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $request->quantity[$index], // Nếu mỗi sản phẩm có số lượng khác nhau
                'price' => $cart[$productId]['price'], // Giả định rằng bạn đã có giá trong giỏ hàng
            ]);
        }
        
        
        // Xóa giỏ hàng khỏi cơ sở dữ liệu sau khi đặt hàng thành công
        Cart::where('user_id', Auth::id())->delete();

        // Xóa giỏ hàng khỏi session
        session()->forget('cart');

        // Chuyển hướng đến trang danh sách đơn hàng với thông báo thành công
        return redirect()->route('order.index')->with('success', 'Đặt hàng thành công!');
    }
}
