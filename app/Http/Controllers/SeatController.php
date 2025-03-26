<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SeatService;
use Illuminate\Support\Facades\Validator;

class SeatController extends Controller
{
    protected $seatService;

    public function __construct(SeatService $seatService)
    {
        $this->seatService = $seatService;
        $this->middleware('auth:api')->except(['index', 'show', 'byTheater', 'availableByShowtime']);
        $this->middleware('admin')->except(['index', 'show', 'byTheater', 'availableByShowtime']);
    }

    public function index()
    {
        $seats = $this->seatService->getAllSeats();
        return response()->json($seats);
    }

    public function show($id)
    {
        $seat = $this->seatService->getSeatById($id);
        
        if (!$seat) {
            return response()->json(['message' => 'Seat not found'], 404);
        }
        
        return response()->json($seat);
    }

    public function byTheater($theaterId)
    {
        $seats = $this->seatService->getSeatsByTheaterId($theaterId);
        return response()->json($seats);
    }

    public function availableByShowtime($showtimeId)
    {
        $seats = $this->seatService->getAvailableSeatsByShowtimeId($showtimeId);
        return response()->json($seats);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'theater_id' => 'required|exists:theaters,id',
            'row' => 'required|string|max:10',
            'number' => 'required|integer|min:1',
            'type' => 'required|in:Regular,Couple',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $seat = $this->seatService->createSeat($request->all());

        return response()->json([
            'message' => 'Seat created successfully',
            'seat' => $seat
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'theater_id' => 'sometimes|exists:theaters,id',
            'row' => 'sometimes|string|max:10',
            'number' => 'sometimes|integer|min:1',
            'type' => 'sometimes|in:Regular,Couple',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $seat = $this->seatService->updateSeat($id, $request->all());

        if (!$seat) {
            return response()->json(['message' => 'Seat not found'], 404);
        }

        return response()->json([
            'message' => 'Seat updated successfully',
            'seat' => $seat
        ]);
    }

    public function destroy($id)
    {
        $result = $this->seatService->deleteSeat($id);

        if (!$result) {
            return response()->json(['message' => 'Seat not found'], 404);
        }

        return response()->json(['message' => 'Seat deleted successfully']);
    }
}