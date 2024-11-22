@extends('layouts.registration')

@section('title', 'Registration')

@section('contents')

<div class="p-6 space-y-6"> <!-- Added space-y-6 to create uniform spacing between sections -->
        <div class="bg-gray-100 shadow-lg p-6 rounded-lg">
            <div class="mb-4">
                <h1 class="text-2xl font-bold mb-4"> Medical Order</h1>
            </div>
        </div> 
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Basic Information -->
        <div class="lg:col-span-1 bg-white p-4 rounded-md shadow-md border border-gray-200">
            <div class="flex justify-between items-center bg-gray-100 rounded-t-md p-4">
                <h2 class="text-lg font-semibold text-gray-800">Basic Information</h2>
            </div>
            <div class="p-4 space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Name</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $order->patient->profile->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Age</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $order->patient->profile->age ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Birthday</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $order->patient->profile->birthday ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Birthplace</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $order->patient->profile->birthplace ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Civil Status</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $order->patient->profile->civil_status ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Gender</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $order->patient->profile->gender ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Telephone No</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $order->patient->profile->telephone_no ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        
        <!-- Vitals -->
        <div class="lg:col-span-2 bg-white p-4 rounded-md shadow-md border border-gray-200">
            <div class="flex justify-between items-center bg-gray-100 rounded-t-md p-4">
                <h2 class="text-lg font-semibold text-gray-800">Medical Order</h2>
            </div>
            <div class="p-4 space-y-6">
                <div>
                    <p class="text-sm font-medium text-gray-500">Title</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $order->title ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Order Type</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $order->type ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Description</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $order->description ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Status</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $order->status ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Order Date</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $order->order_date ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Ordered by</p>
                    <p class="text-lg font-semibold text-gray-800">Dr. {{ $order->doctor->name ?? 'N/A' }}</p>
                </div>
            </div>
        </div> 
    </div>
</div>
@endsection
