<?php

namespace App\Repositories\Eloquent;

use App\Models\Seat;
use App\Models\Reservation;
use App\Repositories\Interfaces\SeatRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SeatRepository implements SeatRepositoryInterface
{
    protected $model;

    public function __construct(Seat $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function findByTheaterId($theaterId)
    {
        return $this->model->where('theater_id', $theaterId)->get();
    }

    public function findAvailableByShowtimeId($showtimeId)
    {
        $showtime = \App\Models\Showtime::with('theater.seats')->find($showtimeId);
        
        if (!$showtime) {
            return collect();
        }
        
        $reservedSeatIds = DB::table('reservation_seat')
            ->join('reservations', 'reservations.id', '=', 'reservation_seat.reservation_id')
            ->where('reservations.showtime_id', $showtimeId)
            ->whereIn('reservations.status', ['pending', 'paid'])
            ->pluck('reservation_seat.seat_id');
        
        return $showtime->theater->seats->whereNotIn('id', $reservedSeatIds);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $seat = $this->model->find($id);
        if ($seat) {
            $seat->update($data);
            return $seat;
        }
        return null;
    }

    public function delete($id)
    {
        $seat = $this->model->find($id);
        if ($seat) {
            return $seat->delete();
        }
        return false;
    }
}