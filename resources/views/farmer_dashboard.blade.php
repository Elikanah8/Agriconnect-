<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
    <h3 class="text-lg font-bold mb-6 text-green-700">Your Active Listings</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($products as $product)
            <div class="bg-white border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col">
                
                <div class="h-48 w-full bg-gray-100">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="flex items-center justify-center h-full text-gray-400">
                            <span>No Image</span>
                        </div>
                    @endif
                </div>

                <div class="p-4 flex-grow">
                    <h4 class="font-bold text-gray-800 text-lg capitalize">{{ $product->name }}</h4>
                    <p class="text-green-600 font-bold text-xl mt-1">{{ number_format($product->price, 2) }} KES</p>
                    <p class="text-gray-500 text-sm">Stock: {{ $product->quantity }} units</p>
                </div>

                <div class="p-4 border-t bg-gray-50 flex justify-between items-center">
                    <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900 font-bold text-sm">
                        Edit
                    </a>
                    
                    <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this listing?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 font-bold text-sm">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    @if($products->isEmpty())
        <div class="text-center py-10">
            <p class="text-gray-500 italic">You haven't listed any crops yet.</p>
        </div>
    @endif
</div>