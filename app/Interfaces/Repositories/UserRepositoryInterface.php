<?php

namespace App\Interfaces\Repositories;

interface UserRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
}
