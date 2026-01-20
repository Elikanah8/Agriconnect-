<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Farmer\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Default Dashboard (Buyer)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'user-role:buyer'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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