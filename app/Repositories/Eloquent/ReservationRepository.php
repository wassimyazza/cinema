<?php

namespace App\Repositories\Eloquent;

use App\Models\Reservation;
use App\Repositories\Interfaces\ReservationRepositoryInterface;
use Carbon\Carbon;

class ReservationRepository implements ReservationRepositoryInterface
{
    protected $model;

    public function __construct(Reservation $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->with(['user', 'showtime', 'seats'])->get();
    }

    public function findById($id)
    {
        return $this->model->with(['user', 'showtime', 'seats'])->find($id);
    }

    public function findByUserId($userId)
    {
        return $this->model->where('user_id', $userId)
            ->with(['showtime.movie', 'showtime.theater', 'seats'])
            ->get();
    }

    public function findByShowtimeId($showtimeId)
    {
        return $this->model->where('showtime_id', $showtimeId)
            ->with(['user', 'seats'])
            ->get();
    }

    public function create(array $data)
    {
        $reservation = $this->model->create($data);
        
        if (isset($data['seat_ids']) && is_array($data['seat_ids'])) {
            $reservation->seats()->attach($data['seat_ids']);
        }
        
        return $reservation;
    }

    public function update($id, array $data)
    {
        $reservation = $this->model->find($id);
        if ($reservation) {
            $reservation->update($data);
            
            if (isset($data['seat_ids']) && is_array($data['seat_ids'])) {
                $reservation->seats()->sync($data['seat_ids']);
            }
            
            return $reservation;
        }
        return null;
    }

    public function delete($id)
    {
        $reservation = $this->model->find($id);
        if ($reservation) {
            $reservation->seats()->detach();
            return $reservation->delete();
        }
        return false;
    }

    public function expireOldReservations()
    {
        return $this->model->where('status', 'pending')
            ->where('expires_at', '<', Carbon::now())
            ->update(['status' => 'expired']);
    }
}