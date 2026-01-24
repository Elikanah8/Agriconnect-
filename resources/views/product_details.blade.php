<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="rounded-lg w-full object-cover shadow-sm">
                        @else
                            <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded-lg text-gray-400 font-bold">
                                No Image Available
                            </div>
                        @endif
                    </div>

                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">{{ $product->name }}</h2>
                        <p class="text-2xl text-green-600 font-bold mt-2">{{ number_format($product->price, 0) }} KES</p>
                        
                        <hr class="my-4">
                        
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            {{ $product->description ?? 'No description provided for this produce.' }}
                        </p>
                        
                        <div class="bg-gray-50 p-4 rounded-lg mb-6 border border-gray-100">
                            <p class="text-xs uppercase tracking-wider text-gray-500 font-semibold">Sold by:</p>
                            <p class="text-lg font-bold text-gray-900">{{ $product->user->name }}</p>
                        </div>

                        @if($product->user->phone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->user->phone) }}" 
                        target="_blank"
                            class="flex items-center justify-center gap-3 w-full bg-[#25D366] text-white py-4 rounded-lg font-bold hover:bg-[#128C7E] transition shadow-lg text-lg">
                                <i class="fa-brands fa-whatsapp text-2xl"></i> 
                                        Contact Farmer via WhatsApp
                                    </a>
@else
    <div class="flex items-center justify-center gap-3 w-full bg-red-600 text-white py-4 rounded-lg font-bold shadow-lg border-2 border-red-800">
        <i class="fa-solid fa-triangle-exclamation"></i>
        NO PHONE NUMBER PROVIDED
    </div>
@endif
                        
                        <a href="{{ route('dashboard') }}" class="block text-center text-gray-500 mt-8 hover:text-gray-800 transition font-medium">
                            ← Back to Marketplace
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>