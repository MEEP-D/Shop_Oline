@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-4">Giỏ Hàng</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($cartItems->isEmpty())
        <div class="alert alert-warning">
            Giỏ hàng của bạn hiện đang trống.
        </div>
    @else
        <form id="checkoutForm" method="POST" action="{{ route('checkout.process') }}">
            @csrf
            <table class="table table-bordered table-striped mt-4">
                <thead class="table-light">
                    <tr>
                        <th></th>
                        <th>Tên Sản Phẩm</th>
                        <th>Số Lượng</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $cartItem)
                        <tr>
                            <td>
                                <input type="checkbox" name="selected_products[]" value="{{ $cartItem->product_id }}" class="product-checkbox" data-price="{{ $cartItem->product->price * $cartItem->quantity }}">
                            </td>
                            <td>{{ $cartItem->product->name }}</td>
                            <td>
    <form action="{{ route('cart.update', $cartItem->product_id) }}" method="POST" class="d-flex align-items-center">
        @csrf
        <input type="number" name="quantity" value="{{ $cartItem->quantity }}" min="1" class="form-control me-2" style="width: 80px;">
        <button type="submit" class="btn btn-sm btn-outline-primary">Cập Nhật</button>
    </form>
</td>

                            <td>{{ number_format($cartItem->product->price, 0, ',', '.') }} VNĐ</td>
                            <td>{{ number_format($cartItem->product->price * $cartItem->quantity, 0, ',', '.') }} VNĐ</td>
                            <td>
                                <form action="{{ route('cart.remove', $cartItem->product_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Xoá</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between mt-3">
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Làm Sạch Giỏ Hàng</button>
                </form>

                <div>
                    <h5>Tổng Tiền Giỏ Hàng: 
                        <span id="totalAmount">0 VNĐ</span>
                    </h5>
                    <button type="submit" class="btn btn-success" id="checkoutButton">Tiến Hành Thanh Toán</button>
                </div>
            </div>
        </form>
    @endif
</div>

<script>
    // Hàm tính tổng tiền
    function calculateTotal() {
        let total = 0;
        const checkboxes = document.querySelectorAll('.product-checkbox:checked');

        checkboxes.forEach(checkbox => {
            const price = parseFloat(checkbox.getAttribute('data-price'));
            total += price; // Cộng tổng tiền
        });

        document.getElementById('totalAmount').innerText = total.toLocaleString('en-US') + ' VNĐ'; // Cập nhật tổng tiền
    }

    // Thêm sự kiện cho các ô tích
    document.querySelectorAll('.product-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', calculateTotal);
    });

    // Gọi hàm tính tổng khi trang được tải
    document.addEventListener('DOMContentLoaded', calculateTotal);
</script>

<style>
    /* Tùy chỉnh CSS cho bảng giỏ hàng */
    table {
        border-radius: 10px;
        overflow: hidden;
    }

    th {
        text-align: center;
    }

    td {
        vertical-align: middle;
    }

    .btn-outline-primary {
        border-color: #007bff;
        color: #007bff;
    }

    .btn-outline-danger {
        border-color: #dc3545;
        color: #dc3545;
    }

    .btn-outline-primary:hover,
    .btn-outline-danger:hover {
        filter: brightness(0.9);
    }
</style>
@endsection
