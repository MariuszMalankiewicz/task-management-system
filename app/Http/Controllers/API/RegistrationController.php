<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Response\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;

class RegistrationController extends Controller
{
    public function __invoke(RegistrationRequest $registrationRequest)
    {

        $user = User::create($registrationRequest->validated());

        return (new ApiResponse)->apiResponse('successfull created user', $user, 201);
    }
}

