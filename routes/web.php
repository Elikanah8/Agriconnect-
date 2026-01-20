<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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

require __DIR__.'/auth.php';

// 1. Farmer Route
Route::get('/farmer/dashboard', function () {
    return view('farmer_dashboard');
})->middleware(['auth', 'role:farmer'])->name('farmer.dashboard');

// 2. Transporter Route
Route::get('/transporter/dashboard', function () {
    return view('transporter_dashboard');
})->middleware(['auth', 'role:transporter'])->name('transporter.dashboard');

// 3. Buyer / Default Route
Route::get('/dashboard', function () {
    return view('dashboard'); // Or buyer_dashboard if you renamed it
})->middleware(['auth', 'role:buyer'])->name('dashboard');

use App\Http\Controllers\Farmer\ProductController;

Route::middleware(['auth', 'user-role:farmer'])->group(function () {
    Route::get('/farmer/dashboard', [HomeController::class, 'farmerDashboard'])->name('farmer.dashboard');
    
    // Add this line to handle the form submission
    Route::post('/farmer/products', [ProductController::class, 'store'])->name('farmer.products.store');
});