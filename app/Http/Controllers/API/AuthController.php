<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function store(StoreUserRequest $storeUserRequest)
    {
        $user = User::create($storeUserRequest->all());

        return response()->json([
            'data' => $user,
        ], 201);
    }
}

