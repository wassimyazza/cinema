<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ShowtimeService;
use Illuminate\Support\Facades\Validator;

class ShowtimeController extends Controller
{
    protected $showtimeService;

    public function __construct(ShowtimeService $showtimeService)
    {
        $this->showtimeService = $showtimeService;
        $this->middleware('auth:api')->except(['index', 'show', 'byMovie', 'byType']);
        $this->middleware('admin')->except(['index', 'show', 'byMovie', 'byType']);
    }

    public function index()
    {
        $showtimes = $this->showtimeService->getAllShowtimes();
        return response()->json($showtimes);
    }

    public function show($id)
    {
        $showtime = $this->showtimeService->getShowtimeById($id);
        
        if (!$showtime) {
            return response()->json(['message' => 'Showtime not found'], 404);
        }
        
        return response()->json($showtime);
    }

    public function byMovie($movieId)
    {
        $showtimes = $this->showtimeService->getShowtimesByMovieId($movieId);
        return response()->json($showtimes);
    }

    public function byType($type)
    {
        $showtimes = $this->showtimeService->getShowtimesByType($type);
        return response()->json($showtimes);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'movie_id' => 'required|exists:movies,id',
            'theater_id' => 'required|exists:theaters,id',
            'start_time' => 'required|date',
            'language' => 'required|string|max:50',
            'type' => 'required|in:Normal,VIP',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $showtime = $this->showtimeService->createShowtime($request->all());

        return response()->json([
            'message' => 'Showtime created successfully',
            'showtime' => $showtime
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'movie_id' => 'sometimes|exists:movies,id',
            'theater_id' => 'sometimes|exists:theaters,id',
            'start_time' => 'sometimes|date',
            'language' => 'sometimes|string|max:50',
            'type' => 'sometimes|in:Normal,VIP',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $showtime = $this->showtimeService->updateShowtime($id, $request->all());

        if (!$showtime) {
            return response()->json(['message' => 'Showtime not found'], 404);
        }

        return response()->json([
            'message' => 'Showtime updated successfully',
            'showtime' => $showtime
        ]);
    }

    public function destroy($id)
    {
        $result = $this->showtimeService->deleteShowtime($id);

        if (!$result) {
            return response()->json(['message' => 'Showtime not found'], 404);
        }

        return response()->json(['message' => 'Showtime deleted successfully']);
    }
}