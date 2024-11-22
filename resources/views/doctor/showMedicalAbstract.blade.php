@extends('layouts.registration')

@section('title', 'Registration')

@section('contents')

<div class="p-6 space-y-6"> <!-- Added space-y-6 to create uniform spacing between sections -->
    <h1 class="text-2xl font-bold mb-4"> Medical Abstract</h1>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Basic Information -->
        <div class="lg:col-span-1 bg-white p-4 rounded-md shadow-md border border-gray-200">
            <div class="flex justify-between items-center bg-gray-100 rounded-t-md p-4">
                <h2 class="text-lg font-semibold text-gray-800">Basic Information</h2>
            </div>
            <div class="p-4 space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Name</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $record->patient->profile->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Age</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $record->patient->profile->age ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Birthday</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $record->patient->profile->birthday ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Birthplace</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $record->patient->profile->birthplace ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Civil Status</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $record->patient->profile->civil_status ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Gender</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $record->patient->profile->gender ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Telephone No</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $record->patient->profile->telephone_no ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        
            <!-- Admission -->
            <div class="lg:col-span-2 bg-white p-4 rounded-md shadow-md border border-gray-200">
                <div class="flex justify-between items-center bg-gray-100 rounded-t-md p-4">
                    <h2 class="text-lg font-semibold text-gray-800">Admission</h2>
                </div>
                <div class="p-4 space-y-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Reason for Admission</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $record->reason_for_admission ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Room</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $record->admission->room ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Attending Physician</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $record->admission->doctor->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Attending Nurse</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $record->admission->nurse->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Admitting Department</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $record->admission->department->department_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Admitting Date and Time</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $record->admitting_date_and_time ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <!-- Vitals -->
    <div class="lg:col-span-2 bg-white p-4 rounded-md shadow-md border border-gray-200">
        <div class="flex justify-between items-center bg-gray-100 rounded-t-md p-4">
            <h2 class="text-lg font-semibold text-gray-800">Medical Orders</h2>
        </div>

        <div class="p-4 space-y-6">
            @forelse ($record->order as $order)
                <div class="border-b border-gray-200 pb-4 mb-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Order Title</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $order->title ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Type</p>
                        <p class="text-lg text-gray-800">{{ $order->type ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Description</p>
                        <p class="text-lg text-gray-800">{{ $order->description ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Status</p>
                        <p class="text-lg text-gray-800">{{ $order->status ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Ordered by</p>
                        <p class="text-lg font-semibold text-gray-800">Dr. {{ $order->doctor->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Order Date</p>
                        <p class="text-lg text-gray-800">{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') : 'N/A' }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">No medical orders available.</p>
            @endforelse
        </div>
    </div>

    
        <!-- Test -->
        <div class="lg:col-span-2 bg-white p-4 rounded-md shadow-md border border-gray-200">
        <div class="flex justify-between items-center bg-gray-100 rounded-t-md p-4">
            <h2 class="text-lg font-semibold text-gray-800">Patient Admissions</h2>
        </div>

        <div class="p-4 space-y-4">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Admissions</p>
                <p class="text-lg font-semibold text-gray-800">{{ $record->count() ?? '0' }}</p>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-500">Admission Records</p>
                <div class="space-y-2">
                    @foreach ($patient->patientrecord as $admission)
                        <div class="flex justify-between">
                            <span class="text-gray-700">{{ $admission->reason_for_admission }}</span>
                            <span class="font-semibold {{ $admission->status === 'discharged' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $admission->status === 'discharged' ? 'Cleared' : 'Not Cleared' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-500">Current Status</p>
                @php
                    // Check if there are any admissions with the status 'admitted' or 'pending'
                    $hasActiveAdmissions = $patient->patientrecord->contains(function ($admission) {
                        return $admission->status === 'admitted' || $admission->status === 'pending';
                    });
                @endphp
                <p class="text-lg font-semibold {{ $hasActiveAdmissions ? 'text-red-600' : 'text-green-600' }}">
                    {{ $hasActiveAdmissions ? 'Not Cleared to Leave' : 'Cleared to Leave' }}
                </p>
            </div>

        </div>
    
    </div>
</div>
@endsection
