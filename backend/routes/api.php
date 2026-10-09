<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login',[AuthController::class,'login']);
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
Route::post('/change-password',[AuthController::class,'changePassword'])->middleware('auth:sanctum');
Route::put('/user',[AuthController::class,'updateProfile'])->middleware('auth:sanctum');