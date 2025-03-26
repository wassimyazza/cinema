<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TicketService;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
        $this->middleware('auth:api');
    }

    public function show($id)
    {
        $ticket = $this->ticketService->getTicketById($id);
        
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }
        
        // Check if the user is authorized to view this ticket
        if (!Auth::user()->is_admin && $ticket->reservation->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        return response()->json($ticket);
    }

    public function getByReservation($reservationId)
    {
        // Check if the user owns this reservation
        $reservation = \App\Models\Reservation::find($reservationId);
        if (!$reservation || (!Auth::user()->is_admin && $reservation->user_id !== Auth::id())) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $ticket = $this->ticketService->getTicketByReservationId($reservationId);
        
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }
        
        return response()->json($ticket);
    }

    public function download($id)
    {
        $ticket = $this->ticketService->getTicketById($id);
        
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }
        
        // Check if the user is authorized to download this ticket
        if (!Auth::user()->is_admin && $ticket->reservation->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        // Load the reservation with related data
        $reservation = $ticket->reservation->load(['user', 'showtime.movie', 'showtime.theater', 'seats']);
        
        // Generate PDF
        $pdf = PDF::loadView('tickets.pdf', [
            'ticket' => $ticket,
            'reservation' => $reservation
        ]);
        
        return $pdf->download('ticket-' . $ticket->ticket_number . '.pdf');
    }
}