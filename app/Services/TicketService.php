<?php

namespace App\Services;

use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Repositories\Interfaces\ReservationRepositoryInterface;
use Illuminate\Support\Str;

class TicketService
{
    protected $ticketRepository;
    protected $reservationRepository;

    public function __construct(
        TicketRepositoryInterface $ticketRepository,
        ReservationRepositoryInterface $reservationRepository
    ) {
        $this->ticketRepository = $ticketRepository;
        $this->reservationRepository = $reservationRepository;
    }

    public function getAllTickets()
    {
        return $this->ticketRepository->all();
    }

    public function getTicketById($id)
    {
        return $this->ticketRepository->findById($id);
    }

    public function getTicketByReservationId($reservationId)
    {
        return $this->ticketRepository->findByReservationId($reservationId);
    }

    public function createTicket($reservationId)
    {
        $reservation = $this->reservationRepository->findById($reservationId);
        
        if (!$reservation || $reservation->status !== 'paid') {
            throw new \Exception('Cannot create ticket for unpaid reservation.');
        }
        
        // Check if ticket already exists
        $existingTicket = $this->ticketRepository->findByReservationId($reservationId);
        if ($existingTicket) {
            return $existingTicket;
        }
        
        // Generate QR code and ticket number
        $ticketNumber = 'TKT-' . strtoupper(Str::random(8));
        $qrCode = $ticketNumber; // In a real app, you'd generate a proper QR code
        
        return $this->ticketRepository->create([
            'reservation_id' => $reservationId,
            'qr_code' => $qrCode,
            'ticket_number' => $ticketNumber,
        ]);
    }

    public function updateTicket($id, array $data)
    {
        return $this->ticketRepository->update($id, $data);
    }

    public function deleteTicket($id)
    {
        return $this->ticketRepository->delete($id);
    }
}