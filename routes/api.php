<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KtrRequestController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingController;

Route::get('/', function () {
    return 'api';
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::prefix('ktr-requests')->group(function () {
    Route::post('/', [KtrRequestController::class, 'store']);
    Route::get('/', [KtrRequestController::class, 'index']);
    Route::get('/{id}', [KtrRequestController::class, 'show']);
    Route::put('/{id}', [KtrRequestController::class, 'update']);
    Route::delete('/{id}', [KtrRequestController::class, 'destroy']);
});

Route::prefix('payments')->group(function () {
    Route::post('/', [PaymentController::class, 'store']);
    Route::get('/', [PaymentController::class, 'index']);
    Route::get('/{id}', [PaymentController::class, 'show']);
    Route::put('/{id}', [PaymentController::class, 'update']);
    Route::delete('/{id}', [PaymentController::class, 'destroy']);
});

Route::prefix('settings')->group(function () {
    Route::post('/', [SettingController::class, 'store']);
    Route::get('/', [SettingController::class, 'index']);
    Route::get('/{id}', [SettingController::class, 'show']);
    Route::put('/{id}', [SettingController::class, 'update']);
    Route::delete('/{id}', [SettingController::class, 'destroy']);
});


