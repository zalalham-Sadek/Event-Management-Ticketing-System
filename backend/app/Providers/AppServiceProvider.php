<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Order;
use App\Policies\EventPolicy;
use App\Policies\TicketPolicy;
use App\Policies\OrderPolicy;
class AppServiceProvider extends ServiceProvider
{


    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    Gate::define('create_event',[EventPolicy::class,'create']);
    Gate::define('update_event',[EventPolicy::class,'update']);
    Gate::define('all_tickets',[TicketPolicy::class,'viewAny']);
    Gate::define('create_ticket',[TicketPolicy::class,'create']);
    Gate::define('update_ticket',[TicketPolicy::class,'update']);
    
    // Register model policies
    Gate::policy(Event::class, EventPolicy::class);
    Gate::policy(Ticket::class, TicketPolicy::class);
    Gate::policy(Order::class, OrderPolicy::class);
    }
}
