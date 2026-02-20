<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transporter Delivery Portal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Available Delivery Jobs</h3>
                
                <table class="min-w-full border">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="p-3 text-left">Order ID</th>
                            <th class="p-3 text-left">Pickup (Farmer)</th>
                            <th class="p-3 text-left">Destination (Buyer)</th>
                            <th class="p-3 text-left">Quantity</th>
                            <th class="p-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($availableJobs as $job)
                        <tr class="border-t">
                            <td class="p-3">#ORD-{{ $job->id }}</td>
                            <td class="p-3">{{ $job->farmer->name }}</td>
                            <td class="p-3">{{ $job->buyer->name }}</td>
                            <td class="p-3">{{ $job->quantity }} units</td>
                            <td class="p-3 text-center">
                                <button class="bg-blue-600 text-white px-4 py-1 rounded">Accept Delivery</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-3 text-center text-gray-500">No pending deliveries available right now.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>