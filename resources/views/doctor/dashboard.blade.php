@extends('layouts.doctor')

@section('title', 'Registration')

@section('contents')

<div class="p-6">
    <!-- Patient Charts Section -->
    <div class="bg-gray-50 rounded-lg mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Latest Patient Charts</h1>

        <div class="overflow-y-auto rounded-lg shadow-lg p-4 bg-white">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($patients as $record)
                <a href="{{ route('doctor_record', $record->id) }}">
                    <div class="bg-white border border-gray-200 shadow-xl rounded-xl p-6 transition transform hover:scale-105 hover:shadow-2xl">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-semibold text-gray-800">{{ $record->patient->profile->name ?? 'Unknown' }}</h2>
                            <span class="inline-block bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded-full">{{ $record->patient->profile->condition ?? 'Stable' }}</span>
                        </div>

                        <div class="space-y-4">
                            <p class="text-gray-600"><strong>Age:</strong> {{ $record->patient->profile->age ?? 'N/A' }}</p>
                            @php
                                $latestAdmission = $record->patient->admission()->latest()->first();
                            @endphp
                            <p class="text-gray-600"><strong>Room:</strong> {{ $latestAdmission->room ?? 'N/A' }}</p>
                            <p class="text-gray-600"><strong>Rounds:</strong> {{ $record->rounds ?? 'N/A' }}</p>
                            <p class="text-gray-600"><strong>Admitting Date and Time:</strong> {{ $record->admitting_date_and_time ?? 'N/A' }}</p>

                            {{-- Latest vital signs --}}
                            @php
                            $latestVital = $record->vital()->latest()->first();
                            @endphp

                            @if ($latestVital)
                            <div class="grid grid-cols-3 gap-4 mt-4">
                                <div class="text-center">
                                    <p class="text-sm text-gray-500">BP</p>
                                    <p class="font-semibold text-gray-800">{{ $latestVital->blood_pressure ?? 'N/A' }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-sm text-gray-500">HR</p>
                                    <p class="font-semibold text-gray-800">{{ $latestVital->respiratory_rate ?? 'N/A' }} bpm</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-sm text-gray-500">Temp</p>
                                    <p class="font-semibold text-gray-800">{{ $latestVital->body_temperature ?? 'N/A' }}°F</p>
                                </div>
                            </div>
                            @else
                                <p class="text-gray-500 italic">No vital records available.</p>
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Patient Registration Table Section -->
    <div class="grid grid-cols-1 gap-6 mb-6">
        <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
            <div class="mb-4">
                <h2 class="font-medium text-lg text-gray-700">Patients</h2>
            </div>

            <!-- Adjusting this section for responsiveness -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[540px]">
                    <thead>
                        <tr>
                            <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tl-md rounded-bl-md">#</th>
                            <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tl-md rounded-bl-md">Name</th>
                            <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">Email</th>
                            <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">Date</th>
                            <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tr-md rounded-br-md">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patientRecords as $record)
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-50">
                                {{ $loop->iteration }}
                            </th>
                            <td class="py-2 px-4 border-b border-gray-50">
                                {{ $record->patient->name }}
                            </td>
                            <td class="py-2 px-4 border-b border-gray-50">
                                {{ $record->patient->email }}
                            </td>
                            <td class="py-2 px-4 border-b border-gray-50">
                                {{ $record->created_at->format('Y-m-d') }}
                            </td>
                            <td class="py-2 px-4 border-b border-gray-50">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('doctor_detailspatient', $record->patient->id) }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 transition duration-200">Details</a>
                                    <a href="{{ route('doctor.dischargePage', $record->patient->id) }}" class="text-white bg-orange-600 hover:bg-red-700 focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-sm px-3 py-2 transition duration-200">Discharge</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
