<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::resource('tasks', TaskController::class);

Route::get('tasks/{task}/delete', [TaskController::class, 'delete'])->name('tasks.delete');