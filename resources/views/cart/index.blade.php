@extends('layouts.app')

@section('title', 'Giỏ Hàng')

@section('content')
<div class="container mt-4">
    <h1>Giỏ Hàng Của Bạn</h1>

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
                    <th scope="col">Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $id => $item)
                    @php
                        $total += $item['price'] * $item['quantity']; 
                    @endphp
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['category'] }}</td>
                        <td>
                            <form action="{{ route('cart.update', $id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control" style="width: 70px; display: inline;">
                                <button type="submit" class="btn btn-sm btn-secondary">Cập nhật</button>
                            </form>
                        </td>
                        <td>${{ number_format($item['price'], 2) }}</td>
                        <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between">
            <div>
                <a href="{{ route('welcome') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
            </div>
            <div>
                <h4>Tổng tiền: ${{ number_format($total, 2) }}</h4>
                <a href="{{ route('checkout.index') }}" class="btn btn-success">Thanh toán</a>
            </div>
        </div>
    @else
        <p>Giỏ hàng của bạn hiện tại đang trống.</p>
        <a href="{{ route('welcome') }}" class="btn btn-primary">Xem sản phẩm</a>
    @endif
</div>
@endsection
