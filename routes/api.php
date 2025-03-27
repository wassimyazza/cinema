<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ShowtimeController;
use App\Http\Controllers\TheaterController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminController;

/*
|----------------------------------------------------------------------
| API Routes
|----------------------------------------------------------------------
*/

// Auth Routes - No authentication needed for these
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Authenticated routes (only available when logged in)
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
    Route::put('profile', [AuthController::class, 'updateProfile']);
    Route::delete('account', [AuthController::class, 'deleteAccount']);
});

// Movie Routes (Public, no authentication needed)
Route::apiResource('movies', MovieController::class);

// Showtime Routes (Public, no authentication needed)
Route::get('showtimes/movie/{movieId}', [ShowtimeController::class, 'byMovie']);
Route::get('showtimes/type/{type}', [ShowtimeController::class, 'byType']);
Route::apiResource('showtimes', ShowtimeController::class);

// Theater Routes (Public, no authentication needed)
Route::get('theaters/type/{type}', [TheaterController::class, 'byType']);
Route::apiResource('theaters', TheaterController::class);

// Seat Routes (Public, no authentication needed)
Route::get('seats/theater/{theaterId}', [SeatController::class, 'byTheater']);
Route::get('seats/available/{showtimeId}', [SeatController::class, 'availableByShowtime']);
Route::apiResource('seats', SeatController::class);

// Reservation Routes (Public, no authentication needed)
Route::apiResource('reservations', ReservationController::class);

// Payment Routes (Public, no authentication needed)
Route::post('payments/create-intent', [PaymentController::class, 'createPaymentIntent']);
Route::post('payments/webhook', [PaymentController::class, 'handleWebhook']);

// Ticket Routes (Public, no authentication needed)
Route::get('tickets/{id}', [TicketController::class, 'show']);
Route::get('tickets/reservation/{reservationId}', [TicketController::class, 'getByReservation']);
Route::get('tickets/{id}/download', [TicketController::class, 'download']);

// Admin Routes (Require authentication and role)
Route::group(['middleware' => ['auth:api', 'role:admin']], function () {
    Route::get('dashboard', [AdminController::class, 'dashboard']);
    Route::get('occupancy-rates', [AdminController::class, 'occupancyRates']);
    Route::get('movie-revenue', [AdminController::class, 'movieRevenue']);
    Route::get('popular-movies', [AdminController::class, 'popularMovies']);
    Route::get('users', [AdminController::class, 'users']);
});
