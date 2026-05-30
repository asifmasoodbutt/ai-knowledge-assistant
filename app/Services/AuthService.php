<?php

namespace App\Services;

use App\Interfaces\Repositories\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(protected AuthRepositoryInterface $authRepository) {}

    public function register(array $data)
    {
        $user = $this->authRepository->createUser($data);
        $token = $user->createToken('auth_token')->plainTextToken;
        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    public function login(array $data)
    {
        $user = $this->authRepository->findUserByEmail($data['email']);
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials'],
            ]);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    public function logout($user)
    {
        $user->tokens()->delete();
        return true;
    }
}
