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
    <form id="checkoutForm" method="POST" action="{{ route('order.store') }}">
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
                        <input type="number" name="quantity[]" value="{{ $cartItem->quantity }}" min="1" class="form-control me-2" style="width: 80px;">
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

    <div class="d-flex justify-content-between align-items-center mt-3">
        <div>
            <h5>Tổng Tiền Giỏ Hàng: 
                <span id="totalAmount">0 VNĐ</span>
            </h5>
            <input type="hidden" name="total" id="totalAmountInput" value="0">
        </div>
        <div class="form-group">
            <label for="payment_method">Phương thức thanh toán:</label>
            <select name="payment_method" id="payment_method" class="form-control">
                <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                <option value="credit_card">Thẻ tín dụng</option>
                <option value="paypal">PayPal</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success" id="checkoutButton" disabled>Đặt Hàng</button>
    </div>
    <form action="{{ route('cart.clear') }}" method="POST" class="mt-2">
    @csrf
    <button type="submit" class="btn btn-danger">Xóa Giỏ Hàng</button>
</form>
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
        document.getElementById('totalAmountInput').value = total; // Cập nhật giá trị vào input ẩn

        // Kích hoạt nút thanh toán nếu tổng tiền lớn hơn 0
        const checkoutButton = document.getElementById('checkoutButton');
        checkoutButton.disabled = total <= 0; // Bỏ khóa nút nếu tổng tiền > 0
    }

    // Thêm sự kiện cho các ô tích
    document.querySelectorAll('.product-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', calculateTotal);
    });

    // Gọi hàm tính tổng khi trang được tải
    document.addEventListener('DOMContentLoaded', function() {
        calculateTotal(); // Gọi ngay khi tải trang
    });
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