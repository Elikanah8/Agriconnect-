<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buyer Dashboard - Fresh Marketplace') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Available Produce</h3>
                <p class="text-gray-600">Browse fresh crops directly from local farmers.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 bg-gray-100 flex items-center justify-center text-gray-400">No Image</div>
                    @endif

                    <div class="p-4">
                        <h4 class="font-bold text-lg">{{ $product->name }}</h4>
                        <p class="text-green-700 font-bold">{{ number_format($product->price, 2) }} KES</p>
                        <p class="text-sm text-gray-500 mb-4">Qty Available: {{ $product->quantity }}</p>
                        
                        <button class="w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700 font-semibold">
                            View Details
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            @if($products->isEmpty())
                <div class="bg-white p-6 rounded-lg text-center">
                    <p class="text-gray-500">No products are currently listed by farmers.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>