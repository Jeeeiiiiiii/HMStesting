@extends('layouts.doctor')

@section('title', 'Discharge Details')

@section('contents')
<div class="p-6 space-y-6">

    <!-- Patient Case and Name Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-md border border-gray-100 p-6 shadow-lg">
            <div class="flex justify-between items-center">
                <div class="text-lg font-semibold text-gray-600">PATIENT CASE:</div>
                <div class="text-lg font-semibold text-gray-600">P-{{ $patient->id ?? 'N/A' }}</div>
            </div>
        </div>

        <div class="bg-white rounded-md border border-gray-100 p-6 shadow-lg">
            <div class="flex justify-between items-center">
                <div class="text-lg font-semibold text-gray-600">PATIENT NAME:</div>
                <div class="text-lg font-semibold text-gray-800">{{ $patient->profile->name ?? 'N/A' }}</div>
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
                @foreach (['AGE' => $patient->profile->age, 'BIRTHDAY' => $patient->profile->birthday, 'BIRTHPLACE' => $patient->profile->birthplace, 'CIVIL STATUS' => $patient->profile->civil_status, 'RELIGION' => $patient->profile->religion, 'NATIONALITY' => $patient->profile->nationality, 'GENDER' => $patient->profile->gender, 'TELEPHONE NO.' => $patient->profile->telephone_no] as $label => $value)
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
                Admission Records
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-center text-gray-600 border-collapse border border-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 font-semibold border-b border-r border-gray-300">Admission</th>
                                <th class="px-4 py-2 font-semibold border-b border-r border-gray-300">Status of Admission</th>
                                <th class="px-4 py-2 font-semibold border-b border-r border-gray-300">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patient->patientrecord as $record)
                            <tr>
                                <td class="px-4 py-2 border-b border-r border-gray-200">
                                    <a href="{{ route('doctor_patientrecord', $record->id) }}" class="text-blue-700 hover:text-blue-500 font-semibold transition-colors duration-100 ease-in-out">
                                        {{ $record->reason_for_admission }}
                                    </a>
                                </td>
                                <td class="px-4 py-2 border-b border-r border-gray-200">
                                    @if ($record->status === 'pending')
                                        <span class="text-lg font-semibold text-yellow-400">Pending</span>
                                    @elseif ($record->status === 'admitted')
                                        <span class="text-lg font-semibold text-green-400">Admitted</span>
                                    @elseif ($record->status === 'not admitted')
                                        <span class="text-lg font-semibold text-gray-400">Not Admitted</span>
                                    @elseif ($record->status === 'discharged')
                                        <span class="text-lg font-semibold text-red-400">Discharged</span>
                                    @else
                                        <span class="text-lg font-semibold text-gray-400">N/A</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border-b border-gray-200">
                                    <form action="{{ route('doctor.discharge', $record->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to discharge this patient?')" class="inline-block">
                                        @csrf
                                        <button type="submit" class="text-white bg-orange-600 hover:bg-red-700 focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-sm px-3 py-2 transition duration-200">
                                            Discharge
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
