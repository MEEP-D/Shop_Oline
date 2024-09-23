@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Welcome to Our Store</h1>
    <div class="card-deck">
        @foreach ($products as $product)
            <div class="card mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p class="card-text">Quantity: {{ $product->quantity }}</p>
                    <p class="card-text">Price: ${{ number_format($product->price, 2) }}</p>
                    <p class="card-text">Category: {{ optional($product->category)->name }}</p>
                    <!-- Ẩn nút xem chi tiết nếu người dùng không phải admin -->
                    @auth
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-primary">Xem chi tiết</a>
                        @endif
                        <!-- Form để thêm sản phẩm vào giỏ hàng -->
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">Thêm vào giỏ hàng</button>
                        </form>
                    @endauth
                    @guest
                        <p class="mt-2">Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để thêm sản phẩm vào giỏ hàng.</p>
                    @endguest
                </div>
            </div>
        @endforeach
    </div>
    <!-- Hiển thị liên kết phân trang -->
    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection
