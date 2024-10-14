@extends('layouts.app')

@section('content')
<style>
    /* custom.css */

    body {
        background-color: #f4f6f9; /* Màu nền nhẹ cho toàn bộ trang */
        font-family: 'Arial', sans-serif; /* Font chữ */
    }

    h1 {
        color: #343a40; /* Màu tiêu đề chính */
        font-size: 2.5rem; /* Kích thước tiêu đề chính */
    }

    h3 {
        color: #495057; /* Màu tiêu đề phụ */
        border-bottom: 2px solid #007bff; /* Đường viền dưới cho tiêu đề phụ */
        padding-bottom: 5px; /* Khoảng cách dưới tiêu đề phụ */
    }

    .container {
        margin-top: 20px; /* Khoảng cách trên cho container */
        max-width: 1200px; /* Độ rộng tối đa của container */
    }

    .row {
        margin-bottom: 20px; /* Khoảng cách dưới cho hàng */
    }

    .table {
        border-radius: 8px; /* Bo góc cho bảng */
        overflow: hidden; /* Để bo góc hoạt động */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Đổ bóng cho bảng */
    }

    .table th, .table td {
        text-align: center; /* Căn giữa các ô trong bảng */
        vertical-align: middle; /* Căn giữa theo chiều dọc */
    }

    .table th {
        background-color: #007bff; /* Màu nền tiêu đề bảng */
        color: white; /* Màu chữ tiêu đề bảng */
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f2f2f2; /* Màu nền cho các hàng lẻ */
    }

    .table-striped tbody tr:hover {
        background-color: #e9ecef; /* Màu nền khi hover */
    }
</style>

<div class="container mt-4">
    <h1 class="mb-4 text-center">Báo cáo Doanh thu</h1>

    <div class="row mb-4">
        <div class="col-md-4">
            <h5>Tổng số khách hàng: {{ $totalCustomers }}</h5>
        </div>
        <div class="col-md-4">
            <h5>Tổng số đơn hàng: {{ $totalOrders }}</h5>
        </div>
    </div>

    <h3 class="mb-4">Doanh thu theo danh mục</h3>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID Danh mục</th>
                <th>Tổng Doanh thu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categoryRevenue as $revenue)
                <tr>
                    <td>{{ $revenue->category_id }}</td>
                    <td>{{ number_format($revenue->total_revenue, 2) }} VNĐ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="mb-4">Doanh thu theo ngày</h3>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Ngày</th>
                <th>Tổng Doanh thu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($revenueByDate as $revenue)
                <tr>
                    <td>{{ $revenue->date }}</td>
                    <td>{{ number_format($revenue->total_revenue, 2) }} VNĐ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="mb-4">Doanh thu theo tháng</h3>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Tháng</th>
                <th>Tổng Doanh thu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($revenueByMonth as $revenue)
                <tr>
                    <td>{{ $revenue->month }}</td>
                    <td>{{ number_format($revenue->total_revenue, 2) }} VNĐ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="mb-4">Doanh thu theo năm</h3>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Năm</th>
                <th>Tổng Doanh thu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($revenueByYear as $revenue)
                <tr>
                    <td>{{ $revenue->year }}</td>
                    <td>{{ number_format($revenue->total_revenue, 2) }} VNĐ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="mb-4">Doanh thu theo phương thức thanh toán</h3>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Phương thức thanh toán</th>
                <th>Tổng Doanh thu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($revenueByPaymentMethod as $revenue)
                <tr>
                    <td>{{ $revenue->payment_method }}</td>
                    <td>{{ number_format($revenue->total_revenue, 2) }} VNĐ</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
