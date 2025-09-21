<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tickets - {{ $order->order_number }}</title>
    <style>
        /* General Reset */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; line-height: 1.5; color: #333; }

        /* Header */
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { font-size: 28px; color: #2c3e50; margin-bottom: 5px; }
        .header p { font-size: 14px; color: #7f8c8d; }

        /* Event Info */
        .event-info {
            background: #f8f9fa;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 6px;
        }
        .event-info h2 { font-size: 20px; margin-bottom: 8px; color: #2c3e50; }
        .event-info p { margin: 4px 0; }

        /* Ticket Card */
        .ticket {
            border: 2px dashed #2c3e50;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 8px;
            page-break-inside: avoid;
            background: #fff;
        }
        .ticket h3 {
            font-size: 18px;
            color: #16a085;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .ticket p { margin: 5px 0; }

        /* QR Placeholder */
        .qr {
            width: 100px;
            height: 100px;
            border: 2px solid #bbb;
            display: inline-block;
            text-align: center;
            line-height: 100px;
            font-size: 12px;
            color: #999;
            margin-top: 10px;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>🎟 Event Tickets</h1>
        <p>Order Number: {{ $order->order_number }}</p>
    </div>

    <!-- Event Info -->
    <div class="event-info">
        <h2>{{ $order->event->title }}</h2>
        <p><strong>Date:</strong> {{ $order->event->date }}</p>
        <p><strong>Location:</strong> {{ $order->event->location }}</p>
        <p><strong>Customer:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
        <p><strong>Order Date:</strong> {{ $order->created_at }}</p>
    </div>

    <!-- Tickets -->
    @foreach($order->orderItems as $item)
        @for($i = 0; $i < $item->quantity; $i++)
            @php
                $ticketId = $order->order_number . '-' . $item->id . '-' . ($i + 1);
            @endphp

            <div class="ticket">
                <h3>{{ $item->ticket_type }}</h3>
                <p><strong>Ticket ID:</strong> {{ $ticketId }}</p>
                <p><strong>Price:</strong> ${{ number_format($item->unit_price, 2) }}</p>
                <div class="qr">QR CODE</div>
                <p><strong>Instructions:</strong> Please present this ticket at the event entrance. One ticket = one person.</p>
            </div>
        @endfor
    @endforeach

    <!-- Footer -->
    <div class="footer">
        <p>Thank you for your purchase! 🎉</p>
        <p>For support, contact <strong>support@example.com</strong></p>
    </div>
</body>
</html>
