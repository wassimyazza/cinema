<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReservationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
        $this->middleware('auth:api');
    }

    public function index()
    {
        if (Auth::user()->is_admin) {
            $reservations = $this->reservationService->getAllReservations();
        } else {
            $reservations = $this->reservationService->getReservationsByUserId(Auth::id());
        }
        
        return response()->json($reservations);
    }

    public function show($id)
    {
        $reservation = $this->reservationService->getReservationById($id);
        
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }
        
        // Check if the user is authorized to view this reservation
        if (!Auth::user()->is_admin && $reservation->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        return response()->json($reservation);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'showtime_id' => 'required|exists:showtimes,id',
            'seat_ids' => 'required|array',
            'seat_ids.*' => 'required|exists:seats,id',
            'total_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Expire old reservations
        $this->reservationService->expireOldReservations();

        try {
            $reservation = $this->reservationService->createReservation([
                'user_id' => Auth::id(),
                'showtime_id' => $request->showtime_id,
                'seat_ids' => $request->seat_ids,
                'total_price' => $request->total_price,
                'status'  => $request->seat_ids,
                'total_price' => $request->total_price,
                'status' => 'pending',
            ]);

            return response()->json([
                'message' => 'Reservation created successfully',
                'reservation' => $reservation,
                'expires_at' => $reservation->expires_at
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $reservation = $this->reservationService->getReservationById($id);
        
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }
        
        // Check if the user is authorized to update this reservation
        if (!Auth::user()->is_admin && $reservation->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        // Only allow updates if the reservation is still pending
        if ($reservation->status !== 'pending') {
            return response()->json(['message' => 'Cannot update a non-pending reservation'], 400);
        }
        
        $validator = Validator::make($request->all(), [
            'seat_ids' => 'sometimes|array',
            'seat_ids.*' => 'required|exists:seats,id',
            'total_price' => 'sometimes|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $reservation = $this->reservationService->updateReservation($id, $request->all());
            
            return response()->json([
                'message' => 'Reservation updated successfully',
                'reservation' => $reservation
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function destroy($id)
    {
        $reservation = $this->reservationService->getReservationById($id);
        
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }
        
        // Check if the user is authorized to delete this reservation
        if (!Auth::user()->is_admin && $reservation->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        // Only allow cancellation if the reservation is still pending
        if ($reservation->status !== 'pending') {
            return response()->json(['message' => 'Cannot cancel a non-pending reservation'], 400);
        }
        
        $result = $this->reservationService->deleteReservation($id);

        return response()->json(['message' => 'Reservation cancelled successfully']);
    }
}