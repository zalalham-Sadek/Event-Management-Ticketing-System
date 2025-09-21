<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['Admin', 'Organizer']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        // All authenticated users can view tickets (for browsing and purchasing)
        return in_array($user->role, ['Admin', 'Organizer', 'Attendee']);
    }

    /**
     * إنشاء تذكرة جديدة
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['Admin', 'Organizer']);
    }

    /**
     * تعديل تذكرة
     */
    public function update(User $user, Ticket $ticket): bool
    {
        return $user->role === 'Admin'
            || ($user->role === 'Organizer' && $user->id === $ticket->event->user_id);
    }

    /**
     * حذف تذكرة
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->role === 'Admin'
            || ($user->role === 'Organizer' && $user->id === $ticket->event->user_id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ticket $ticket): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ticket $ticket): bool
    {
        return false;
    }
}
