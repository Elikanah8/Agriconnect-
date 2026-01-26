<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Farmer\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/// New way - calls the HomeController to fetch your Nduma listings
Route::get('/dashboard', [HomeController::class, 'buyerDashboard'])
    ->middleware(['auth', 'verified', 'user-role:buyer'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

require __DIR__.'/auth.php';

// --- FARMER ROUTES ---
Route::middleware(['auth', 'user-role:farmer'])->group(function () {
    // This points to the controller method we created earlier
    Route::get('/farmer/dashboard', [HomeController::class, 'farmerDashboard'])->name('farmer.dashboard');
    
    // This handles the form submission for products
    Route::post('/farmer/products', [ProductController::class, 'store'])->name('farmer.products.store');
});

// --- TRANSPORTER ROUTES ---
Route::middleware(['auth', 'user-role:transporter'])->group(function () {
    Route::get('/transporter/dashboard', function () {
        return view('transporter_dashboard');
    })->name('transporter.dashboard');
});

// Ensure this points to the HomeController
Route::get('/buyer/dashboard', [HomeController::class, 'buyerDashboard'])->name('buyer.dashboard');

// FIXED LINE: Use the short class name since you already have the 'use' statement at the top
Route::get('/products/{product}', [HomeController::class, 'showProduct'])->name('products.show');