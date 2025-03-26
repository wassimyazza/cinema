<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MovieService;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->middleware('admin')->except(['index', 'show']);
    }

    public function index()
    {
        $movies = $this->movieService->getAllMovies();
        return response()->json($movies);
    }

    public function show($id)
    {
        $movie = $this->movieService->getMovieById($id);
        
        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }
        
        return response()->json($movie);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'min_age' => 'required|integer|min:0',
            'trailer_url' => 'nullable|string|url',
            'genre' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $movie = $this->movieService->createMovie($request->all());

        return response()->json([
            'message' => 'Movie created successfully',
            'movie' => $movie
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'nullable|string',
            'duration' => 'sometimes|integer|min:1',
            'min_age' => 'sometimes|integer|min:0',
            'trailer_url' => 'nullable|string|url',
            'genre' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $movie = $this->movieService->updateMovie($id, $request->all());

        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        return response()->json([
            'message' => 'Movie updated successfully',
            'movie' => $movie
        ]);
    }

    public function destroy($id)
    {
        $result = $this->movieService->deleteMovie($id);

        if (!$result) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        return response()->json(['message' => 'Movie deleted successfully']);
    }
}