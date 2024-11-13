<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AssistantsController;
use App\Http\Controllers\CategoryController;

Route::group(['middleware' => 'auth:api'], function () {

    //ASSISTANT
    Route::get('assistant', [AssistantsController::class, 'index']);
    Route::get('assistant/{id}', [AssistantsController::class, 'show']);
    Route::post('assistant', [AssistantsController::class, 'store']);
    Route::put('assistant/{id}', [AssistantsController::class, 'update']);
    Route::delete('assistant/{id}', [AssistantsController::class, 'destroy']);

    //CATEGORY
    Route::get('category', [CategoryController::class, 'index']);
    Route::get('category/{id}', [CategoryController::class, 'show']);
    Route::post('category', [CategoryController::class, 'store']);
    Route::put('category/{id}', [CategoryController::class, 'update']);
    Route::delete('category/{id}', [CategoryController::class, 'destroy']);

});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
