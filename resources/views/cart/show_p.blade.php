@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Chi Tiết Sản Phẩm Trong Giỏ Hàng</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tên Sản Phẩm: {{ $product->name }}</h5>
            <p class="card-text">Mô Tả: {{ $product->description }}</p>
            <p class="card-text">Số lượng: {{ $quantity }}</p>
            <p class="card-text">Giá: ${{ number_format($product->price, 2) }}</p>
            <p class="card-text">Danh mục: {{ optional($product->category)->name }}</p>
            
            <!-- Nút để quay lại danh sách giỏ hàng -->
            <a href="{{ route('cart.index') }}" class="btn btn-secondary">Quay lại giỏ hàng</a>
            
            <!-- Nút để xóa sản phẩm khỏi giỏ hàng -->
            <form action="{{ route('cart.remove', $product->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Xóa khỏi giỏ hàng</button>
            </form>
        </div>
    </div>
</div>
@endsection
