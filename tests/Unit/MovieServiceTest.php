<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\MovieService;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class MovieServiceTest extends TestCase
{
    protected $movieRepositoryMock;
    protected $movieService;

    public function setUp(): void
    {
        parent::setUp();
        $this->movieRepositoryMock = Mockery::mock(MovieRepositoryInterface::class);
        $this->movieService = new MovieService($this->movieRepositoryMock);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testGetAllMovies()
    {
        $expectedMovies = [
            (object)['id' => 1, 'title' => 'Movie 1'],
            (object)['id' => 2, 'title' => 'Movie 2']
        ];

        $this->movieRepositoryMock->shouldReceive('all')
            ->once()
            ->andReturn($expectedMovies);

        $result = $this->movieService->getAllMovies();
        $this->assertEquals($expectedMovies, $result);
    }

    public function testGetMovieById()
    {
        $expectedMovie = (object)['id' => 1, 'title' => 'Movie 1'];

        $this->movieRepositoryMock->shouldReceive('findById')
            ->once()
            ->with(1)
            ->andReturn($expectedMovie);

        $result = $this->movieService->getMovieById(1);
        $this->assertEquals($expectedMovie, $result);
    }

    public function testCreateMovie()
    {
        $movieData = [
            'title' => 'New Movie',
            'description' => 'Description',
            'duration' => 120
        ];

        $expectedMovie = (object)array_merge($movieData, ['id' => 1]);

        $this->movieRepositoryMock->shouldReceive('create')
            ->once()
            ->with($movieData)
            ->andReturn($expectedMovie);

        $result = $this->movieService->createMovie($movieData);
        $this->assertEquals($expectedMovie, $result);
    }

    public function testUpdateMovie()
    {
        $movieId = 1;
        $movieData = [
            'title' => 'Updated Movie',
            'description' => 'Updated Description'
        ];

        $expectedMovie = (object)array_merge($movieData, ['id' => $movieId]);

        $this->movieRepositoryMock->shouldReceive('update')
            ->once()
            ->with($movieId, $movieData)
            ->andReturn($expectedMovie);

        $result = $this->movieService->updateMovie($movieId, $movieData);
        $this->assertEquals($expectedMovie, $result);
    }

    public function testDeleteMovie()
    {
        $movieId = 1;

        $this->movieRepositoryMock->shouldReceive('delete')
            ->once()
            ->with($movieId)
            ->andReturn(true);

        $result = $this->movieService->deleteMovie($movieId);
        $this->assertTrue($result);
    }
}