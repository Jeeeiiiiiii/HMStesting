@extends('layouts.department')

@section('title', 'Medical Order')

@section('contents')
<div class="p-6 space-y-6">

    <!-- Patient Case and Name Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-md border border-gray-100 p-6 shadow-lg">
            <div class="flex justify-between items-center">
                <div class="text-lg font-semibold text-gray-600">PATIENT CASE:</div>
                <div class="text-lg font-semibold text-gray-600">P-{{ $patient->patient->id ?? 'N/A' }}</div>
            </div>
        </div>

        <div class="bg-white rounded-md border border-gray-100 p-6 shadow-lg">
            <div class="flex justify-between items-center">
                <div class="text-lg font-semibold text-gray-600">PATIENT NAME:</div>
                <div class="text-lg font-semibold text-gray-800">{{ $patient->patient->profile->name ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    <!-- Details and Doctors Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Patient Details -->
        <div class="lg:col-span-1 bg-white rounded-md border border-gray-100 shadow-lg">
            <div class="bg-gray-600 text-white text-lg font-semibold rounded-t-lg p-4">
                Details
            </div>
            <div class="p-6 space-y-4">
                @foreach (['AGE' => $patient->patient->profile->age, 'BIRTHDAY' => $patient->patient->profile->birthday, 'BIRTHPLACE' => $patient->patient->profile->birthplace, 'CIVIL STATUS' => $patient->patient->profile->civil_status, 'RELIGION' => $patient->patient->profile->religion, 'NATIONALITY' => $patient->patient->profile->nationality, 'GENDER' => $patient->patient->profile->gender, 'TELEPHONE NO.' => $patient->patient->profile->telephone_no] as $label => $value)
                <div>
                    <div class="text-sm font-semibold text-gray-500">{{ $label }}</div>
                    <div class="text-lg font-semibold text-gray-800">{{ $value ?? 'N/A' }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Admission Details -->
        <div class="lg:col-span-2 bg-white rounded-md border border-gray-100 shadow-lg">
            <div class="bg-gray-600 text-white text-lg font-semibold rounded-t-lg p-4">
                Order Details
            </div>
            <div class="p-6">
                <!-- Title -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <p class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full">{{ $patient->title }}</p>
                </div>

                <!-- Order Type -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Order Type</label>
                    <p class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full">{{ $patient->type }}</p>
                </div>

                <!-- Order Description -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <p class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full">{{ $patient->description }}</p>
                </div>

                <!-- Order Status -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <p class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full">{{ $patient->status }}</p>
                </div>

                <!-- Order Date -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Order Date</label>
                    @php
                        $orderDate = new DateTime($patient->order_date); // Convert string to DateTime object
                    @endphp
                    <p class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full">{{ $orderDate->format('F j, Y') }}</p>
                </div>
            </div>   
        </div>
    </div>
</div>
@endsection
