<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// routes/web.php



Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Categories Resource
    Route::get('/categories/import', [CategoryController::class, 'importForm'])->name('categories.import');
    Route::post('/categories/import', [CategoryController::class, 'import'])->name('categories.import.store');

    Route::resource('categories', CategoryController::class);
        
// http://127.0.0.1:8000/admin/categories/import
    
    // For AJAX order update
    Route::post('/categories/update-order', [CategoryController::class, 'updateOrder'])
        ->name('categories.update-order');
});

// Home route (optional)
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

require __DIR__.'/auth.php';
