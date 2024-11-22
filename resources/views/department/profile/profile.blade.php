@extends('layouts.DepartmentProfile')

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
                <div class="text-gray-800 font-bold text-3xl">{{ $department->department_name }}</div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 shadow-md p-6 rounded-lg overflow-x-auto mt-4">
            <!-- Overview Section -->
            <div class="mb-6">
                <div class="text-xl font-semibold text-gray-800">Overview</div>
                <hr class="my-2 border-gray-300">
            </div>

            <!-- department Information Section -->
            <div class="mb-6">
                <div class="text-lg font-semibold text-gray-800">Department Information</div>
                <hr class="my-2 border-gray-300">
                <div class="space-y-4">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="w-full md:w-52 font-medium text-gray-700">Department Code</div>
                        <div class="font-bold text-xl">{{ $department->department_code }}</div>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="w-full md:w-52 font-medium text-gray-700">Department Name</div>
                        <div class="font-bold text-xl">{{ $department->department_name }}</div>
                    </div>
                </div>
            </div>

            <!-- Contact Information Section -->
            <div class="mb-6">
                <div class="text-lg font-semibold text-gray-800">Contact Information</div>
                <hr class="my-2 border-gray-300">
                <div class="space-y-4">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="w-full md:w-52 font-medium text-gray-700">Address</div>
                        <div class="font-bold text-xl">{{ $department->address }}</div>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="w-full md:w-52 font-medium text-gray-700">Contact Number</div>
                        <div class="font-bold text-xl">{{ $department->phone_number }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
