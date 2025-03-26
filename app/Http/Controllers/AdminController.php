<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\MovieService;
use App\Services\ShowtimeService;
use App\Services\ReservationService;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    protected $userService;
    protected $movieService;
    protected $showtimeService;
    protected $reservationService;

    public function __construct(
        UserService $userService,
        MovieService $movieService,
        ShowtimeService $showtimeService,
        ReservationService $reservationService
    ) {
        $this->userService = $userService;
        $this->movieService = $movieService;
        $this->showtimeService = $showtimeService;
        $this->reservationService = $reservationService;
        
        $this->middleware('auth:api');
        $this->middleware('admin');
    }

    public function dashboard()
    {
        // Get counts
        $userCount = DB::table('users')->count();
        $movieCount = DB::table('movies')->count();
        $showtimeCount = DB::table('showtimes')->count();
        $reservationCount = DB::table('reservations')->count();
        $paidReservationCount = DB::table('reservations')->where('status', 'paid')->count();
        
        // Get revenue
        $totalRevenue = DB::table('reservations')
            ->where('status', 'paid')
            ->sum('total_price');
        
        return response()->json([
            'user_count' => $userCount,
            'movie_count' => $movieCount,
            'showtime_count' => $showtimeCount,
            'reservation_count' => $reservationCount,
            'paid_reservation_count' => $paidReservationCount,
            'total_revenue' => $totalRevenue,
        ]);
    }

    public function occupancyRates()
    {
        $showtimes = DB::table('showtimes')
            ->select(
                'showtimes.id',
                'movies.title as movie_title',
                'theaters.name as theater_name',
                'showtimes.start_time',
                'theaters.capacity',
                DB::raw('COUNT(DISTINCT reservation_seat.seat_id) as seats_sold'),
                DB::raw('COUNT(DISTINCT reservation_seat.seat_id) / theaters.capacity * 100 as occupancy_rate')
            )
            ->join('movies', 'showtimes.movie_id', '=', 'movies.id')
            ->join('theaters', 'showtimes.theater_id', '=', 'theaters.id')
            ->leftJoin('reservations', function ($join) {
                $join->on('showtimes.id', '=', 'reservations.showtime_id')
                    ->where('reservations.status', '=', 'paid');
            })
            ->leftJoin('reservation_seat', 'reservations.id', '=', 'reservation_seat.reservation_id')
            ->groupBy('showtimes.id', 'movies.title', 'theaters.name', 'showtimes.start_time', 'theaters.capacity')
            ->get();
        
        return response()->json($showtimes);
    }

    public function movieRevenue()
    {
        $movieRevenue = DB::table('movies')
            ->select(
                'movies.id',
                'movies.title',
                DB::raw('COUNT(DISTINCT reservations.id) as reservation_count'),
                DB::raw('SUM(reservations.total_price) as total_revenue')
            )
            ->leftJoin('showtimes', 'movies.id', '=', 'showtimes.movie_id')
            ->leftJoin('reservations', function ($join) {
                $join->on('showtimes.id', '=', 'reservations.showtime_id')
                    ->where('reservations.status', '=', 'paid');
            })
            ->groupBy('movies.id', 'movies.title')
            ->orderBy('total_revenue', 'desc')
            ->get();
        
        return response()->json($movieRevenue);
    }

    public function popularMovies()
    {
        $popularMovies = DB::table('movies')
            ->select(
                'movies.id',
                'movies.title',
                DB::raw('COUNT(DISTINCT reservation_seat.seat_id) as tickets_sold')
            )
            ->leftJoin('showtimes', 'movies.id', '=', 'showtimes.movie_id')
            ->leftJoin('reservations', function ($join) {
                $join->on('showtimes.id', '=', 'reservations.showtime_id')
                    ->where('reservations.status', '=', 'paid');
            })
            ->leftJoin('reservation_seat', 'reservations.id', '=', 'reservation_seat.reservation_id')
            ->groupBy('movies.id', 'movies.title')
            ->orderBy('tickets_sold', 'desc')
            ->limit(10)
            ->get();
        
        return response()->json($popularMovies);
    }

    public function users()
    {
        $users = $this->userService->getAllUsers();
        return response()->json($users);
    }
}