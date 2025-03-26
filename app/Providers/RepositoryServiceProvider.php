<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use App\Repositories\Eloquent\MovieRepository;
use App\Repositories\Interfaces\ShowtimeRepositoryInterface;
use App\Repositories\Eloquent\ShowtimeRepository;
use App\Repositories\Interfaces\TheaterRepositoryInterface;
use App\Repositories\Eloquent\TheaterRepository;
use App\Repositories\Interfaces\SeatRepositoryInterface;
use App\Repositories\Eloquent\SeatRepository;
use App\Repositories\Interfaces\ReservationRepositoryInterface;
use App\Repositories\Eloquent\ReservationRepository;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Repositories\Eloquent\TicketRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(MovieRepositoryInterface::class, MovieRepository::class);
        $this->app->bind(ShowtimeRepositoryInterface::class, ShowtimeRepository::class);
        $this->app->bind(TheaterRepositoryInterface::class, TheaterRepository::class);
        $this->app->bind(SeatRepositoryInterface::class, SeatRepository::class);
        $this->app->bind(ReservationRepositoryInterface::class, ReservationRepository::class);
        $this->app->bind(TicketRepositoryInterface::class, TicketRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}