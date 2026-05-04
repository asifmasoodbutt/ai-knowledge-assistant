<?php

namespace App\Services;

use App\Interfaces\Repositories\UserRepositoryInterface;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepo
    ) {}

    public function getAllUsers()
    {
        return $this->userRepo->all();
    }

    public function createUser(array $data)
    {
        // business logic can be added here
        return $this->userRepo->create($data);
    }
}
