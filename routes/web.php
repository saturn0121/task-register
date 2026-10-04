<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::resource('tasks', TaskController::class)->only(['index', 'create', 'edit']);

Route::get('tasks/{task}/delete', [TaskController::class, 'delete'])->name('tasks.delete');