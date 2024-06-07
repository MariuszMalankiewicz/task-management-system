<?php

namespace App\Http\Controllers\API;

use App\Services\UserService;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;

class AuthController extends Controller
{

    protected $userService;
    
    public function __construct(UserService $userService)
    {
       $this->userService = $userService;
    }

    public function store(StoreUserRequest $storeUserRequest)
    {
        return $this->userService->create($storeUserRequest);
    }

    public function login(LoginRequest $loginRequest)
    {
        return $this->userService->login($loginRequest);
    } 
}

