<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\BuildingController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public routes (no authentication required)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Public building routes (read-only for external consumption)
Route::get('/buildings', [BuildingController::class, 'index']);
Route::get('/buildings/search', [BuildingController::class, 'search']);
Route::get('/buildings/status/{status}', [BuildingController::class, 'byStatus']);
Route::get('/buildings/city/{city}', [BuildingController::class, 'byCity']);
Route::get('/buildings/{building}', [BuildingController::class, 'show']);

// Protected routes (authentication required via Sanctum token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    
    // Building management routes (token required)
    Route::post('/buildings', [BuildingController::class, 'store']);
    Route::put('/buildings/{building}', [BuildingController::class, 'update']);
    Route::delete('/buildings/{building}', [BuildingController::class, 'destroy']);
});
