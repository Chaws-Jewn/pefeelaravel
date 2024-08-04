<?php

use App\Http\Controllers\FeedTimeController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ServoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('', function() {
    return response()->json(['message' => 'Connected to api']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'arduino'], function() {
    Route::post('open', [ServoController::class, 'open']);
    Route::post('setlevel/{level}', [ServoController::class, 'setlevel']);
    
    Route::get('test', function() {
        return response()->json(['response' => 'hi there user!']);
    });

    Route::group(['prefix' => 'pets'], function() {
        Route::get('', [PetController::class, 'getAll']);
        Route::post('set', [PetController::class, 'add']);
    });

    Route::group(['prefix' => 'feed-times'], function() {
        Route::get('', [FeedTimeController::class, 'getAll']);
        Route::post('set', [FeedTimeController::class, 'add']);
    });

    Route::post('set-time/{servo}/{time}', [FeedTimeController::class, 'setTime']);
});