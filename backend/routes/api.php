<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\TicketController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/setup-admin', [AuthController::class, 'checkSetup']);
Route::post('/setup-admin', [AuthController::class, 'setAdmin']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

// Routes محمية
    Route::get('/tickets', [TicketController::class, 'indexAll']); // new
Route::prefix('events/{eventId}')->group(function () {
    Route::get('tickets', [TicketController::class, 'index']);
});
Route::get('/events/{id}', [EventController::class, 'show']);// new
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('users', UserController::class);
    Route::apiResource('events',EventController::class);
    Route::get('/event-types', [EventController::class, 'getEventTypes']);// new

Route::prefix('events/{eventId}')->group(function () {
    Route::post('tickets', [TicketController::class, 'store']);
    Route::get('tickets/{ticketId}', [TicketController::class, 'show']);
    Route::put('tickets/{ticketId}', [TicketController::class, 'update']);
    Route::delete('tickets/{ticketId}', [TicketController::class, 'destroy']);
});

});
