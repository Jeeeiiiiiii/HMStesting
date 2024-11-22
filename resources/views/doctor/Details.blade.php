@extends('layouts.doctor')

@section('title', 'Details')

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
                                <th class="px-4 py-2 font-semibold border-b border-r border-gray-300">ER Details</th>
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
                                    <!-- Check if er_order exists before accessing the title -->
                                    <a href="{{ $record->er_order ? route('doctor_erOder', $record->er_order->id) : '#' }}" class="text-blue-700 hover:text-blue-500 font-semibold transition-colors duration-100 ease-in-out">
                                        {{ $record->er_order ? $record->er_order->title : 'No ER Order' }}
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
                                    <form action="{{ route('doctor.updateOrderStatus', $record->id) }}" method="POST" class="flex items-center justify-center">
                                        @csrf
                                        <div class="flex items-center space-x-4">
                                            <select name="status" class="form-select border border-gray-300 rounded-md py-2 px-3 focus:ring focus:ring-blue-500 focus:border-blue-500">
                                                <option value="pending" {{ $record->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="not admitted" {{ $record->status == 'not admitted' ? 'selected' : '' }}>Not Admitted</option>
                                                <option value="admitted" {{ $record->status == 'admitted' ? 'selected' : '' }}>Admit</option>
                                            </select>
                                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-5 rounded shadow transition-all duration-150 ease-in-out">
                                                Update
                                            </button>
                                        </div>
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
