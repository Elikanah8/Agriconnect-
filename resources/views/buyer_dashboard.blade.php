<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buyer Dashboard - Fresh Marketplace') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-6 rounded-lg shadow-sm mb-8 border border-gray-100">
                <form action="{{ route('buyer.dashboard') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    
                    <div class="flex-grow">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Search Products</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="e.g. Maize, Beans, Tomatoes..." 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div class="w-full md:w-56">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                            <option value="">All Categories</option>
                            <option value="Grains" {{ request('category') == 'Grains' ? 'selected' : '' }}>Grains</option>
                            <option value="Vegetables" {{ request('category') == 'Vegetables' ? 'selected' : '' }}>Vegetables</option>
                            <option value="Fruits" {{ request('category') == 'Fruits' ? 'selected' : '' }}>Fruits</option>
                            <option value="Livestock" {{ request('category') == 'Livestock' ? 'selected' : '' }}>Livestock</option>
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-md transition duration-200">
                            Apply
                        </button>
                        
                        @if(request('search') || request('category'))
                            <a href="{{ route('buyer.dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 py-2 px-4 rounded-md text-sm transition">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Available Produce</h3>
                @if(request('search') || request('category'))
                    <p class="text-sm text-gray-500 mt-1">
                        Showing results for: 
                        <span class="font-semibold text-green-600">
                            {{ request('search') ?? 'All' }} 
                            {{ request('category') ? 'in ' . request('category') : '' }}
                        </span>
                    </p>
                @else
                    <p class="text-gray-600">Browse fresh crops directly from local farmers.</p>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($products as $product)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition flex flex-col">
                        
                        <div class="w-full h-48 bg-gray-100 relative"> 
                            @if($product->category)
                                <span class="absolute top-2 left-2 bg-white/90 text-green-800 text-xs font-bold px-2 py-1 rounded shadow-sm border border-green-200 uppercase tracking-wider">
                                    {{ $product->category }}
                                </span>
                            @endif

                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover object-center">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 font-bold text-xs uppercase italic">No Photo</div>
                            @endif
                        </div>

                        <div class="p-4 flex flex-col flex-grow">
                            <h4 class="font-bold text-lg text-gray-800 mb-1">{{ $product->name }}</h4>
                            <p class="text-green-700 font-extrabold text-xl mb-1">{{ number_format($product->price, 0) }} KES</p>
                            <p class="text-xs text-gray-500 mb-4">Stock: {{ $product->quantity }} units available</p>
                            
                            <div class="mt-auto">
                                <a href="{{ route('products.show', $product->id) }}"
                                   class="block text-center w-full bg-red-600 text-white py-2 rounded-md hover:bg-red-700 font-semibold transition">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-12 rounded-lg text-center shadow-sm border border-dashed border-gray-300">
                        <div class="text-gray-400 mb-4">
                            <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">No products found</h3>
                        <p class="text-gray-500 mt-2">We couldn't find any products matching your current filters.</p>
                        <div class="mt-6">
                            <a href="{{ route('buyer.dashboard') }}" class="text-green-600 font-bold hover:underline">
                                Clear all filters and try again
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>