@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <h1>Danh sách đơn hàng</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tổng</th>
                <th>Trạng thái</th>
                <th>Phương thức thanh toán</th>
                <th>Ngày tạo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->payment_method }}</td>
                    <td>{{ $order->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
