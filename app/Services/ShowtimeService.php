<?php

namespace App\Services;

use App\Repositories\Interfaces\ShowtimeRepositoryInterface;

class ShowtimeService
{
    protected $showtimeRepository;

    public function __construct(ShowtimeRepositoryInterface $showtimeRepository)
    {
        $this->showtimeRepository = $showtimeRepository;
    }

    public function getAllShowtimes()
    {
        return $this->showtimeRepository->all();
    }

    public function getShowtimeById($id)
    {
        return $this->showtimeRepository->findById($id);
    }

    public function getShowtimesByMovieId($movieId)
    {
        return $this->showtimeRepository->findByMovieId($movieId);
    }

    public function getShowtimesByType($type)
    {
        return $this->showtimeRepository->findByType($type);
    }

    public function createShowtime(array $data)
    {
        return $this->showtimeRepository->create($data);
    }

    public function updateShowtime($id, array $data)
    {
        return $this->showtimeRepository->update($id, $data);
    }

    public function deleteShowtime($id)
    {
        return $this->showtimeRepository->delete($id);
    }
}