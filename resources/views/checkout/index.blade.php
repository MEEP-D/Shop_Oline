@extends('layouts.app')

@section('title', 'Thanh Toán')

@section('content')
<div class="container mt-4">
    <h1>Thanh Toán</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(!empty($cart))
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Tên Sản Phẩm</th>
                    <th scope="col">Danh Mục</th>
                    <th scope="col">Số Lượng</th>
                    <th scope="col">Giá</th>
                    <th scope="col">Thành Tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $id => $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['category'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>${{ number_format($item['price'], 2) }}</td>
                        <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-right">
            <h3>Tổng tiền: ${{ number_format($total, 2) }}</h3>
        </div>

        <!-- Form thanh toán -->
        <form action="{{ route('order.store') }}" method="POST">
            @csrf
            <input type="hidden" name="total" value="{{ $total }}">
            <div class="form-group">
                <label for="payment_method">Phương thức thanh toán:</label>
                <select name="payment_method" id="payment_method" class="form-control">
                    <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                    <option value="online">Thanh toán trực tuyến</option>
                    <!-- Thêm các phương thức thanh toán khác nếu cần -->
                </select>
            </div>
            <button type="submit" class="btn btn-success">Đặt hàng</button>
        </form>
    @else
        <p>Giỏ hàng của bạn hiện tại đang trống.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Xem sản phẩm</a>
    @endif
</div>
@endsection
