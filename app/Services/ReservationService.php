<?php

namespace App\Services;

use App\Repositories\Interfaces\ReservationRepositoryInterface;
use App\Repositories\Interfaces\SeatRepositoryInterface;
use Carbon\Carbon;

class ReservationService
{
    protected $reservationRepository;
    protected $seatRepository;

    public function __construct(
        ReservationRepositoryInterface $reservationRepository,
        SeatRepositoryInterface $seatRepository
    ) {
        $this->reservationRepository = $reservationRepository;
        $this->seatRepository = $seatRepository;
    }

    public function getAllReservations()
    {
        return $this->reservationRepository->all();
    }

    public function getReservationById($id)
    {
        return $this->reservationRepository->findById($id);
    }

    public function getReservationsByUserId($userId)
    {
        return $this->reservationRepository->findByUserId($userId);
    }

    public function getReservationsByShowtimeId($showtimeId)
    {
        return $this->reservationRepository->findByShowtimeId($showtimeId);
    }

    public function createReservation(array $data)
    {
        // Check if seats are available
        $availableSeats = $this->seatRepository->findAvailableByShowtimeId($data['showtime_id']);
        $availableSeatIds = $availableSeats->pluck('id')->toArray();
        
        foreach ($data['seat_ids'] as $seatId) {
            if (!in_array($seatId, $availableSeatIds)) {
                throw new \Exception('One or more seats are not available.');
            }
        }
        
        // Set expiration time (15 minutes from now)
        $data['expires_at'] = Carbon::now()->addMinutes(15);
        
        return $this->reservationRepository->create($data);
    }

    public function updateReservation($id, array $data)
    {
        return $this->reservationRepository->update($id, $data);
    }

    public function deleteReservation($id)
    {
        return $this->reservationRepository->delete($id);
    }

    public function expireOldReservations()
    {
        return $this->reservationRepository->expireOldReservations();
    }

    public function updateReservationStatus($id, $status)
    {
        return $this->reservationRepository->update($id, ['status' => $status]);
    }
}