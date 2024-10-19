<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


// Route::group(['middleware' => 'auth:api'], function () {
// });

Route::post('register', [AuthController::class, 'register']);

Route::post('login', [AuthController::class, 'login']);

