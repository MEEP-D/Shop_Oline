@extends('layouts.app')

@section('content')
<style>
    .table {
        margin-top: 20px;
        background-color: #f8f9fa; /* Màu nền cho bảng */
    }

    .table th, .table td {
        text-align: center; /* Căn giữa văn bản trong các ô */
    }

    .quantity-input {
        text-align: center; /* Căn giữa ô nhập số lượng */
    }

    .btn {
        margin-top: 5px; /* Khoảng cách cho nút */
    }

    .thead-dark th {
        background-color: #343a40; /* Màu nền cho tiêu đề bảng */
        color: white; /* Màu chữ cho tiêu đề bảng */
    }

    .d-flex {
        margin-top: 20px; /* Khoảng cách trên cho phần tổng tiền */
    }

    .alert {
        margin-top: 20px; /* Khoảng cách cho thông báo */
    }
</style>

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($cartItems && count($cartItems))
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
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
                @foreach($cartItems as $item)
                    @php
                        $subtotal = $item->price * $item->quantity; // Tính thành tiền
                        $total += $subtotal; 
                    @endphp
                    <tr>
                        <td>{{ $item->product->name }}</td> <!-- Lấy tên sản phẩm -->
                        <td>{{ $item->product->category->name }}</td> <!-- Lấy tên danh mục -->
                        <td>
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control quantity-input" style="width: 70px; display: inline;">
                                <button type="submit" class="btn btn-sm btn-secondary">Cập nhật</button>
                            </form>
                        </td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($subtotal, 2) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between mt-3">
            <div>
                <a href="{{ route('welcome') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
            </div>
            <div>
                <h4>Tổng tiền: <span class="text-success">${{ number_format($total, 2) }}</span></h4>
                <a href="{{ route('checkout.index') }}" class="btn btn-success">Thanh toán</a>
            </div>
        </div>
    @else
        <p>Giỏ hàng của bạn hiện tại đang trống. Hãy <a href="{{ route('welcome') }}">xem sản phẩm</a> để thêm vào giỏ hàng.</p>
        <a href="{{ route('welcome') }}" class="btn btn-primary">Xem sản phẩm</a>
    @endif
</div>
@endsection
