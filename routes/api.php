<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KtrRequestController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LocationController;

Route::get('/', function () {
    return 'api';
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login/admin', [AuthController::class, 'loginAdmin']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::prefix('ktr-requests')->group(function () {
    Route::post('/', [KtrRequestController::class, 'store']);
    Route::get('/', [KtrRequestController::class, 'index']);
    Route::get('/{id}', [KtrRequestController::class, 'show']);
    Route::put('/{id}', [KtrRequestController::class, 'update']);
    Route::delete('/{id}', [KtrRequestController::class, 'destroy']);
    Route::get('/user/{userId}', [KtrRequestController::class, 'getByUserId']);
    Route::get('/user/{userId}/stats', [KtrRequestController::class, 'getRequestStatsByUserId']);
    Route::get('/admin/stats', [KtrRequestController::class, 'getRequestStats']);
    Route::put('/{id}/status', [KtrRequestController::class, 'updateStatus']);
});

Route::prefix('payments')->group(function () {
    Route::post('/', [PaymentController::class, 'store']);
    Route::get('/', [PaymentController::class, 'index']);
    Route::get('/{id}', [PaymentController::class, 'show']);
    Route::put('/{id}', [PaymentController::class, 'update']);
    Route::delete('/{id}', [PaymentController::class, 'destroy']);
    Route::get('/user/{userId}', [PaymentController::class, 'getByUserId']);
    Route::post('/{id}/verify', [PaymentController::class, 'verifyPayment']);
    Route::get('/user/{userId}/stats', [PaymentController::class, 'getPaymentStatsByUserId']);
});

Route::prefix('settings')->group(function () {
    Route::post('/', [SettingController::class, 'store']);
    Route::get('/', [SettingController::class, 'index']);
    Route::get('/{id}', [SettingController::class, 'show']);
    Route::put('/{id}', [SettingController::class, 'update']);
    Route::delete('/{id}', [SettingController::class, 'destroy']);
});

Route::prefix('users')->group(function () {
    Route::post('/', [UserController::class, 'store']);
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

Route::prefix('admins')->group(function () {
    Route::post('/', [AdminController::class, 'store']);
    Route::get('/', [AdminController::class, 'index']);
    Route::get('/{id}', [AdminController::class, 'show']);
    Route::put('/{id}', [AdminController::class, 'update']);
    Route::delete('/{id}', [AdminController::class, 'destroy']);
});

Route::get('/provinces', [LocationController::class, 'getProvinces']);
Route::get('/regencies/{province_id}', [LocationController::class, 'getRegenciesByProvince']);
Route::get('/districts/{regency_id}', [LocationController::class, 'getDistrictsByRegency']);
Route::get('/subdistricts/{district_id}', [LocationController::class, 'getSubdistrictsByDistrict']);


