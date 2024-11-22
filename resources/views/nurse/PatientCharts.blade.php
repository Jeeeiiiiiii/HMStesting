@extends('layouts.nurse')

@section('title', 'Patient Charts')

@section('contents')
<div class="container mx-auto p-6 bg-gray-50 rounded-lg">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Patient Charts</h1>

    <div class="h-[calc(100vh-150px)] overflow-y-auto rounded-lg shadow-lg p-4 bg-white">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($patients as $patient)
            <a href="{{ route('nurse_record', $patient->id) }}">
                <div class="bg-white border border-gray-200 shadow-xl rounded-xl p-6 transition transform hover:scale-105 hover:shadow-2xl">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">{{ $patient->patient->profile->name ?? 'Unknown' }}</h2>
                        <span class="inline-block bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded-full">{{ $patient->patient->profile->condition ?? 'Stable' }}</span>
                    </div>

                    <div class="space-y-4">
                        <p class="text-gray-600"><strong>Age:</strong> {{ $patient->patient->profile->age ?? 'N/A' }}</p>
                        @php
                            $latestAdmission = $patient->patient->admission()->latest()->first();
                        @endphp
                        <p class="text-gray-600"><strong>Room:</strong> {{ $latestAdmission->room ?? 'N/A' }}</p>
                        <p class="text-gray-600"><strong>Rounds:</strong> {{ $patient->rounds ?? 'N/A' }}</p>
                        <p class="text-gray-600"><strong>Rounds:</strong> {{ $patient->admitting_date_and_time ?? 'N/A' }}</p>

                        {{-- Latest vital signs --}}
                        @php
                        $latestVital = $patient->vital()->latest()->first();
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
@endsection
