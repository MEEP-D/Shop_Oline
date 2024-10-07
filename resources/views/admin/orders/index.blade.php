@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">Danh sách Đơn hàng</h1>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên Khách Hàng</th>
                    <th>Tổng</th>
                    <th>Trạng thái</th>
                    <th>Phương thức thanh toán</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ number_format($order->total, 2) }} VNĐ</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>{{ ucfirst($order->payment_method) }}</td>
                        <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                        <td>
                            @if($order->status == 'paid') <!-- Kiểm tra trạng thái -->
                                <span class="text-muted">Trạng thái không thể thay đổi</span>
                            @else
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <div class="input-group">
                                        <select name="status" class="form-control" required>
                                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                            <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-warning">Cập nhật</button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Hiển thị phân trang nếu có -->
    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item {{ $orders->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $orders->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $orders->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach

                <li class="page-item {{ $orders->onLastPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $orders->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
@endsection
