@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Chào mừng đến với cửa hàng của chúng tôi</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Thêm ô tìm kiếm -->
    <form action="{{ route('products.search') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="keyword" placeholder="Nhập từ khóa tìm kiếm...">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Tìm kiếm</button>
            </div>
        </div>
    </form>

    <div class="card-deck">
        @foreach ($products as $product)
            <div class="card mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p class="card-text">Số lượng có sẵn: {{ $product->quantity }}</p>
                    <p class="card-text">Giá: <span class="price">{{ number_format($product->price, 0, ',', '.') }} VND</span></p>
                    <p class="card-text">Danh mục: {{ optional($product->category)->name }}</p>
                    
                    @auth
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-primary">Xem chi tiết</a>
                        @endif
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="quantity" value="1"> <!-- Luôn gửi giá trị 1 -->
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
        {{ $products->links() }} <!-- Hiển thị phân trang -->
    </div>
</div>
@endsection
