<?php

namespace App\Repositories\Eloquent;

use App\Models\Ticket;
use App\Repositories\Interfaces\TicketRepositoryInterface;

class TicketRepository implements TicketRepositoryInterface
{
    protected $model;

    public function __construct(Ticket $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->with(['reservation'])->get();
    }

    public function findById($id)
    {
        return $this->model->with(['reservation'])->find($id);
    }

    public function findByReservationId($reservationId)
    {
        return $this->model->where('reservation_id', $reservationId)->first();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $ticket = $this->model->find($id);
        if ($ticket) {
            $ticket->update($data);
            return $ticket;
        }
        return null;
    }

    public function delete($id)
    {
        $ticket = $this->model->find($id);
        if ($ticket) {
            return $ticket->delete();
        }
        return false;
    }
}