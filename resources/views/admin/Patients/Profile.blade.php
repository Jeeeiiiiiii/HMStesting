@extends('layouts.admin')

@section('title', 'Patient Profile')

@section('contents')

<div class="container mx-auto py-8 px-4">
    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <div class="flex flex-col sm:flex-row items-center gap-6">
            <div class="text-center sm:text-left">
                <div class="flex space-x-4">
                    <h2 class="text-4xl font-semibold mb-2">{{ $patient->name }}</h2>
                </div>
                <p class="text-lg text-gray-600 mb-2">Departments:
                    @if($patient->admission->isEmpty())
                        <span class="text-gray-400">N/A</span>
                    @else
                        @php
                            $uniqueDepartments = $patient->admission->pluck('department.department_name')->unique();
                        @endphp
                        @if($uniqueDepartments->isEmpty())
                            <span class="text-gray-400">N/A</span>
                        @else
                            @foreach($uniqueDepartments as $departmentName)
                                <span class="inline-block bg-blue-100 text-blue-600 rounded-full px-2 py-1 text-sm font-medium mr-2">{{ $departmentName }}</span>
                            @endforeach
                        @endif
                    @endif
                </p>


            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
            <div class="space-y-2">
                <div class="flex items-center">
                    <i class="ri-phone-line text-blue-600 mr-2"></i>
                    <span class="text-lg">Telephone No: {{ $patient->profile->telephone_no }}</span>
                </div>
                <div class="flex items-center">
                    <i class="ri-mail-line text-blue-600 mr-2"></i>
                    <span class="text-lg">Contact Address: {{ $patient->email }}</span>
                </div>
            </div>
        </div>
    </div>

    
</div>

@endsection