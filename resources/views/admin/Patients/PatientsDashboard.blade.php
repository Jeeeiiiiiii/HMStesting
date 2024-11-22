@extends('layouts.admin')

@section('title', 'Patients')

@section('contents')

<div class="p-6">
    <div class="grid grid-cols-1 gap-6 mb-6">
        <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
            <div class="font-medium text-lg text-gray-700 mb-4">Patients</div>
            
            <!-- Search and Filter Section -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
                
                <!-- Patient Status Select -->
                <form action="{{ route('admin_patients') }}" method="GET" class="flex flex-col sm:flex-row w-full sm:w-auto gap-4">
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

                <!-- Add Patient Button -->
                <div class="w-full sm:w-auto">
                    <a href="{{ route('patient_register') }}" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md text-sm px-4 py-2 focus:ring-2 focus:ring-blue-300 transition duration-200 block text-center">Add Patient</a>
                </div>
            </div>

            <!-- Status Information -->
            <div class="flex justify-between items-center bg-gray-100 p-4 rounded-lg">
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
                            <th class="text-xs uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tr-md">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($patients as $patient)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b border-gray-200">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $patient->user->name ?? $patient->name }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $patient->email }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $patient->created_at->format('Y-m-d') }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin_patients_profile', $patient->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-blue-300 transition duration-200">Detail</a>
                                    <form action="{{ route('users.delete', ['userType' => 'patient', 'id' => $patient->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this patient?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-red-300 transition duration-200">
                                            Delete
                                        </button>
                                    </form>
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
