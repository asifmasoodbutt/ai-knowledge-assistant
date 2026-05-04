<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function all()
    {
        return User::latest()->get();
    }

    public function find($id)
    {
        return User::findOrFail($id);
    }

    public function create(array $data)
    {
        return User::create($data);
    }
}
