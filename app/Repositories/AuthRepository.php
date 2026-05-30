<?php

namespace App\Repositories;

use App\Interfaces\Repositories\AuthRepositoryInterface;
use App\Models\User;

class AuthRepository implements AuthRepositoryInterface
{
    public function createUser(array $data)
    {
        return User::create($data);
    }

    public function findUserByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }
}
