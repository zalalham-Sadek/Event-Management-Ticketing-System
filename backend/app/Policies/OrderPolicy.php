<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Determine whether the user can view any models.
     * Admin can view all orders, Organizer can view orders for their events, Attendee can view their own orders
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['Admin', 'Organizer', 'Attendee']);
    }

    /**
     * Determine whether the user can view the model.
     * Admin can view all orders, Organizer can view orders for their events, Attendee can view their own orders
     */
    public function view(User $user, Order $order): bool
    {
        if ($user->role === 'Admin') {
            return true;
        }

        if ($user->role === 'Organizer') {
            return $user->id === $order->event->user_id;
        }

        if ($user->role === 'Attendee') {
            return $user->id === $order->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     * Only attendees can create orders (purchase tickets)
     */
    public function create(User $user): bool
    {
        return $user->role === 'Attendee';
    }

    /**
     * Determine whether the user can update the model.
     * Admin can update any order, Organizer can update orders for their events, Attendee can update their own orders
     */
    public function update(User $user, Order $order): bool
    {
        if ($user->role === 'Admin') {
            return true;
        }

        if ($user->role === 'Organizer') {
            return $user->id === $order->event->user_id;
        }

        if ($user->role === 'Attendee') {
            return $user->id === $order->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     * Only Admin can delete orders
     */
    public function delete(User $user, Order $order): bool
    {
        return $user->role === 'Admin';
    }

    /**
     * Determine whether the user can cancel the order.
     * Admin can cancel any order, Organizer can cancel orders for their events, Attendee can cancel their own pending orders
     */
    public function cancel(User $user, Order $order): bool
    {
        if ($user->role === 'Admin') {
            return true;
        }

        if ($user->role === 'Organizer') {
            return $user->id === $order->event->user_id;
        }

        if ($user->role === 'Attendee') {
            return $user->id === $order->user_id && $order->canBeCancelled();
        }

        return false;
    }

    /**
     * Determine whether the user can confirm the order.
     * Admin and Organizer can confirm orders for their events
     */
    public function confirm(User $user, Order $order): bool
    {
        if ($user->role === 'Admin') {
            return true;
        }

        if ($user->role === 'Organizer') {
            return $user->id === $order->event->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can refund the order.
     * Admin and Organizer can refund orders for their events
     */
    public function refund(User $user, Order $order): bool
    {
        if ($user->role === 'Admin') {
            return true;
        }

        if ($user->role === 'Organizer') {
            return $user->id === $order->event->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Order $order): bool
    {
        return $user->role === 'Admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Order $order): bool
    {
        return $user->role === 'Admin';
    }
}
