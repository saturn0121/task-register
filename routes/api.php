<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Public - the only route you can call without a token
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

// Everything below needs: Authorization: Bearer <token>
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'me']);

    Route::get('/tasks', [TaskController::class, 'apiIndex']);
    Route::post('/tasks', [TaskController::class, 'apiStore']);
    Route::get('/tasks/{task}', [TaskController::class, 'apiShow']);
    Route::put('/tasks/{task}', [TaskController::class, 'apiUpdate']);
    Route::delete('/tasks/{task}', [TaskController::class, 'apiDestroy']);
});