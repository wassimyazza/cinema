<?php

namespace App\Services;

use App\Repositories\Interfaces\SeatRepositoryInterface;

class SeatService
{
    protected $seatRepository;

    public function __construct(SeatRepositoryInterface $seatRepository)
    {
        $this->seatRepository = $seatRepository;
    }

    public function getAllSeats()
    {
        return $this->seatRepository->all();
    }

    public function getSeatById($id)
    {
        return $this->seatRepository->findById($id);
    }

    public function getSeatsByTheaterId($theaterId)
    {
        return $this->seatRepository->findByTheaterId($theaterId);
    }

    public function getAvailableSeatsByShowtimeId($showtimeId)
    {
        return $this->seatRepository->findAvailableByShowtimeId($showtimeId);
    }

    public function createSeat(array $data)
    {
        return $this->seatRepository->create($data);
    }

    public function updateSeat($id, array $data)
    {
        return $this->seatRepository->update($id, $data);
    }

    public function deleteSeat($id)
    {
        return $this->seatRepository->delete($id);
    }
}