<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TicketController extends Controller
{
    /**
     * Display a listing of tickets for a specific event.
     */
    public function indexAll()
    {
        $tickets = Ticket::with('event.user')->get();

        return response()->json([
            'message' => 'All tickets with events and organizers fetched successfully',
            'data' => $tickets
        ], 200);
    }


    public function index($eventId)
    {
        $event = Event::findOrFail($eventId);

        // if (Gate::denies('viewAny', Ticket::class)) {
        //     return response()->json([
        //         'message' => 'Unauthorized'
        //     ], 403);
        // }

        $tickets = Ticket::where('event_id', $eventId)->get();

        return response()->json([
            'message' => 'Tickets fetched successfully',
            'data' => $tickets
        ],200);
    }

    /**
     * Store a newly created ticket for a specific event.
     */
    public function store(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);

        $ticket = new Ticket();
        $ticket->event_id = $eventId;

        if (Gate::denies('create', $ticket)) {
            return response()->json([
                'message' => 'Unauthorized to create ticket',
            ], 403);
        }

        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
        ]);

        $ticket->fill($validated);
        $ticket->sold = 0;
        $ticket->save();

        return response()->json([
            'message' => 'Ticket created successfully',
            'data' => $ticket
        ], 201);
    }

    /**
     * Display a specific ticket.
     */
    public function show($eventId, $ticketId)
    {
        $ticket = Ticket::where('event_id', $eventId)->findOrFail($ticketId);

        if (Gate::denies('view', $ticket)) {
            return response()->json([
                'message' => 'Unauthorized to view this ticket',
            ], 403);
        }

        return response()->json([
            'message' => 'Ticket fetched successfully',
            'data' => $ticket
        ],200);
    }

    /**
     * Update a ticket.
     */
    public function update(Request $request, $eventId, $ticketId)
    {
        $ticket = Ticket::where('event_id', $eventId)->findOrFail($ticketId);

        if (Gate::denies('update', $ticket)) {
            return response()->json([
                'message' => 'Unauthorized to update this ticket',
                'status' => 403
            ], 403);
        }

        $validated = $request->validate([
            'type' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0',
            'quantity' => 'sometimes|integer|min:1',
        ]);

        if (isset($validated['quantity']) && $validated['quantity'] < $ticket->sold) {
            return response()->json([
                'message' => 'Quantity cannot be less than sold tickets',
            ], 422);
        }

        $ticket->update($validated);

        return response()->json([
            'message' => 'Ticket updated successfully',
            'data' => $ticket
        ],200);
    }

    /**
     * Delete a ticket.
     */
    public function destroy($eventId, $ticketId)
    {
        $ticket = Ticket::where('event_id', $eventId)->findOrFail($ticketId);

        if (Gate::denies('delete', $ticket)) {
            return response()->json([
                'message' => 'Unauthorized to delete this ticket',
            ], 403);
        }

        if ($ticket->sold > 0) {
            return response()->json([
                'message' => 'Cannot delete ticket type with sales',
            ], 422);
        }

        $ticket->delete();

        return response()->json([
            'message' => 'Ticket deleted successfully',
        ],200);
    }
}
