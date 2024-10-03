@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Báo cáo Đơn hàng</h1>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Tổng số khách hàng</h5>
                    <p class="card-text display-4">{{ $totalCustomers }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Tổng số đơn hàng</h5>
                    <p class="card-text display-4">{{ $totalOrders }}</p>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mt-4">Doanh thu theo danh mục</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Danh mục</th>
                <th>Doanh thu (VNĐ)</th>
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

    <h3 class="mt-4">Doanh thu theo ngày</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Ngày</th>
                <th>Doanh thu (VNĐ)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($revenueByDate as $dailyRevenue)
                <tr>
                    <td>{{ $dailyRevenue->date }}</td>
                    <td>{{ number_format($dailyRevenue->total_revenue, 2) }} VNĐ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="mt-4">Doanh thu theo tháng</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Tháng</th>
                <th>Doanh thu (VNĐ)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($revenueByMonth as $monthlyRevenue)
                <tr>
                    <td>{{ $monthlyRevenue->month }}</td>
                    <td>{{ number_format($monthlyRevenue->total_revenue, 2) }} VNĐ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="mt-4">Doanh thu theo năm</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Năm</th>
                <th>Doanh thu (VNĐ)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($revenueByYear as $yearlyRevenue)
                <tr>
                    <td>{{ $yearlyRevenue->year }}</td>
                    <td>{{ number_format($yearlyRevenue->total_revenue, 2) }} VNĐ</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
