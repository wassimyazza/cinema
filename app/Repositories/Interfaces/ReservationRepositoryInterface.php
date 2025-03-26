<?php

namespace App\Repositories\Interfaces;

interface ReservationRepositoryInterface
{
    public function all();
    public function findById($id);
    public function findByUserId($userId);
    public function findByShowtimeId($showtimeId);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function expireOldReservations();
}