<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Policies\EventPolicy;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    // List all events
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Event::with('user');

        // Filter based on user role
        if ($user->role === 'Organizer') {
            // Organizers can only see their own events
            $query->where('user_id', $user->id);
        }
        // Admin can see all events (no filter needed)

        $events = $query->get();
        return response()->json(['success' => true, 'data' => $events]);
    }

    // Show single event
    public function show(Request $request, $id)
    {
        $event = Event::with('user:id,name,role')->findOrFail($id);
        
        // Check authorization
        if (Gate::denies('view', $event)) {
            return response()->json(['success' => false, 'message' => 'Unauthorized to view this event'], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $event
        ]);
    }

public function getEventTypes()
{
    $types = Event::distinct()->pluck('type');
    return response()->json(['success' => true, 'data' => $types]);
}

    public function store(Request $request)
{
    if(!Gate::allows('create_event')) {
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    }

    // $this->authorize('create', Event::class);

    $data = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'type' => 'required|string|max:100',
        'date' => 'required|date',
        'location' => 'required|string|max:255',
        'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('poster')) {
        $data['poster'] = $request->file('poster')->store('posters', 'public');
    }

    $data['user_id'] = Auth::id();
    $event = Event::create($data);

    return response()->json(['success' => true, 'data' => $event]);
}

public function update(Request $request, Event $event)
{
    if (!Gate::allows('update_event', $event)) {
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    }

    $data = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'date' => 'required|date',
        'location' => 'required|string|max:255',
        'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'type' => 'required|string|max:100',
    ]);

    if ($request->hasFile('poster')) {
        if ($event->poster) Storage::disk('public')->delete($event->poster);
        $data['poster'] = $request->file('poster')->store('posters', 'public');
    }

    $event->update($data);

    return response()->json(['success' => true, 'data' => $event, 'message' => 'Event updated successfully']);
}

public function destroy(Event $event)
{
    $this->authorize('delete', $event);

    if ($event->poster) Storage::disk('public')->delete($event->poster);

    // إرسال إشعارات للمسجلين (يمكن استخدام Notifications)
    foreach ($event->attendees as $attendee) {
        $attendee->notify(new EventDeletedNotification($event));
    }

    $event->delete();

    return response()->json(['success' => true, 'message' => 'Event deleted successfully']);
}

}
