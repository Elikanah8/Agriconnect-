<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transporter Delivery Portal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Available Delivery Jobs</h3>
                
                <table class="min-w-full border">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="p-3">Order ID</th>
                            <th class="p-3">Pickup</th>
                            <th class="p-3">Destination</th>
                            <th class="p-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($availableOrders as $order)
                        <tr class="border-t">
                            <td class="p-3 font-semibold text-blue-600">#{{ $order->id }}</td>
                            <td class="p-3">{{ $order->pickup_address ?? 'Nairobi Central' }}</td>
                            <td class="p-3">{{ $order->delivery_address ?? 'KCA University' }}</td>
                            <td class="p-3 text-center">
                                <form action="{{ route('orders.accept', $order->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded transition">
                                        Accept Delivery
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-3 text-center text-gray-500 italic">
                                No available orders at the moment.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>