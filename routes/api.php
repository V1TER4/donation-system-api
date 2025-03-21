<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\UserFavoriteController;
use App\Http\Controllers\InstitutionController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth.token')->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);

    Route::prefix('donation')->group(function () {
        Route::get('/index/{id}', [DonationController::class, 'index']);
        Route::get('/', [DonationController::class, 'list']);
        Route::post('/', [DonationController::class, 'store']);
        Route::get('/{id}', [DonationController::class, 'show']);
    });

    Route::prefix('favorite')->group(function () {
        Route::get('/{id}', [UserFavoriteController::class, 'find']);
        Route::post('/', [UserFavoriteController::class, 'store']);
        Route::put('/{id}', [UserFavoriteController::class, 'update']);
        Route::delete('/{id}', [UserFavoriteController::class, 'destroy']);
    });

    Route::prefix('institutions')->group(function () {
        Route::get('/', [InstitutionController::class, 'list']);
    });

    Route::get('health', function () {
        return response()->json(['message' => 'API is running'], 200);
    });
});