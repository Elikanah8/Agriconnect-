<x-app-layout>
    <p class="text-red-500">Number of products found: {{ count($products) }}</p>
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

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-bold mb-4">Upload New Product</h3>
            
            <form action="{{ route('farmer.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 15px;">
                    <input type="text" name="name" placeholder="Product Name (e.g. Maize)" class="w-full border-gray-300 rounded-md" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <textarea name="description" placeholder="Description" class="w-full border-gray-300 rounded-md"></textarea>
                </div>
                <div style="margin-bottom: 15px; display: flex; gap: 10px;">
                    <input type="number" name="price" placeholder="Price" step="0.01" class="border-gray-300 rounded-md" required>
                    <input type="number" name="quantity" placeholder="Quantity" class="border-gray-300 rounded-md" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <label class="block mb-2">Product Photo:</label>
                    <input type="file" name="image" accept="image/*" class="border-gray-300">
                </div>
                <button type="submit" style="background: #28a745; color: white; padding: 10px 20px; border-radius: 5px; border: none; cursor: pointer;">
                    Upload Product
                </button>
            </form>
        </div>
    </div>
</div>
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-bold mb-4">Your Active Listings</h3>
            
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b">
                        <th class="p-2">Image</th>
                        <th class="p-2">Product</th>
                        <th class="p-2">Price</th>
                        <th class="p-2">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr class="border-b">
                        <td class="p-2">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="crop" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                            @else
                                <span class="text-gray-400 text-xs">No Image</span>
                            @endif
                        </td>
                        <td class="p-2 font-semibold">{{ $product->name }}</td>
                        <td class="p-2">{{ number_format($product->price, 2) }} KES</td>
                        <td class="p-2">{{ $product->quantity }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if($products->isEmpty())
                <p class="text-gray-500 mt-4 text-center">You haven't listed any crops yet.</p>
            @endif
        </div>
    </div>
</div>
</x-app-layout>