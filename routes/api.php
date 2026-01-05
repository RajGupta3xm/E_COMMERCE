<?php
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// AUTH
Route::post('/login',    [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// API v1
Route::prefix('v1')->group(function () {

    // 🔓 Public routes (read-only)
    Route::apiResource('categories', CategoryController::class)
        ->only(['index', 'show']);

    // 🔓 Extra public routes
    Route::get('categories/tree',   [CategoryController::class, 'tree']);
    Route::get('categories/search', [CategoryController::class, 'search']);

    // 🔐 Protected routes (write operations)
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('categories', CategoryController::class)
            ->only(['store', 'update', 'destroy']);
    });
});
