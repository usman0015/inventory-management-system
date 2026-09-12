<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AIController;

// require __DIR__.'/auth.php';

// Route::get('/', function () {
//     return view('welcome');
// });

// // Routes that require authentication
// Route::middleware(['auth'])->group(function () {

//     // Dashboard Route
//     Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

//     // Resource routes for Items CRUD
//     Route::resource('items', ItemController::class);

//     // User Profile routes
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// Dashboard Route
    // Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // // Resource routes for Items CRUD
    // Route::resource('items', ItemController::class);


//     Route::get('/dashboard', function () {
//     return view('dashboard.index');
// })->name('dashboard');

// Route::resource('items', ItemController::class);

Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
Route::resource('items', ItemController::class);
Route::resource('orders', OrderController::class);



Route::post('/generate-description', [AIController::class, 'generate'])->name('ai.generate');
