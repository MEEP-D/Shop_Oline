<?php
namespace App\Http\Controllers;
// Sử dụng model User thay vì Customer
use App\Models\User; 
use App\Models\Orders;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class InvoiceController extends Controller
{
    public function generateInvoice($orderId)
    {
        // Lấy thông tin hóa đơn từ cơ sở dữ liệu
        $order = Orders::with('user')->findOrFail($orderId); // Tải user khi tìm order

        // Tạo dữ liệu cho hóa đơn
        $data = [
            'order' => $order,
            'user' => $order->user, // Truy cập user trực tiếp từ order
        ];

        // Tạo PDF
        $pdf = FacadePdf::loadView('invoice.invoice', $data); // Chỉ định view để tạo hóa đơn

        // Đặt tiêu đề cho file PDF
        $pdf->setPaper('A4', 'portrait');

        // Trả về PDF cho người dùng
        return $pdf->stream('invoice_' . $order->id . '.pdf'); // Tên file sẽ là invoice_[ID].pdf
    }
}
