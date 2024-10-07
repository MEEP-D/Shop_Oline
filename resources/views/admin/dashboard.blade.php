@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">Admin Dashboard</h1>

    <div class="row g-4">
        <!-- Thống kê số lượng sản phẩm -->
        <div class="col-lg-4 col-md-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text display-4">{{ $productCount }}</p>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Manage Products</a>
                </div>
            </div>
        </div>

        <!-- Thống kê số lượng danh mục -->
        <div class="col-lg-4 col-md-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Categories</h5>
                    <p class="card-text display-4">{{ $categoryCount }}</p>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Manage Categories</a>
                </div>
            </div>
        </div>

        <!-- Thống kê số lượng đơn hàng -->
        <div class="col-lg-4 col-md-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Orders</h5>
                    <p class="card-text display-4">{{ $orderCount }}</p> <!-- Giả sử bạn có biến $orderCount -->
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-success">Manage Orders</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Nút báo cáo -->
    <div class="mt-4 text-center">
        <a href="{{ route('admin.reports.index') }}" class="btn btn-info btn-lg">Generate Report</a>
    </div>
</div>
@endsection
