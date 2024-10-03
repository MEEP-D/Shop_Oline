<?php

namespace App\Http\Controllers\Admin;

use App\Models\Orders; // Import model Orders
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Import Controller class
use Illuminate\Support\Facades\Validator; // Import Validator

class OrderController extends Controller
{
    // Hiển thị tất cả đơn hàng cho admin
    public function index()
    {
        // Lấy tất cả đơn hàng từ bảng orders
        $orders = Orders::with('user')->get(); // Lấy đơn hàng cùng với thông tin người dùng

        // Trả về view 'admin.orders.index' với danh sách đơn hàng
        return view('admin.orders.index', compact('orders'));
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus(Request $request, $id)
    {
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:paid,cancelled,processing', // Chỉ cho phép các giá trị hợp lệ
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.orders.index')->withErrors($validator)->withInput();
        }

        // Cập nhật trạng thái đơn hàng
        $order = Orders::findOrFail($id);
        $order->status = $request->status; // Trạng thái có thể là 'paid', 'cancelled' hoặc 'processing'
        $order->save();

        // Chuyển hướng về trang danh sách đơn hàng với thông báo cập nhật thành công
        return redirect()->route('admin.orders.index')->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
}
