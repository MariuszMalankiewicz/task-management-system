<?php

namespace App\Services;

use App\Models\User;
use App\Http\Response\ApiResponse;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function create(Object $request)
    {
        $user = User::create($request->validated());

        return (new ApiResponse)->apiResponse('successfull created user', $user, 201);
    }

    public function findUserByEmail(object $request)
    {
        return User::where('email', $request->email)->first();
    }

    public function checkUserPassword(object $request)
    {
        $user = $this->findUserByEmail($request);

        if (!$user || !Hash::check($request->password, $user->password)) 
        {
            return 0;
        }

        return true;
    }

    public function createToken($user)
    {
        return $user->createToken('personal access token')->plainTextToken;
    }

    public function login(object $request)
    {
        $user = $this->findUserByEmail($request);

        if($this->checkUserPassword($request) === true)
        {
            $data = [
                'access_token' => $this->createToken($user),
                'token_type' => 'Bearer'
            ];

            return (new ApiResponse)->apiResponse('successful login', $data, 200); 
        }

        return (new ApiResponse)->apiResponse('email or password is not correct', null, 404); 
    }
}