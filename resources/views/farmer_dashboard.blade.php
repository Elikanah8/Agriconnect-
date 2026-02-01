<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Farmer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div>Welcome back! Manage your crop listings for AgriConnect.</div>
                    <div class="text-sm font-bold text-green-600">Active Products: {{ $products->count() }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold mb-4 text-green-700 underline">Upload New Product</h3>
                <form action="{{ route('farmer.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <input type="text" name="name" placeholder="Product Name (e.g. Maize)" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <select name="category" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="" disabled selected>Select Category</option>
                                <option value="Grains">Grains</option>
                                <option value="Vegetables">Vegetables</option>
                                <option value="Fruits">Fruits</option>
                                <option value="Livestock">Livestock</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div>
                            <input type="number" name="price" placeholder="Price (KES)" step="0.01" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <textarea name="description" placeholder="Short description of the quality/type..." class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    </div>

                    <div class="mb-4 flex gap-4 items-center">
                        <input type="number" name="quantity" placeholder="Quantity Available" class="border-gray-300 rounded-md shadow-sm w-1/2" required>
                        <div class="w-1/2">
                            <label class="block text-xs text-gray-500">Product Photo:</label>
                            <input type="file" name="image" accept="image/*" class="text-sm">
                        </div>
                    </div>

                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-md transition duration-200">
                        Upload Product
                    </button>
                </form>
            </div>

            <h3 class="text-lg font-bold mb-4 text-gray-700">Your Active Listings</h3>
            @if($products->isEmpty())
                <div class="bg-white p-10 text-center rounded-lg shadow-sm">
                    <p class="text-gray-500 italic">You haven't listed any crops yet. Use the form above to start!</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col relative">
                            <span class="absolute top-2 right-2 bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded">
                                {{ $product->category ?? 'General' }}
                            </span>

                            <div class="h-48 w-full bg-gray-100">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400 text-xs uppercase font-bold">No Image</div>
                                @endif
                            </div>
                            <div class="p-4 flex-grow">
                                <h4 class="font-bold text-gray-800 text-lg">{{ $product->name }}</h4>
                                <p class="text-green-600 font-bold text-xl">{{ number_format($product->price, 2) }} KES</p>
                                <p class="text-gray-500 text-sm mt-1">Stock: {{ $product->quantity }} units</p>
                            </div>
                            <div class="p-4 border-t bg-gray-50 flex justify-between">
                                <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900 font-bold text-sm">Edit Details</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-bold text-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>