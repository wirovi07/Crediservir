<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AssistantsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventCategoyController;

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

    //EVENT
    Route::get('event', [EventController::class, 'index']);
    Route::get('event/{id}', [EventController::class, 'show']);
    Route::post('event', [EventController::class, 'store']);
    Route::put('event/{id}', [EventController::class, 'update']);
    Route::delete('event/{id}', [EventController::class, 'destroy']);

    //EVENT_CATEGORY
    Route::get('eventcategory', [EventCategoyController::class, 'index']);
    Route::get('eventnamecategory', [EventCategoyController::class,'categoryName']);
    Route::get('eventcategory/{id}', [EventCategoyController::class, 'show']);
    Route::post('eventcategory', [EventCategoyController::class, 'store']);
    Route::put('eventcategory/{id}', [EventCategoyController::class, 'update']);
    Route::delete('eventcategory/{id}', [EventCategoyController::class, 'destroy']);

});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
