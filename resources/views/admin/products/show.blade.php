<!-- resources/views/products/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chi Tiết Sản Phẩm</h1>
    <p><strong>Tên Sản Phẩm:</strong> {{ $product->name }}</p>
    <p><strong>Mô Tả:</strong> {{ $product->description }}</p>
    <p><strong>Giá:</strong> {{ number_format($product->price, 2) }}VND</p>
    <p><strong>Danh Mục:</strong> {{ $product->category ? $product->category->name : 'Chưa có danh mục' }}</p>

    <a class="btn btn-primary" href="{{ route('admin.products.edit', $product->id) }}">Sửa</a>
    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Xóa</button>
    </form>
    <a class="btn btn-secondary" href="{{ route('admin.products.index') }}">Trở Lại Danh Sách Sản Phẩm</a>
    <a class="btn btn-primary" href="{{ route('admin.categories.index') }}">Xem Danh Mục</a> <!-- Liên kết đến danh sách danh mục -->
</div>
@endsection

@push('styles')
<style>
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
    .text-danger {
        color: #dc3545;
    }
    .alert-success {
        margin-top: 1rem;
    }
</style>
@endpush
