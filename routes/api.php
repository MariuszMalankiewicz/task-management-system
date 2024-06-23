<?php

use App\Http\Response\ApiResponse;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\RegistrationController;

Route::post('/registration', RegistrationController::class)->name('registration');
Route::post('/login', LoginController::class)->name('login');

Route::apiResource('tasks', TaskController::class)->except('create', 'edit')->middleware('auth:sanctum');