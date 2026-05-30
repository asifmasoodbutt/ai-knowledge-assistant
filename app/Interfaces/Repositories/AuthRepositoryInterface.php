<?php

namespace App\Interfaces\Repositories;

interface AuthRepositoryInterface
{
    public function createUser(array $data);
    public function findUserByEmail(string $email);
}
