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
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6 border-l-4 border-green-500">
                <h3 class="text-lg font-bold mb-4 text-green-700">Available Delivery Jobs</h3>
                <table class="min-w-full border">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3 border">Order ID</th>
                            <th class="p-3 border">Product</th>
                            <th class="p-3 border">Buyer</th>
                            <th class="p-3 border text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($availableOrders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 border font-semibold">#{{ $order->id }}</td>
                                <td class="p-3 border">{{ $order->product->name }}</td>
                                <td class="p-3 border">{{ $order->buyer->name }}</td>
                                <td class="p-3 border text-center">
                                    <form action="{{ route('orders.accept', $order->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded transition shadow-sm">
                                            Accept Job
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="p-4 text-center text-gray-500 italic">No new orders available right now.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                <h3 class="text-lg font-bold mb-4 text-blue-700">My Active Shipments</h3>
                <table class="min-w-full border">
                    <thead>
                        <tr class="bg-blue-50 text-left">
                            <th class="p-3 border">Order ID</th>
                            <th class="p-3 border">Product</th>
                            <th class="p-3 border">Status</th>
                            <th class="p-3 border">Customer</th>
                            <th class="p-3 border text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($myActiveJobs as $job)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 border">#{{ $job->id }}</td>
                                <td class="p-3 border">{{ $job->product->name }}</td>
                                <td class="p-3 border">
                                    <span class="px-2 py-1 rounded text-xs font-bold bg-blue-100 text-blue-800">
                                        {{ strtoupper($job->status) }}
                                    </span>
                                </td>
                                <td class="p-3 border">{{ $job->buyer->name }}</td>
                                <td class="p-3 border text-center">
                                    <form action="{{ route('orders.complete', $job->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded transition shadow-sm">
                                            Mark Delivered
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="p-4 text-center text-gray-500 italic">You haven't accepted any jobs yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>