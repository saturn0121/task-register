<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Use App\Http\Controllers\TaskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/tasks', [TaskController::class, 'apiIndex']);
Route::post('/tasks', [TaskController::class, 'apiStore']);
Route::put('/tasks/{task}', [TaskController::class, 'apiUpdate']);
Route::delete('/tasks/{task}', [TaskController::class, 'apiDestroy']);