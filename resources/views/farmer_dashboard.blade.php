<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Farmer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Welcome, Farmer! Here you can list your crops for AgriConnect.
                </div>
            </div>
        </div>
    </div>

    use App\Http\Controllers\Farmer\ProductController;

Route::middleware(['auth', 'user-role:farmer'])->group(function () {
    Route::get('/farmer/dashboard', [HomeController::class, 'farmerDashboard'])->name('farmer.dashboard');
    
    // Add this line to handle the form submission
    Route::post('/farmer/products', [ProductController::class, 'store'])->name('farmer.products.store');
});

</x-app-layout>