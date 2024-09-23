@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="row">
        <!-- Thống kê số lượng sản phẩm -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text display-4">{{ $productCount }}</p>
                </div>
            </div>
        </div>

        <!-- Thống kê số lượng danh mục -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Categories</h5>
                    <p class="card-text display-4">{{ $categoryCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Thêm các phần khác như quản lý sản phẩm, danh mục -->
    <div class="mt-4">
        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Manage Products</a>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Manage Categories</a>
    </div>
</div>
@endsection
