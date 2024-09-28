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

    public function store(Request $request)
    {
        // Xác thực dữ liệu từ form
        $validatedData = $request->validate([
            'selected_products' => 'required|array', // Các sản phẩm được chọn
            'quantity' => 'required|array', // Số lượng tương ứng cho mỗi sản phẩm
            'total' => 'required|numeric',
            'payment_method' => 'required|string',
        ]);
    
        // Kiểm tra nếu không có sản phẩm nào được chọn
        if (empty($validatedData['selected_products'])) {
            return redirect()->back()->with('error', 'Bạn chưa chọn sản phẩm nào để đặt hàng.');
        }
    
        // Tạo đơn hàng mới
        $order = Orders::create([
            'user_id' => Auth::id(),
            'total' => $validatedData['total'],
            'status' => 'processing',
            'payment_method' => $validatedData['payment_method'],
        ]);
    
        // Lưu các sản phẩm được chọn trong đơn hàng và xóa khỏi giỏ hàng
        foreach ($validatedData['selected_products'] as $index => $productId) {
            $quantity = $request->quantity[$index]; // Lấy số lượng cho từng sản phẩm
            $cartItem = Cart::where('user_id', Auth::id())->where('product_id', $productId)->first();
    
            if ($cartItem) {
                OrderItems::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $cartItem->product->price * $quantity, // Tổng giá cho sản phẩm
                ]);
    
                // Xóa sản phẩm khỏi giỏ hàng
                $cartItem->delete();
            }
        }
    
        // Chuyển hướng đến trang danh sách đơn hàng với thông báo thành công
        return redirect()->route('order.index')->with('success', 'Đặt hàng thành công!');
    }
    
}

