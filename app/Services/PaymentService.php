<?php

namespace App\Services;

use App\Repositories\Interfaces\ReservationRepositoryInterface;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentService
{
    protected $reservationRepository;
    protected $ticketService;

    public function __construct(
        ReservationRepositoryInterface $reservationRepository,
        TicketService $ticketService
    ) {
        $this->reservationRepository = $reservationRepository;
        $this->ticketService = $ticketService;
        
        // Set Stripe API key
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createPaymentIntent($reservationId)
    {
        $reservation = $this->reservationRepository->findById($reservationId);
        
        if (!$reservation) {
            throw new \Exception('Reservation not found.');
        }
        
        if ($reservation->status !== 'pending') {
            throw new \Exception('Reservation is not in pending status.');
        }
        
        // Create a PaymentIntent with the order amount and currency
        $paymentIntent = PaymentIntent::create([
            'amount' => $reservation->total_price * 100, // Amount in cents
            'currency' => 'usd',
            'metadata' => [
                'reservation_id' => $reservation->id,
            ],
        ]);
        
        return [
            'clientSecret' => $paymentIntent->client_secret,
        ];
    }

    public function handlePaymentSuccess($paymentIntentId)
    {
        $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
        $reservationId = $paymentIntent->metadata->reservation_id;
        
        // Update reservation status
        $this->reservationRepository->update($reservationId, [
            'status' => 'paid',
        ]);
        
        // Generate ticket
        return $this->ticketService->createTicket($reservationId);
    }
}