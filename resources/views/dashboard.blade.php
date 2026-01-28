<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ ucfirst(Auth::user()->role) }} {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(Auth::user()->role === 'farmer')
                @include('farmer_dashboard')
            @elseif(Auth::user()->role === 'buyer')
                @include('buyer_dashboard')
            @elseif(Auth::user()->role === 'transporter')
                @include('transporter_dashboard')
            @else
                <div class="bg-white p-6 rounded-lg shadow">
                    {{ __("You're logged in!") }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>