@extends('layouts.registration')

@section('title', 'Registration')

@section('contents')

<div class="p-6 space-y-6"> <!-- Added space-y-6 to create uniform spacing between sections -->
        <div class="bg-gray-100 shadow-lg p-6 rounded-lg">
            <div class="mb-4">
                <h1 class="text-2xl font-bold mb-4">Rounds</h1>
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

        
            <!-- Vitals -->
            <div class="lg:col-span-2 bg-white p-4 rounded-md shadow-md border border-gray-200">
                <div class="flex justify-between items-center bg-gray-100 rounded-t-md p-4">
                    <h2 class="text-lg font-semibold text-gray-800">Vitals</h2>
                </div>
                <div class="p-4 space-y-6">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Body Temperature</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $record->vital->body_temperature ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Blood Pressure</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $record->vital->blood_pressure ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Respiratory Rate</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $record->vital->respiratory_rate ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Weight</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $record->vital->weight ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Height</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $record->vital->height ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pulse Rate</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $record->vital->pulse_rate ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        
    </div>

    
    <!-- Test -->  
    <div class="flex justify-between items-center bg-gray-100 rounded-t-md p-4">
        <h2 class="text-lg font-semibold text-gray-800">Physical Assessment</h2>
    </div>
    <div class="p-4 space-y-4">
        <div>
            <p class="text-sm font-medium text-gray-500">General Appearance</p>
            <p class="text-lg font-semibold text-gray-800">{{ $record->physical_assessment->general_appearance ?? 'N/A' }}</p>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Pain Assessment</p>
            <p class="text-lg font-semibold text-gray-800">{{ $record->physical_assessment->pain_assessment ?? 'N/A' }}</p>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Pain Description</p>
            <p class="text-lg font-semibold text-gray-800">{{ $record->physical_assessment->pain_description ?? 'N/A' }}</p>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Changes in Description</p>
            <p class="text-lg font-semibold text-gray-800">{{ $record->physical_assessment->changes_in_condition ?? 'N/A' }}</p>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Assessment Date</p>
            <p class="text-lg font-semibold text-gray-800">{{ $record->physical_assessment->assessment_date ?? 'N/A' }}</p>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Assessed by</p>
            <p class="text-lg font-semibold text-gray-800">{{ $record->physical_assessment->nurse->name ?? 'N/A' }}</p>
        </div>
    </div>
</div>
@endsection
