@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Welcome to Our Store</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card-deck">
        @foreach ($products as $product)
            <div class="card mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p class="card-text">Quantity Available: {{ $product->quantity }}</p>
                    <p class="card-text">Price: <span class="price">{{ number_format($product->price, 0, ',', '.') }} VND</span></p>
                    <p class="card-text">Category: {{ optional($product->category)->name }}</p>
                    @auth
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-primary">Xem chi tiết</a>
                        @endif
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="quantity" value="1"> <!-- Sử dụng hidden input để luôn gửi giá trị 1 -->
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

    <div class="d-flex justify-content-center">
        {{ $products->links() }}  <!-- Hiển thị phân trang -->
    </div>
</div>
@endsection
