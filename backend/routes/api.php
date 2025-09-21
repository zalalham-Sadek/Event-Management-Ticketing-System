<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\StatisticsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/setup-admin', [AuthController::class, 'checkSetup']);
Route::post('/setup-admin', [AuthController::class, 'setAdmin']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // User routes
    Route::apiResource('users', UserController::class);
    
    // Event routes
    Route::apiResource('events', EventController::class);
    Route::get('/event-types', [EventController::class, 'getEventTypes']);
    
    // Statistics routes
    Route::get('/statistics/dashboard', [StatisticsController::class, 'getDashboardStats']);
    
    // Ticket routes
    Route::get('/tickets', [TicketController::class, 'indexAll']);
    Route::prefix('events/{eventId}')->group(function () {
        Route::get('tickets', [TicketController::class, 'index']);
        Route::post('tickets', [TicketController::class, 'store']);
        Route::get('tickets/{ticketId}', [TicketController::class, 'show']);
        Route::put('tickets/{ticketId}', [TicketController::class, 'update']);
        Route::delete('tickets/{ticketId}', [TicketController::class, 'destroy']);
    });

    // Order routes
    Route::apiResource('orders', OrderController::class);
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel']);
    Route::post('/orders/{id}/confirm', [OrderController::class, 'confirm']);
    Route::post('/orders/{id}/refund', [OrderController::class, 'refund']);
    Route::get('/orders/{id}/download-tickets', [OrderController::class, 'downloadTickets']);
    Route::get('/orders/{id}/download-details', [OrderController::class, 'downloadOrderDetails']);
    Route::get('/user/orders', [OrderController::class, 'userOrders']);
});
