<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\BrandsController;
use App\Http\Controllers\Admin\CategoryController;

/*
|--------------------------------------------------------------------------
| Public & Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Auth::check() ? redirect()->route('admin.dashboard') : redirect()->route('login');
});

// Auth scaffolding routes (Login, Register, etc.)
Auth::routes();

/*
|--------------------------------------------------------------------------
| User Profile Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->middleware('verified')->name('dashboard');

    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

    // Categories Management
    Route::controller(CategoryController::class)->prefix('categories')->name('categories.')->group(function () {
        Route::get('/import', 'importForm')->name('import');
        Route::post('/import', 'import')->name('import.store');
        Route::post('/update-order', 'updateOrder')->name('update-order');
    });
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Brands Management
    Route::controller(BrandsController::class)->prefix('brands')->name('brands.')->group(function () {
        Route::get('/import', 'importForm')->name('import');
        Route::post('/import', 'import')->name('import.store');
        Route::post('/toggle-status', 'toggleStatus')->name('toggleStatus'); // Consistent naming
    });
    Route::resource('brands', BrandsController::class);

});

require __DIR__.'/auth.php';