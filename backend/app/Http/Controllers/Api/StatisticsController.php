<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * Get dashboard statistics based on user role
     */
    public function getDashboardStats(Request $request)
    {
        try {
            $user = $request->user();
            $stats = [];

            if ($user->role === 'Admin') {
                // Admin sees all statistics
                $stats = $this->getAdminStats();
            } elseif ($user->role === 'Organizer') {
                // Organizer sees only their own statistics
                $stats = $this->getOrganizerStats($user->id);
            } else {
                // Attendee sees basic statistics
                $stats = $this->getAttendeeStats($user->id);
            }

            return response()->json([
                'success' => true,
                'data' => $stats
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Statistics error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get statistics for Admin (all data)
     */
    private function getAdminStats()
    {
        return [
            // Event Statistics
            'events' => [
                'total' => Event::count(),
                'upcoming' => Event::where('date', '>', now())->count(),
                'past' => Event::where('date', '<', now())->count(),
                'this_month' => Event::whereMonth('date', now()->month)
                    ->whereYear('date', now()->year)->count(),
            ],

            // Order Statistics
            'orders' => [
                'total' => Order::count(),
                'pending' => Order::where('status', 'pending')->count(),
                'confirmed' => Order::where('status', 'confirmed')->count(),
                'cancelled' => Order::where('status', 'cancelled')->count(),
                'refunded' => Order::where('status', 'refunded')->count(),
                'this_month' => Order::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)->count(),
            ],

            // Revenue Statistics
            'revenue' => [
                'total' => Order::where('payment_status', 'paid')->sum('total_amount') ?? 0,
                'this_month' => Order::where('payment_status', 'paid')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->sum('total_amount') ?? 0,
                'pending' => Order::where('payment_status', 'pending')->sum('total_amount') ?? 0,
            ],

            // Ticket Statistics
            'tickets' => [
                'total_available' => Ticket::sum('quantity') ?? 0,
                'total_sold' => Ticket::sum('sold') ?? 0,
                'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount') ?? 0,
            ],

            // User Statistics
            'users' => [
                'total' => User::count(),
                'organizers' => User::where('role', 'Organizer')->count(),
                'attendees' => User::where('role', 'Attendee')->count(),
                'new_this_month' => User::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)->count(),
            ],

            // Top Events by Revenue
            'top_events' => $this->getTopEventsByRevenue(),

            // Events by Location
            'events_by_location' => $this->getEventsByLocation(),

            // Monthly Revenue Trend
            'monthly_revenue' => $this->getMonthlyRevenueTrend(),

            // Order Status Distribution
            'order_status_distribution' => $this->getOrderStatusDistribution(),
        ];
    }

    /**
     * Get statistics for Organizer (only their events)
     */
    private function getOrganizerStats($userId)
    {
        return [
            // Event Statistics (only organizer's events)
            'events' => [
                'total' => Event::where('user_id', $userId)->count(),
                'upcoming' => Event::where('user_id', $userId)
                    ->where('date', '>', now())->count(),
                'past' => Event::where('user_id', $userId)
                    ->where('date', '<', now())->count(),
                'this_month' => Event::where('user_id', $userId)
                    ->whereMonth('date', now()->month)
                    ->whereYear('date', now()->year)->count(),
            ],

            // Order Statistics (only orders for organizer's events)
            'orders' => [
                'total' => Order::whereHas('event', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->count(),
                'pending' => Order::whereHas('event', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->where('status', 'pending')->count(),
                'confirmed' => Order::whereHas('event', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->where('status', 'confirmed')->count(),
                'cancelled' => Order::whereHas('event', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->where('status', 'cancelled')->count(),
                'refunded' => Order::whereHas('event', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->where('status', 'refunded')->count(),
                'this_month' => Order::whereHas('event', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)->count(),
            ],

            // Revenue Statistics (only from organizer's events)
            'revenue' => [
                'total' => Order::whereHas('event', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->where('payment_status', 'paid')->sum('total_amount'),
                'this_month' => Order::whereHas('event', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->where('payment_status', 'paid')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->sum('total_amount'),
                'pending' => Order::whereHas('event', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->where('payment_status', 'pending')->sum('total_amount'),
            ],

            // Ticket Statistics (only organizer's events)
            'tickets' => [
                'total_available' => Ticket::whereHas('event', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->sum('quantity'),
                'total_sold' => Ticket::whereHas('event', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->sum('sold'),
                'total_revenue' => Order::whereHas('event', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->where('payment_status', 'paid')
                    ->with('orderItems')
                    ->get()
                    ->sum(function ($order) {
                        return $order->orderItems->sum('total_price');
                    }),
            ],

            // Top Events by Revenue (only organizer's events)
            'top_events' => $this->getTopEventsByRevenue($userId),

            // Events by Location (only organizer's events)
            'events_by_location' => $this->getEventsByLocation($userId),

            // Monthly Revenue Trend (only organizer's events)
            'monthly_revenue' => $this->getMonthlyRevenueTrend($userId),

            // Order Status Distribution (only organizer's events)
            'order_status_distribution' => $this->getOrderStatusDistribution($userId),
        ];
    }

    /**
     * Get statistics for Attendee (only their orders)
     */
    private function getAttendeeStats($userId)
    {
        return [
            // Order Statistics (only attendee's orders)
            'orders' => [
                'total' => Order::where('user_id', $userId)->count(),
                'pending' => Order::where('user_id', $userId)->where('status', 'pending')->count(),
                'confirmed' => Order::where('user_id', $userId)->where('status', 'confirmed')->count(),
                'cancelled' => Order::where('user_id', $userId)->where('status', 'cancelled')->count(),
                'refunded' => Order::where('user_id', $userId)->where('status', 'refunded')->count(),
                'this_month' => Order::where('user_id', $userId)
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)->count(),
            ],

            // Spending Statistics
            'spending' => [
                'total' => Order::where('user_id', $userId)->where('payment_status', 'paid')->sum('total_amount'),
                'this_month' => Order::where('user_id', $userId)->where('payment_status', 'paid')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->sum('total_amount'),
                'average_per_order' => Order::where('user_id', $userId)->where('payment_status', 'paid')->avg('total_amount'),
            ],

            // Event Statistics (events they've attended)
            'events_attended' => [
                'total' => Order::where('user_id', $userId)->where('status', 'confirmed')->count(),
                'upcoming' => Order::where('user_id', $userId)
                    ->where('status', 'confirmed')
                    ->whereHas('event', function ($q) {
                        $q->where('date', '>', now());
                    })->count(),
            ],

            // Recent Orders
            'recent_orders' => Order::where('user_id', $userId)
                ->with(['event:id,title,date', 'orderItems'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
        ];
    }

    /**
     * Get top events by revenue
     */
    private function getTopEventsByRevenue($userId = null)
    {
        try {
            $query = Event::withSum(['orders as total_revenue' => function ($q) {
                $q->where('payment_status', 'paid');
            }], 'total_amount')
                ->orderBy('total_revenue', 'desc')
                ->limit(5);

            if ($userId) {
                $query->where('user_id', $userId);
            }

            return $query->get(['id', 'title', 'date', 'total_revenue']);
        } catch (\Exception $e) {
            \Log::error('Top events error: ' . $e->getMessage());
            return collect([]);
        }
    }

    /**
     * Get events by location
     */
    private function getEventsByLocation($userId = null)
    {
        try {
            $query = Event::select('location', DB::raw('count(*) as count'))
                ->groupBy('location')
                ->orderBy('count', 'desc');

            if ($userId) {
                $query->where('user_id', $userId);
            }

            return $query->get();
        } catch (\Exception $e) {
            \Log::error('Events by location error: ' . $e->getMessage());
            return collect([]);
        }
    }

    /**
     * Get monthly revenue trend
     */
    private function getMonthlyRevenueTrend($userId = null)
    {
        try {
            $query = Order::select(
                    DB::raw('strftime("%Y", created_at) as year'),
                    DB::raw('strftime("%m", created_at) as month'),
                    DB::raw('SUM(total_amount) as revenue')
                )
                ->where('payment_status', 'paid')
                ->where('created_at', '>=', now()->subMonths(12))
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc');

            if ($userId) {
                $query->whereHas('event', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                });
            }

            return $query->get();
        } catch (\Exception $e) {
            \Log::error('Monthly revenue trend error: ' . $e->getMessage());
            return collect([]);
        }
    }

    /**
     * Get order status distribution
     */
    private function getOrderStatusDistribution($userId = null)
    {
        try {
            $query = Order::select('status', DB::raw('count(*) as count'))
                ->groupBy('status');

            if ($userId) {
                $query->whereHas('event', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                });
            }

            return $query->get();
        } catch (\Exception $e) {
            \Log::error('Order status distribution error: ' . $e->getMessage());
            return collect([]);
        }
    }
}
