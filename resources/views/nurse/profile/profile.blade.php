@extends('layouts.Nurseprofile')

@section('title', 'Registration')

@section('contents')
<div class="p-6">
    <div class="grid grid-cols-1 lg:grid-cols-1 gap-6">
        <!-- Welcome Section -->
        <div class="bg-gray-100 shadow-lg p-6 rounded-lg">
            <div class="mb-4">
                <div class="text-gray-600 font-medium text-lg">Welcome!</div>
            </div>
            <div>
                <div class="text-gray-800 font-bold text-3xl">{{ $nurse->name }}</div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 shadow-md p-6 rounded-lg overflow-x-auto mt-4">
            <!-- Overview Section -->
            <div class="mb-6">
                <div class="text-xl font-semibold text-gray-800">Overview</div>
                <hr class="my-2 border-gray-300">
            </div>

            <!-- Nurse Information Section -->
            <div class="mb-6">
                <div class="text-lg font-semibold text-gray-800">Nurse Information</div>
                <hr class="my-2 border-gray-300">
                <div class="space-y-4">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="w-full md:w-52 font-medium text-gray-700">Name</div>
                        <div class="font-bold text-xl">{{ $nurse->name }}</div>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="w-full md:w-52 font-medium text-gray-700">Age</div>
                        <div class="font-bold text-xl">{{ $nurse->profile->age }}</div>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="w-full md:w-52 font-medium text-gray-700">Gender</div>
                        <div class="font-bold text-xl">{{ $nurse->profile->gender }}</div>
                    </div>
                </div>
            </div>

            <!-- Contact Information Section -->
            <div class="mb-6">
                <div class="text-lg font-semibold text-gray-800">Contact Information</div>
                <hr class="my-2 border-gray-300">
                <div class="space-y-4">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="w-full md:w-52 font-medium text-gray-700">Email Address</div>
                        <div class="font-bold text-xl">{{ $nurse->email }}</div>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="w-full md:w-52 font-medium text-gray-700">Contact Number</div>
                        <div class="font-bold text-xl">{{ $nurse->profile->telephone_no }}</div>
                    </div>
                </div>
            </div>

            <!-- Other Information Section -->
            <div>
                <div class="text-lg font-semibold text-gray-800">Other Information</div>
                <hr class="my-2 border-gray-300">
                <div class="space-y-4">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="w-full md:w-52 font-medium text-gray-700">Birthday</div>
                        <div class="font-bold text-xl">{{ $nurse->profile->birthday }}</div>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="w-full md:w-52 font-medium text-gray-700">Birthplace</div>
                        <div class="font-bold text-xl">{{ $nurse->profile->birthplace }}</div>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="w-full md:w-52 font-medium text-gray-700">Religion</div>
                        <div class="font-bold text-xl">{{ $nurse->profile->religion }}</div>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="w-full md:w-52 font-medium text-gray-700">Nationality</div>
                        <div class="font-bold text-xl">{{ $nurse->profile->nationality }}</div>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="w-full md:w-52 font-medium text-gray-700">Civil Status</div>
                        <div class="font-bold text-xl">{{ $nurse->profile->civil_status }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
