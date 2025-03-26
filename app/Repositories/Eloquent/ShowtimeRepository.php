<?php

namespace App\Repositories\Eloquent;

use App\Models\Showtime;
use App\Repositories\Interfaces\ShowtimeRepositoryInterface;

class ShowtimeRepository implements ShowtimeRepositoryInterface
{
    protected $model;

    public function __construct(Showtime $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->with(['movie', 'theater'])->get();
    }

    public function findById($id)
    {
        return $this->model->with(['movie', 'theater'])->find($id);
    }

    public function findByMovieId($movieId)
    {
        return $this->model->where('movie_id', $movieId)->with(['theater'])->get();
    }

    public function findByType($type)
    {
        return $this->model->where('type', $type)->with(['movie', 'theater'])->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $showtime = $this->model->find($id);
        if ($showtime) {
            $showtime->update($data);
            return $showtime;
        }
        return null;
    }

    public function delete($id)
    {
        $showtime = $this->model->find($id);
        if ($showtime) {
            return $showtime->delete();
        }
        return false;
    }
}