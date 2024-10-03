<?php

namespace App\Http\Controllers\Admin; // Đặt namespace ở đúng vị trí

use App\Http\Controllers\Controller; // Đảm bảo import lớp Controller
use App\Models\Orders;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Thống kê tổng doanh thu theo từng danh mục
        $categoryRevenue = DB::table('order_items')
            ->select('products.category_id', DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue'))
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'paid')
            ->groupBy('products.category_id')
            ->get();

        // Đếm tổng số khách hàng có role là 'customer'
        $totalCustomers = DB::table('users')->where('role', 'customer')->count();

        // Tổng số đơn hàng
        $totalOrders = Orders::count();

        // Doanh thu theo ngày
        $revenueByDate = Orders::select(DB::raw('DATE(created_at) as date, SUM(total) as total_revenue'))
            ->where('status', 'paid')
            ->groupBy('date')
            ->get();

        // Doanh thu theo tháng
        $revenueByMonth = Orders::select(DB::raw('MONTH(created_at) as month, SUM(total) as total_revenue'))
            ->where('status', 'paid')
            ->groupBy('month')
            ->get();

        // Doanh thu theo năm
        $revenueByYear = Orders::select(DB::raw('YEAR(created_at) as year, SUM(total) as total_revenue'))
            ->where('status', 'paid')
            ->groupBy('year')
            ->get();

        // Trả về view với các dữ liệu được tính toán
        return view('admin.reports.index', compact(
            'categoryRevenue',
            'totalOrders',
            'totalCustomers',
            'revenueByDate',
            'revenueByMonth',
            'revenueByYear'
        ));
    }
}
