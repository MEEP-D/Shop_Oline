<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders; // Assuming your model for orders is named Orders

class OrderController extends Controller
{
    public function index()
{
    // Lấy tất cả đơn hàng cùng với thông tin khách hàng và sản phẩm
    //$orders = Orders::with(['customer', 'items.product'])->get();
    $orders = Orders::all(); // Không dùng eager load
    // Kiểm tra dữ liệu
     // Dừng lại và in ra dữ liệu để kiểm tra
    
    // Trả về view admin hiển thị danh sách đơn hàng
    return view('admin.orders.index', compact('orders'));
}


    public function updateStatus(Request $request, $id) // Sử dụng tham số Orders thay vì $id
    {
        // Xác thực trạng thái được gửi lên
        
        $order = Orders::findOrFail($id);
        // Cập nhật trạng thái đơn hàng
        $order->status = $request->status; // Sử dụng đối tượng $order trực tiếp
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
}
