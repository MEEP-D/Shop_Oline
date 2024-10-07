@extends('layouts.app')

@section('content')
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
</div>
@endsection
