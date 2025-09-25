<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Events\OrderEvent;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * Admin: all orders, Organizer: orders for their events, Attendee: their own orders
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if (Gate::denies('viewAny', Order::class)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $query = Order::with(['user', 'event', 'orderItems.ticket']);

        // Filter based on user role
        if ($user->role === 'Organizer') {
            $query->whereHas('event', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        } elseif ($user->role === 'Attendee') {
            $query->where('user_id', $user->id);
        }

        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment_status if provided
        if ($request->has('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by event_id if provided
        if ($request->has('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        return response()->json([
            'message' => 'Orders fetched successfully',
            'data' => $orders
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     * Only attendees can create orders (purchase tickets)
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if (Gate::denies('create', Order::class)) {
            return response()->json(['message' => 'Unauthorized to create orders'], 403);
        }

        $validator = Validator::make($request->all(), [
            'event_id' => 'required|exists:events,id',
            'items' => 'required|array|min:1',
            'items.*.ticket_id' => 'required|exists:tickets,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $event = Event::findOrFail($request->event_id);

        // Validate that all tickets belong to the specified event
        $ticketIds = collect($request->items)->pluck('ticket_id');
        $tickets = Ticket::whereIn('id', $ticketIds)
            ->where('event_id', $request->event_id)
            ->get()
            ->keyBy('id');

        if ($tickets->count() !== $ticketIds->count()) {
            return response()->json([
                'message' => 'Some tickets do not belong to the specified event'
            ], 422);
        }

        // Check availability and calculate totals
        $subtotal = 0;
        $orderItems = [];

        foreach ($request->items as $item) {
            $ticket = $tickets[$item['ticket_id']];

            if ($ticket->remaining < $item['quantity']) {
                return response()->json([
                    'message' => "Not enough tickets available for {$ticket->type}. Available: {$ticket->remaining}, Requested: {$item['quantity']}"
                ], 422);
            }

            $itemTotal = $ticket->price * $item['quantity'];
            $subtotal += $itemTotal;

            $orderItems[] = [
                'ticket_id' => $ticket->id,
                'ticket_type' => $ticket->type,
                'unit_price' => $ticket->price,
                'quantity' => $item['quantity'],
                'total_price' => $itemTotal,
            ];
        }

        // Calculate fees
        $serviceFee = $subtotal * 0.05; // 5% service fee
        $taxAmount = $subtotal * 0.1; // 10% tax
        $totalAmount = $subtotal + $serviceFee + $taxAmount;

        try {
            DB::beginTransaction();

            // Create the order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => $user->id,
                'event_id' => $request->event_id,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method,
                'subtotal' => $subtotal,
                'service_fee' => $serviceFee,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($orderItems as $item) {
                $item['order_id'] = $order->id;
                OrderItem::create($item);
            }

            // Update ticket sold quantities
            foreach ($request->items as $item) {
                $ticket = $tickets[$item['ticket_id']];

                if ($ticket->remaining < $item['quantity']) {
                    DB::rollBack();
                    return response()->json([
                        'message' => "Not enough tickets available for {$ticket->type}. Available: {$ticket->remaining}, Requested: {$item['quantity']}"
                    ], 422);
                }

                $ticket->increment('sold', $item['quantity']);

                \Log::info("Ticket quantity updated", [
                    'ticket_id' => $ticket->id,
                    'ticket_type' => $ticket->type,
                    'quantity_sold' => $item['quantity'],
                    'new_sold_count' => $ticket->fresh()->sold,
                    'remaining' => $ticket->fresh()->remaining,
                    'order_id' => $order->id
                ]);
            }

            DB::commit();

            // Fire Pusher event (real-time broadcast if you want)
            event(new OrderEvent($order));

            // 🔔 Send notification to Admin
            $admin = \App\Models\User::where('role', 'Admin')->first();
            if ($admin) {
                $admin->notify(
                    new \App\Notifications\UserActionNotification(
                        "New order (#{$order->order_number}) was created by {$user->name} for event '{$event->title}'."
                    )
                );
            }

            return response()->json([
                'message' => 'Order created successfully',
                'data' => $order->load(['user', 'event', 'orderItems.ticket'])
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with(['user', 'event', 'orderItems.ticket'])->findOrFail($id);

        if (Gate::denies('view', $order)) {
            return response()->json(['message' => 'Unauthorized to view this order'], 403);
        }

        return response()->json([
            'message' => 'Order fetched successfully',
            'data' => $order
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     * Only Admin and Organizer can update orders
     */
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        if (Gate::denies('update', $order)) {
            return response()->json(['message' => 'Unauthorized to update this order'], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'sometimes|in:pending,confirmed,cancelled,refunded',
            'payment_status' => 'sometimes|in:pending,paid,failed,refunded',
            'payment_method' => 'sometimes|string|max:255',
            'payment_reference' => 'sometimes|string|max:255',
            'notes' => 'sometimes|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $order->update($request->only([
            'status', 'payment_status', 'payment_method', 'payment_reference', 'notes'
        ]));

        // Update timestamps based on status changes
        if ($request->has('status')) {
            if ($request->status === 'confirmed' && !$order->confirmed_at) {
                $order->update(['confirmed_at' => now()]);
            } elseif ($request->status === 'cancelled' && !$order->cancelled_at) {
                $order->update(['cancelled_at' => now()]);
            }
        }

        return response()->json([
            'message' => 'Order updated successfully',
            'data' => $order->load(['user', 'event', 'orderItems.ticket'])
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     * Only Admin can delete orders
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

        if (Gate::denies('delete', $order)) {
            return response()->json(['message' => 'Unauthorized to delete this order'], 403);
        }

        $order->delete();

        return response()->json([
            'message' => 'Order deleted successfully'
        ], 200);
    }

    /**
     * Cancel an order
     */
    public function cancel(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        if (Gate::denies('cancel', $order)) {
            return response()->json(['message' => 'Unauthorized to cancel this order'], 403);
        }

        if (!$order->canBeCancelled()) {
            return response()->json([
                'message' => 'This order cannot be cancelled'
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Update order status
            $order->update([
                'status' => 'cancelled',
                'cancelled_at' => now()
            ]);

            // Restore ticket quantities
            foreach ($order->orderItems as $item) {
                $ticket = $item->ticket;

                // Ensure we don't decrement below 0
                $newSoldCount = max(0, $ticket->sold - $item->quantity);
                $ticket->update(['sold' => $newSoldCount]);

                // Log the restoration for audit purposes
                \Log::info("Ticket quantity restored (cancellation)", [
                    'ticket_id' => $ticket->id,
                    'ticket_type' => $ticket->type,
                    'quantity_restored' => $item->quantity,
                    'new_sold_count' => $newSoldCount,
                    'remaining' => $ticket->fresh()->remaining,
                    'order_id' => $order->id
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Order cancelled successfully',
                'data' => $order->load(['user', 'event', 'orderItems.ticket'])
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to cancel order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Confirm an order
     */
    public function confirm(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        if (Gate::denies('confirm', $order)) {
            return response()->json(['message' => 'Unauthorized to confirm this order'], 403);
        }

        if ($order->status !== 'pending') {
            return response()->json([
                'message' => 'Only pending orders can be confirmed'
            ], 422);
        }

        $order->update([
            'status' => 'confirmed',
            'confirmed_at' => now()
        ]);

        return response()->json([
            'message' => 'Order confirmed successfully',
            'data' => $order->load(['user', 'event', 'orderItems.ticket'])
        ], 200);
    }

    /**
     * Refund an order
     */
    public function refund(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        if (Gate::denies('refund', $order)) {
            return response()->json(['message' => 'Unauthorized to refund this order'], 403);
        }

        if (!$order->canBeRefunded()) {
            return response()->json([
                'message' => 'This order cannot be refunded'
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Update order status
            $order->update([
                'status' => 'refunded',
                'payment_status' => 'refunded'
            ]);

            // Restore ticket quantities
            foreach ($order->orderItems as $item) {
                $ticket = $item->ticket;

                // Ensure we don't decrement below 0
                $newSoldCount = max(0, $ticket->sold - $item->quantity);
                $ticket->update(['sold' => $newSoldCount]);

                // Log the restoration for audit purposes
                \Log::info("Ticket quantity restored (refund)", [
                    'ticket_id' => $ticket->id,
                    'ticket_type' => $ticket->type,
                    'quantity_restored' => $item->quantity,
                    'new_sold_count' => $newSoldCount,
                    'remaining' => $ticket->fresh()->remaining,
                    'order_id' => $order->id
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Order refunded successfully',
                'data' => $order->load(['user', 'event', 'orderItems.ticket'])
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to refund order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's orders (for attendees)
     */
    public function userOrders(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'Attendee') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $query = $user->orders()->with(['event', 'orderItems.ticket']);

        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        return response()->json([
            'message' => 'User orders fetched successfully',
            'data' => $orders
        ], 200);
    }

    /**
     * Download tickets for a confirmed order
     */
public function downloadOrderDetails(Request $request, $id)
{
    try {
        $order = Order::with(['user', 'event', 'orderItems'])->findOrFail($id);

        // Check authorization
        if (Gate::denies('view', $order)) {
            return response()->json(['message' => 'Unauthorized to download order details'], 403);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('tickets.order-details', compact('order'));

        return $pdf->download("order_{$order->order_number}.pdf");
    } catch (\Exception $e) {
        \Log::error('PDF generation failed: '.$e->getMessage());
        return response()->json(['error' => 'Failed to generate PDF', 'details' => $e->getMessage()], 500);
    }
}

public function downloadTickets(Request $request, string $id)
{
    if ($request->has('token')) {
        $token = $request->get('token');
        $user = \Laravel\Sanctum\PersonalAccessToken::findToken($token)?->tokenable;

        if (!$user) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        auth()->setUser($user);
    }

    $order = Order::with(['user', 'event', 'orderItems.ticket'])->findOrFail($id);

    if (Gate::denies('view', $order)) {
        return response()->json(['message' => 'Unauthorized to download tickets for this order'], 403);
    }

    if ($order->status !== 'confirmed') {
        return response()->json([
            'message' => 'Tickets can only be downloaded for confirmed orders'
        ], 422);
    }

    try {
        $pdf = Pdf::loadView('tickets.pdf', ['order' => $order]);

        $filename = "tickets_{$order->order_number}.pdf";
        return $pdf->download($filename);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to generate tickets',
            'error' => $e->getMessage()
        ], 500);
    }
}



    /**
     * Generate HTML content for tickets
     */
    private function generateTicketHTML($order)
    {
        $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tickets - ' . $order->order_number . '</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .ticket { border: 2px solid #333; padding: 20px; margin: 20px 0; page-break-inside: avoid; }
        .header { text-align: center; margin-bottom: 20px; }
        .event-title { font-size: 24px; font-weight: bold; color: #333; }
        .order-info { background: #f5f5f5; padding: 15px; margin: 15px 0; }
        .ticket-item { border: 1px solid #ddd; padding: 15px; margin: 10px 0; }
        .qr-placeholder { width: 100px; height: 100px; border: 2px dashed #ccc; display: inline-block; text-align: center; line-height: 100px; }
        .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Event Tickets</h1>
        <p>Order Number: ' . $order->order_number . '</p>
    </div>

    <div class="order-info">
        <h2>' . $order->event->title . '</h2>
        <p><strong>Event Date:</strong> ' . $order->event->date . '</p>
        <p><strong>Location:</strong> ' . $order->event->location . '</p>
        <p><strong>Customer:</strong> ' . $order->user->name . '</p>
        <p><strong>Email:</strong> ' . $order->user->email . '</p>
        <p><strong>Order Date:</strong> ' . $order->created_at . '</p>
    </div>';

        foreach ($order->orderItems as $item) {
            for ($i = 0; $i < $item->quantity; $i++) {
                $ticketId = $order->order_number . '-' . $item->id . '-' . ($i + 1);
                $html .= '
    <div class="ticket">
        <div class="ticket-item">
            <h3>' . $item->ticket_type . '</h3>
            <p><strong>Ticket ID:</strong> ' . $ticketId . '</p>
            <p><strong>Price:</strong> $' . number_format($item->unit_price, 2) . '</p>
            <div class="qr-placeholder">QR Code</div>
            <p><strong>Instructions:</strong> Please present this ticket at the event entrance. Each ticket is valid for one person only.</p>
        </div>
    </div>';
            }
        }

        $html .= '
    <div class="footer">
        <p>Thank you for your purchase!</p>
        <p>For support, please contact us at support@example.com</p>
    </div>
</body>
</html>';

        return $html;
    }
}
