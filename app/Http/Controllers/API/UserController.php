<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected UserService $userService
    ) {}

    public function index()
    {
        return $this->success(
            $this->userService->getAllUsers(),
            'Users fetched successfully'
        );
    }

    public function store(Request $request)
    {
        $user = $this->userService->createUser($request->all());

        return $this->success($user, 'User created successfully');
    }
}
