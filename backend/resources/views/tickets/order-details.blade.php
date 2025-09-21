<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Details</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        .table th { background: #f2f2f2; }
        h2, h3 { margin: 5px 0; }
    </style>
</head>
<body>
    <h2>Order #{{ $order->order_number }}</h2>
    <p><strong>Status:</strong> {{ $order->status }}</p>
    <p><strong>Payment:</strong> {{ $order->payment_status }}</p>
    <p><strong>Created:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>

    <h3>Customer Info</h3>
    <p>Name: {{ $order->user->name }}</p>
    <p>Email: {{ $order->user->email }}</p>
    <p>Phone: {{ $order->user->phone ?? 'N/A' }}</p>

    <h3>Event Info</h3>
    <p>Title: {{ $order->event->title }}</p>
    <p>Date: {{ $order->event->date }}</p>
    <p>Location: {{ $order->event->location }}</p>

    <h3>Order Items</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Ticket Type</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($order->orderItems as $item)
            <tr>
                <td>{{ $item->ticket_type }}</td>
                <td>${{ number_format($item->unit_price, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->total_price, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h3>Summary</h3>
    <p>Subtotal: ${{ number_format($order->subtotal, 2) }}</p>
    <p>Service Fee: ${{ number_format($order->service_fee, 2) }}</p>
    <p>Tax: ${{ number_format($order->tax_amount, 2) }}</p>
    <h3>Total: ${{ number_format($order->total_amount, 2) }}</h3>
</body>
</html>
