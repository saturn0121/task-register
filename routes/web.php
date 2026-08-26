<?php

use App\Http\Controllers\TaskController;

Route::get('/task-register', [TaskController::class, 'index']);