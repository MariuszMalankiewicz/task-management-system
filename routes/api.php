<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TaskController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/users', [AuthController::class, 'store'])->name('users.store');
Route::post('/users/login', [AuthController::class, 'login'])->name('users.login');

Route::apiResource('tasks', TaskController::class)->except('create', 'edit');