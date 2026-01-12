<?php

use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;



// 🔑 AUTHENTICATION ROUTES
Route::post('/login',    [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


// 🌐 API V1 ROUTES
Route::prefix('v1')->as('api.')->group(function () {

    // 1. SPECIFIC PUBLIC ROUTES (Resource se upar rakhein hamesha)
    Route::get('categories/tree',   [CategoryController::class, 'tree'])->name('categories.tree');
    Route::get('categories/search', [CategoryController::class, 'search'])->name('categories.search');

    // 2. CATEGORY RESOURCE
    // Humne Controller mein 'HasMiddleware' implement kiya hai (jo maine pehle bataya tha)
    // Isliye yahan hum sirf ek single clean route define karenge.
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('categories.products', CategoryController::class)
        ->only(['index']);
        

});