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
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Auth Routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
    Route::put('profile', [AuthController::class, 'updateProfile']);
    Route::delete('account', [AuthController::class, 'deleteAccount']);
});

// Movie Routes
Route::apiResource('movies', MovieController::class);

// Showtime Routes
Route::get('showtimes/movie/{movieId}', [ShowtimeController::class, 'byMovie']);
Route::get('showtimes/type/{type}', [ShowtimeController::class, 'byType']);
Route::apiResource('showtimes', ShowtimeController::class);

// Theater Routes
Route::get('theaters/type/{type}', [TheaterController::class, 'byType']);
Route::apiResource('theaters', TheaterController::class);

// Seat Routes
Route::get('seats/theater/{theaterId}', [SeatController::class, 'byTheater']);
Route::get('seats/available/{showtimeId}', [SeatController::class, 'availableByShowtime']);
Route::apiResource('seats', SeatController::class);

// Reservation Routes
Route::apiResource('reservations', ReservationController::class);

// Payment Routes
Route::post('payments/create-intent', [PaymentController::class, 'createPaymentIntent']);
Route::post('payments/webhook', [PaymentController::class, 'handleWebhook']);

// Ticket Routes
Route::get('tickets/{id}', [TicketController::class, 'show']);
Route::get('tickets/reservation/{reservationId}', [TicketController::class, 'getByReservation']);
Route::get('tickets/{id}/download', [TicketController::class, 'download']);

// Admin Routes
Route::group(['prefix' => 'admin'], function () {
    Route::get('dashboard', [AdminController::class, 'dashboard']);
    Route::get('occupancy-rates', [AdminController::class, 'occupancyRates']);
    Route::get('movie-revenue', [AdminController::class, 'movieRevenue']);
    Route::get('popular-movies', [AdminController::class, 'popularMovies']);
    Route::get('users', [AdminController::class, 'users']);
});