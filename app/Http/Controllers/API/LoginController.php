<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Response\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $loginRequest)
    {
        $user = User::where('email', $loginRequest->email)->first();

        if (!$user || !Hash::check($loginRequest->password, $user->password)) 
        {
            return (new ApiResponse)->apiResponse('email or password is not correct', null, 404); 
        }

        $data = [
            'access_token' => $user->createToken('personal access token')->plainTextToken,
            'token_type' => 'Bearer'
        ];

        return (new ApiResponse)->apiResponse('successful login', $data, 200); 
    }
}