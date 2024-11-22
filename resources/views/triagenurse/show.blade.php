@extends('layouts.registration')

@section('title', 'Registration')

@section('contents')

<div class="p-6 space-y-6"> <!-- Added space-y-6 to create uniform spacing between sections -->
    <h1 class="text-2xl font-bold mb-4"> Admission</h1>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Basic Information -->
        <div class="lg:col-span-1 bg-white p-4 rounded-md shadow-md border border-gray-200">
            <div class="flex justify-between items-center bg-gray-100 rounded-t-md p-4">
                <h2 class="text-lg font-semibold text-gray-800">Basic Information</h2>
            </div>
            <div class="p-4 space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Name</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->patient->profile->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Age</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->patient->profile->age ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Birthday</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->patient->profile->birthday ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Birthplace</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->patient->profile->birthplace ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Civil Status</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->patient->profile->civil_status ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Gender</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->patient->profile->gender ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Telephone No</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->patient->profile->telephone_no ?? 'N/A' }}</p>
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
                        <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->reason_for_admission ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Room</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->admission->room ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Attending Physician</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->admission->doctor->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Attending Nurse</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->admission->nurse->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Admitting Department</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->admission->department->department_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Admitting Date and Time</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->admitting_date_and_time ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <!-- Vitals -->
    <div class="lg:col-span-2 bg-white p-4 rounded-md shadow-md border border-gray-200">
        <div class="flex justify-between items-center bg-gray-100 rounded-t-md p-4">
            <h2 class="text-lg font-semibold text-gray-800">Vitals</h2>
        </div>
        <div class="p-4 space-y-6">
            <div>
                <p class="text-sm font-medium text-gray-500">Body Temperature</p>
                <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->vital->body_temperature ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Blood Pressure</p>
                <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->vital->blood_pressure ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Respiratory Rate</p>
                <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->vital->respiratory_rate ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Weight</p>
                <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->vital->weight ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Height</p>
                <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->vital->height ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Pulse Rate</p>
                <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->vital->pulse_rate ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    
        <!-- Test -->
        <div class="lg:col-span-2 bg-white p-4 rounded-md shadow-md border border-gray-200">
            <div class="flex justify-between items-center bg-gray-100 rounded-t-md p-4">
                <h2 class="text-lg font-semibold text-gray-800">Test/Medication</h2>
            </div>
            <div class="p-4 space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">History of Present Illness</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->test->hpi ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Note</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->test->note ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Medication</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->test->medication ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Chief Complaint</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->test->chief_complaint ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Diagnose</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->test->diagnose ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    
    </div>
</div>
@endsection
