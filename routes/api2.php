<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\API\CategoryController;

Route::post('/login',[AuthController::class,'login']);
Route::post('/register', [AuthController::class, 'register']);



Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout',[AuthController::class,'logout']);
});
Route::prefix('v1')->group(function () {
    // Public routes
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/tree', [CategoryController::class, 'tree']);
    Route::get('/categories/search', [CategoryController::class, 'search']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    
    // Protected routes (with Sanctum)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    });
});

