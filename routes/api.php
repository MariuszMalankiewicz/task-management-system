<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TaskController;

Route::controller(AuthController::class)->group(function()
{
    Route::post('users', 'store');
    Route::post('users/login', 'login');
});

Route::apiResource('tasks', TaskController::class)->except('create', 'edit')->middleware('auth:sanctum');;