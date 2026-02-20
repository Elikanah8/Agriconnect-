<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Farmer\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// FIXED: The main dashboard route should handle ALL roles
Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- FARMER ROUTES ---
Route::middleware(['auth', 'user-role:farmer'])->group(function () {
    Route::get('/farmer/dashboard', [HomeController::class, 'farmerDashboard'])->name('farmer.dashboard');
    Route::post('/farmer/products', [ProductController::class, 'store'])->name('farmer.products.store');
    
    // Management routes for products
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // NEW: Route for farmer to accept an order
    Route::post('/orders/{order}/accept', [HomeController::class, 'acceptOrder'])->name('orders.accept');
});

// --- BUYER ROUTES ---
Route::middleware(['auth', 'user-role:buyer'])->group(function () {
    Route::get('/buyer/dashboard', [HomeController::class, 'buyerDashboard'])->name('buyer.dashboard');
    
    // Route to handle placing the order
    Route::post('/order/store/{product}', [HomeController::class, 'placeOrder'])->name('orders.store');
});

// --- TRANSPORTER ROUTES ---
Route::middleware(['auth', 'user-role:transporter'])->group(function () {
    // FIXED: Corrected syntax to point to controller
    Route::get('/transporter/dashboard', [HomeController::class, 'transporterDashboard'])->name('transporter.dashboard');
});

// Publicly accessible product view
Route::get('/products/{product}', [HomeController::class, 'showProduct'])->name('products.show');

require __DIR__.'/auth.php';