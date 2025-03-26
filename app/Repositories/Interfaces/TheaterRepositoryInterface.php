<?php

namespace App\Repositories\Interfaces;

interface TheaterRepositoryInterface
{
    public function all();
    public function findById($id);
    public function findByType($type);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}