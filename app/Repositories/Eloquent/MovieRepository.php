<?php

namespace App\Repositories\Eloquent;

use App\Models\Movie;
use App\Repositories\Interfaces\MovieRepositoryInterface;

class MovieRepository implements MovieRepositoryInterface
{
    protected $model;

    public function __construct(Movie $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $movie = $this->model->find($id);
        if ($movie) {
            $movie->update($data);
            return $movie;
        }
        return null;
    }

    public function delete($id)
    {
        $movie = $this->model->find($id);
        if ($movie) {
            return $movie->delete();
        }
        return false;
    }
}