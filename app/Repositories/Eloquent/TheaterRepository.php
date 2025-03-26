<?php

namespace App\Repositories\Eloquent;

use App\Models\Theater;
use App\Repositories\Interfaces\TheaterRepositoryInterface;

class TheaterRepository implements TheaterRepositoryInterface
{
    protected $model;

    public function __construct(Theater $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->with(['seats'])->get();
    }

    public function findById($id)
    {
        return $this->model->with(['seats'])->find($id);
    }

    public function findByType($type)
    {
        return $this->model->where('type', $type)->with(['seats'])->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $theater = $this->model->find($id);
        if ($theater) {
            $theater->update($data);
            return $theater;
        }
        return null;
    }

    public function delete($id)
    {
        $theater = $this->model->find($id);
        if ($theater) {
            return $theater->delete();
        }
        return false;
    }
}