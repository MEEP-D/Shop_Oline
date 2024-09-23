<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders; // Import model Orders
use App\Models\OrderItems; // Import model OrderItems
use Illuminate\Support\Facades\Auth; // Import Auth

class OrderController extends Controller
{
    public function index()
    {
        // Lấy danh sách đơn hàng của user hiện tại
        $orders = Orders::where('user_id', Auth::id())->get();
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);

        if (count($cart) == 0) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn trống.');
        }

        // Tạo đơn hàng mới
        $order = Orders::create([
            'user_id' => Auth::id(),
            'total' => $request->total,
            'status' => 'processing',
            'payment_method' => $request->payment_method,
        ]);

        // Lưu các mặt hàng trong đơn hàng
        foreach ($cart as $id => $details) {
            OrderItems::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $details['price']
            ]);
        }

        // Xóa giỏ hàng sau khi đặt hàng
        session()->forget('cart');

        return redirect()->route('order.index')->with('success', 'Đặt hàng thành công!');
    }
}
