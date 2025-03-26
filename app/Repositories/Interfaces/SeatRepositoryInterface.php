<?php

namespace App\Repositories\Interfaces;

interface SeatRepositoryInterface
{
    public function all();
    public function findById($id);
    public function findByTheaterId($theaterId);
    public function findAvailableByShowtimeId($showtimeId);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}