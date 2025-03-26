<?php

namespace App\Repositories\Interfaces;

interface TicketRepositoryInterface
{
    public function all();
    public function findById($id);
    public function findByReservationId($reservationId);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}