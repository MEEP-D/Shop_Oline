<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .invoice {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            margin: 20px auto;
            width: 80%;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .invoice-header,
        .invoice-footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-details {
            margin: 20px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        h2 {
            color: #007bff;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .total-amount {
            font-weight: bold;
            font-size: 1.2em;
            color: #d9534f; /* Màu đỏ cho tổng tiền */
        }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="invoice-header">
            <h1>Hoa Don #{{ $order->id }}</h1>
            <p>Ngay Thang: {{ $order->created_at->format('d/m/Y') }}</p>
        </div>
        <div class="invoice-details">
            <h2>Thong Tin Khach Hang</h2>
            <p><strong>Ten:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
        </div>
        <h2>Thong Tin San Pham</h2>
        <table>
            <thead>
                <tr>
                    <th>San Pham</th>
                    <th>So Luong</th>
                    <th>Gia</th>
                    <th>Tong</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td> <!-- Giả sử $item có thuộc tính product -->
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price, 2) }} VND</td>
                        <td>{{ number_format($item->price, 2) }} VND</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="invoice-footer">
            <h3 class="total-amount">Tong Tien: {{ number_format($order->total, 2) }} VND</h3>
        </div>
    </div>
</body>
</html>
