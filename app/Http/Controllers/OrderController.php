<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Payment;

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
        // Xác thực dữ liệu từ form
        $validatedData = $request->validate([
            'selected_products' => 'required|array', // Các sản phẩm được chọn
            'quantity' => 'required|array', // Số lượng tương ứng cho mỗi sản phẩm
            'total' => 'required|numeric', // Tổng số tiền đơn hàng
            'payment_method' => 'required|string', // Phương thức thanh toán
        ]);

        // Kiểm tra nếu không có sản phẩm nào được chọn
        if (empty($validatedData['selected_products'])) {
            return redirect()->back()->with('error', 'Bạn chưa chọn sản phẩm nào để đặt hàng.');
        }

        // Tạo đơn hàng mới
        $order = Orders::create([
            'user_id' => Auth::id(),
            'total' => $validatedData['total'],
            'status' => 'processing', // Trạng thái đơn hàng
            'payment_method' => $validatedData['payment_method'],
        ]);

        // Lưu các sản phẩm được chọn trong đơn hàng và xóa khỏi giỏ hàng
        foreach ($validatedData['selected_products'] as $index => $productId) {
            $quantity = $validatedData['quantity'][$index]; // Lấy số lượng cho từng sản phẩm
            
            // Tìm sản phẩm trong giỏ hàng
            $cartItem = Cart::where('user_id', Auth::id())->where('product_id', $productId)->first();

            if ($cartItem) {
                // Tạo bản ghi OrderItems
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

        // Lưu thông tin thanh toán
        Payment::create([
            'order_id' => $order->id,
            'amount' => $order->total, // Tổng số tiền của đơn hàng
            'payment_method' => $order->payment_method, // Phương thức thanh toán đã chọn
        ]);

        // Chuyển hướng đến trang danh sách đơn hàng với thông báo thành công
        return redirect()->route('order.index')->with('success', 'Đặt hàng thành công!');
    }
}
