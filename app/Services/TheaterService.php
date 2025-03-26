<?php

namespace App\Services;

use App\Repositories\Interfaces\TheaterRepositoryInterface;

class TheaterService
{
    protected $theaterRepository;

    public function __construct(TheaterRepositoryInterface $theaterRepository)
    {
        $this->theaterRepository = $theaterRepository;
    }

    public function getAllTheaters()
    {
        return $this->theaterRepository->all();
    }

    public function getTheaterById($id)
    {
        return $this->theaterRepository->findById($id);
    }

    public function getTheatersByType($type)
    {
        return $this->theaterRepository->findByType($type);
    }

    public function createTheater(array $data)
    {
        return $this->theaterRepository->create($data);
    }

    public function updateTheater($id, array $data)
    {
        return $this->theaterRepository->update($id, $data);
    }

    public function deleteTheater($id)
    {
        return $this->theaterRepository->delete($id);
    }
}