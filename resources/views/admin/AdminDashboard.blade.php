@extends('layouts.admin')

@section('title', 'Dashboard')

@section('contents')

<div class="p-6 max-w-7xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-lg hover:shadow-xl transition duration-200 transform hover:scale-105">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <div class="text-3xl font-semibold text-gray-800">{{ $doctorsCount }}</div>
                    <div class="text-md font-medium text-gray-500">Doctors</div>
                </div>
                <img src="/doctor.png" alt="" class="w-14 h-14 rounded-md object-cover block">
            </div>
            <a href="{{ route('admin_doctors') }}" class="text-blue-600 font-semibold text-sm hover:text-blue-700">View details</a>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-lg hover:shadow-xl transition duration-200 transform hover:scale-105">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <div class="text-3xl font-semibold text-gray-800">{{ $nursesCount }}</div>
                    <div class="text-md font-medium text-gray-500">Nurses</div>
                </div>
                <img src="/nurse.png" alt="" class="w-14 h-14 rounded-md object-cover block">
            </div>
            <a href="{{ route('admin_nurses') }}" class="text-blue-600 font-semibold text-sm hover:text-blue-700">View details</a>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-lg hover:shadow-xl transition duration-200 transform hover:scale-105">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <div class="text-3xl font-semibold text-gray-800">{{ $departmentCount }}</div>
                    <div class="text-md font-medium text-gray-500">Departments</div>
                </div>
                <img src="/hospital.png" alt="" class="w-14 h-14 rounded-md object-cover block">
            </div>
            <a href="{{ route('admin_departments') }}" class="text-blue-600 font-semibold text-sm hover:text-blue-700">View details</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-lg hover:shadow-xl transition duration-200 transform hover:scale-105">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <div class="text-3xl font-semibold text-gray-800">{{ $patientsCount }}</div>
                    <div class="text-md font-medium text-gray-500">Patients</div>
                </div>
                <img src="/medical.png" alt="" class="w-14 h-14 rounded-md object-cover block">
            </div>
            <a href="{{ route('admin_patients') }}" class="text-blue-600 font-semibold text-sm hover:text-blue-700">View details</a>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-lg hover:shadow-xl transition duration-200 transform hover:scale-105">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <div class="text-3xl font-semibold text-gray-800">{{ $triageNursesCount }}</div>
                    <div class="text-md font-medium text-gray-500">Triage Nurse</div>
                </div>
                <img src="/nurse.png" alt="" class="w-14 h-14 rounded-md object-cover block">
            </div>
            <a href="{{ route('admin_triagenurse') }}" class="text-blue-600 font-semibold text-sm hover:text-blue-700">View details</a>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-lg hover:shadow-xl transition duration-200 transform hover:scale-105">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <div class="text-3xl font-semibold text-gray-800">{{ $emergencyRoomCount }}</div>
                    <div class="text-md font-medium text-gray-500">Emergency Room</div>
                </div>
                <img src="/er.jpg" alt="" class="w-14 h-14 rounded-md object-cover block">
            </div>
            <a href="{{ route('admin_emergencyroom') }}" class="text-blue-600 font-semibold text-sm hover:text-blue-700">View details</a>
        </div>
    </div>
</div>

@endsection
