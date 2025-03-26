<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TheaterService;
use Illuminate\Support\Facades\Validator;

class TheaterController extends Controller
{
    protected $theaterService;

    public function __construct(TheaterService $theaterService)
    {
        $this->theaterService = $theaterService;
        $this->middleware('auth:api')->except(['index', 'show', 'byType']);
        $this->middleware('admin')->except(['index', 'show', 'byType']);
    }

    public function index()
    {
        $theaters = $this->theaterService->getAllTheaters();
        return response()->json($theaters);
    }

    public function show($id)
    {
        $theater = $this->theaterService->getTheaterById($id);
        
        if (!$theater) {
            return response()->json(['message' => 'Theater not found'], 404);
        }
        
        return response()->json($theater);
    }

    public function byType($type)
    {
        $theaters = $this->theaterService->getTheatersByType($type);
        return response()->json($theaters);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'type' => 'required|in:Normal,VIP',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $theater = $this->theaterService->createTheater($request->all());

        return response()->json([
            'message' => 'Theater created successfully',
            'theater' => $theater
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'capacity' => 'sometimes|integer|min:1',
            'type' => 'sometimes|in:Normal,VIP',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $theater = $this->theaterService->updateTheater($id, $request->all());

        if (!$theater) {
            return response()->json(['message' => 'Theater not found'], 404);
        }

        return response()->json([
            'message' => 'Theater updated successfully',
            'theater' => $theater
        ]);
    }

    public function destroy($id)
    {
        $result = $this->theaterService->deleteTheater($id);

        if (!$result) {
            return response()->json(['message' => 'Theater not found'], 404);
        }

        return response()->json(['message' => 'Theater deleted successfully']);
    }
}