@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Danh sách đơn hàng</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tổng</th>
                <th>Trạng thái</th>
                <th>Phương thức thanh toán</th>
                <th>Ngày tạo</th>
                <th>Hành động</th> <!-- Thêm cột Hành động -->
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ number_format($order->total, 2) }} VNĐ</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->payment_method }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>
                        <a href="{{ route('invoice.generate', $order->id) }}" class="btn btn-primary">
                            Xuất PDF
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
