<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TheaterController;
use App\Http\Controllers\ShowtimeController;
use App\Http\Controllers\ReservationController;

// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes (provided by Laravel)
Auth::routes();

// Movie Routes
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

// Showtime Routes
Route::get('/showtimes', [ShowtimeController::class, 'index'])->name('showtimes.index');
Route::get('/showtimes/movie/{movie}', [ShowtimeController::class, 'byMovie'])->name('showtimes.by-movie');
Route::get('/showtimes/type/{type}', [ShowtimeController::class, 'byType'])->name('showtimes.by-type');
Route::get('/showtimes/{showtime}', [ShowtimeController::class, 'show'])->name('showtimes.show');

// Reservation Routes (require authentication)
Route::middleware(['auth'])->group(function () {
    // User Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Reservations
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create/{showtime}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    
    // Checkout and Payment
    Route::get('/checkout/{reservation}', [PaymentController::class, 'checkout'])->name('checkout');
    Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
    
    // Tickets
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/download', [TicketController::class, 'download'])->name('tickets.download');
});

// Admin Routes (require admin role)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Movie Management
    Route::resource('movies', AdminMovieController::class);
    
    // Theater Management
    Route::resource('theaters', AdminTheaterController::class);
    
    // Showtime Management
    Route::resource('showtimes', AdminShowtimeController::class);
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    
    // Reports
    Route::get('/occupancy-rates', [AdminController::class, 'occupancyRates'])->name('occupancy-rates');
    Route::get('/movie-revenue', [AdminController::class, 'movieRevenue'])->name('movie-revenue');
    Route::get('/popular-movies', [AdminController::class, 'popularMovies'])->name('popular-movies');
});