<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Event $event): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
 public function create(User $user) {
        return in_array($user->role, ['Admin', 'Organizer']);
    }

    public function update(User $user, Event $event) {
        return $user->role === 'Admin' || $user->id === $event->user_id;
    }

    public function delete(User $user, Event $event) {
        return $user->role === 'Admin' || $user->id === $event->user_id;
    }


    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Event $event): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Event $event): bool
    {
        return false;
    }
}
