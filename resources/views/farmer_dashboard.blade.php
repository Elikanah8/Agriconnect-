<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6 text-gray-900 flex justify-between items-center">
        <div>Welcome, Farmer! Here you can list your crops for AgriConnect.</div>
        <div class="text-sm font-bold text-green-600">Active Products: {{ count($products) }}</div>
    </div>
</div>

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
    <h3 class="text-lg font-bold mb-4 text-green-700 underline">Upload New Product</h3>
    
    <form action="{{ route('farmer.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div style="margin-bottom: 15px;">
                <input type="text" name="name" placeholder="Product Name (e.g. Maize)" class="w-full border-gray-300 rounded-md" required>
            </div>
            <div style="margin-bottom: 15px;">
                <input type="number" name="price" placeholder="Price per unit" step="0.01" class="w-full border-gray-300 rounded-md" required>
            </div>
        </div>

        <div style="margin-bottom: 15px;">
            <textarea name="description" placeholder="Description" class="w-full border-gray-300 rounded-md"></textarea>
        </div>

        <div style="margin-bottom: 15px; display: flex; gap: 10px; align-items: center;">
            <input type="number" name="quantity" placeholder="Quantity Available" class="border-gray-300 rounded-md w-1/2" required>
            <div class="w-1/2">
                <label class="block text-xs text-gray-500">Product Photo:</label>
                <input type="file" name="image" accept="image/*" class="text-sm">
            </div>
        </div>

        <button type="submit" style="background: #28a745; color: white; padding: 10px 20px; border-radius: 5px; border: none; cursor: pointer;" class="hover:bg-green-600 transition">
            Upload Product
        </button>
    </form>
</div>

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
    <h3 class="text-lg font-bold mb-4">Your Active Listings</h3>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b bg-gray-50">
                    <th class="p-3">Image</th>
                    <th class="p-3">Product</th>
                    <th class="p-3">Price</th>
                    <th class="p-3">Quantity</th>
                    <th class="p-3">Actions</th> </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="crop" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                        @else
                            <div class="w-12 h-12 bg-gray-100 flex items-center justify-center rounded border text-gray-400 text-[10px]">No Image</div>
                        @endif
                    </td>
                    <td class="p-3 font-semibold">{{ $product->name }}</td>
                    <td class="p-3">{{ number_format($product->price, 2) }} KES</td>
                    <td class="p-3">{{ $product->quantity }}</td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-bold">Edit</a>
                        
                        <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this listing?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-bold">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($products->isEmpty())
        <p class="text-gray-500 mt-4 text-center">You haven't listed any crops yet.</p>
    @endif
</div>