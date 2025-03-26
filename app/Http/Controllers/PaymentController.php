<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
        $this->middleware('auth:api');
    }

    public function createPaymentIntent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reservation_id' => 'required|exists:reservations,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if the user owns this reservation
        $reservation = \App\Models\Reservation::find($request->reservation_id);
        if (!$reservation || (!Auth::user()->is_admin && $reservation->user_id !== Auth::id())) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $paymentIntent = $this->paymentService->createPaymentIntent($request->reservation_id);
            return response()->json($paymentIntent);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function handleWebhook(Request $request)
    {
        $payload = $request->all();
        $event = null;

        try {
            $event = \Stripe\Event::constructFrom($payload);
        } catch (\UnexpectedValueException $e) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // Handle the event
        if ($event->type === 'payment_intent.succeeded') {
            $paymentIntent = $event->data->object;
            $this->paymentService->handlePaymentSuccess($paymentIntent->id);
        }

        return response()->json(['status' => 'success']);
    }
}