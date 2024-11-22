@extends('layouts.emergencyroom')

@section('title', 'Emergency Room')

@section('contents')

<div class="p-6">
    <div class="grid grid-cols-1 gap-6 mb-6">
        <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
            <div class="flex mb-4">
                <div class="font-medium text-lg text-gray-700">Emergency Room Dashboard</div>
            </div>

            <!-- Search and Filter Section -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
                
                <!-- Status Filter -->
                <form action="{{ route('emergencyroom_dashboard') }}" method="GET" class="flex flex-col sm:flex-row w-full sm:w-auto gap-4">
                    <div>
                        <select name="status" class="w-full sm:w-[180px] border border-gray-300 rounded-lg p-2" onchange="this.form.submit()">
                            <option value="pending" {{ request('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="admitted" {{ request('status') == 'admitted' ? 'selected' : '' }}>Admitted</option>
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

            <!-- Count Information -->
            <div class="flex justify-between items-center bg-gray-100 p-4 rounded-lg">
                <span class="text-sm font-medium">
                    Showing {{ request('status', 'pending') == 'pending' ? 'Pending Patients' : 'Admitted Patients' }}
                </span>
                <span class="text-sm text-gray-500">
                    Total: {{ $patients->count() }} {{ request('status', 'pending') == 'pending' ? 'Pending Patients' : 'Admitted Patients' }}
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
                            <th class="text-xs uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">Status</th>
                            <th class="text-xs uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tr-md">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patients as $patient)
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border-b border-gray-200">{{ $loop->iteration }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $patient->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $patient->email }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">
                                    @if ($patient->status === 'pending')
                                        <span class="text-lg font-semibold text-yellow-400">Pending</span>
                                    @elseif ($patient->status === 'admitted')
                                        <span class="text-lg font-semibold text-green-400">Admitted</span>
                                    @elseif ($patient->status === 'not admitted')
                                        <span class="text-lg font-semibold text-gray-400">Not Admitted</span>
                                    @elseif ($patient->status === 'discharged')
                                        <span class="text-lg font-semibold text-red-400">Discharged</span>
                                    @else
                                        <span class="text-lg font-semibold text-gray-400">N/A</span>
                                    @endif
                                </td>
                                <td class="py-2 px-4 border-b border-gray-200">
                                    <div class="flex gap-2">
                                        <a href="{{ route('emergencyroom_patients_profile', $patient->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-blue-300 transition duration-200">Detail</a>
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

<script>
    function toggleDropdown() {
        document.getElementById('dropdownMenu').classList.toggle('hidden');
    }
</script>
        
@endsection
