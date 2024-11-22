@extends('layouts.department')

@section('title', 'Nurse Profile')

@section('contents')

<div class="container mx-auto py-8 px-4">
    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <div class="flex flex-col sm:flex-row items-center gap-6">
            <div class="text-center sm:text-left">
                <div class="flex space-x-4">
                    <h2 class="text-4xl font-semibold mb-2">{{ $nurse->name }}</h2>
                    <h2 class="text-4xl font-semibold mb-2">- {{ $nurse->specialization }}</h2>
                </div>
                <p class="text-lg text-gray-600 mb-2">Departments:
                    @if($nurse->departments->isEmpty())
                        <span class="text-gray-400">N/A</span>
                    @else
                        @foreach($nurse->departments as $department)
                            <span class="inline-block bg-blue-100 text-blue-600 rounded-full px-2 py-1 text-sm font-medium mr-2">{{ $department->department_name }}</span>
                        @endforeach
                    @endif
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
            <div class="space-y-2">
                <div class="flex items-center">
                    <i class="ri-phone-line text-blue-600 mr-2"></i>
                    <span class="text-lg">Telephone No: {{ $nurse->profile->telephone_no }}</span>
                </div>
                <div class="flex items-center">
                    <i class="ri-mail-line text-blue-600 mr-2"></i>
                    <span class="text-lg">Contact Address: {{ $nurse->email }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <div class="font-medium text-lg text-gray-700 mb-4">Patients</div>
        
        <!-- Search and Filter Section -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
            <!-- Patient Status Select -->
            <form action="{{ route('department_nurses_profile', $nurse->id) }}" method="GET" class="flex flex-col sm:flex-row w-full sm:w-auto gap-4">
                <div>
                    <select name="status" class="w-full sm:w-[180px] border border-gray-300 rounded-lg p-2" onchange="this.form.submit()">
                        <option value="admitted" {{ request('status', 'admitted') == 'admitted' ? 'selected' : '' }}>Admitted</option>
                        <option value="discharged" {{ request('status') == 'discharged' ? 'selected' : '' }}>Discharged</option>
                    </select>
                </div>

                <!-- Search Input -->
                <div class="flex w-full sm:w-auto items-center space-x-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search patients..." class="w-full sm:w-auto bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md text-sm px-4 py-2 focus:ring-2 focus:ring-blue-300 transition duration-200">
                        <i class="fa fa-search"></i> Search
                    </button>
                </div>
            </form>
        </div>

        <!-- Status Information -->
        <div class="flex justify-between items-center bg-gray-100 p-4 rounded-lg mb-4">
            <span class="text-sm font-medium">
                Showing {{ request('status', 'admitted') == 'admitted' ? 'Admitted' : 'Discharged' }} Patients
            </span>
            <span class="text-sm text-gray-500">
                Total: {{ $patients->count() }} patients
            </span>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full min-w-[540px]">
                <thead>
                    <tr>
                        <th class="text-xs uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tl-md">#</th>
                        <th class="text-xs uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">Name</th>
                        <th class="text-xs uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">Email</th>
                        <th class="text-xs uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">Date</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($patients as $patient)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b border-gray-200">{{ $loop->iteration }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $patient->user->name ?? $patient->name }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $patient->email }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $patient->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach                             
                </tbody>
            </table>            
        </div>
    </div>
</div>

@endsection
