@extends('layouts.triagenurse')

@section('title', 'Triage Nurse')

@section('contents')

<div class="p-6">
    <div class="grid grid-cols-1 gap-6 mb-6">
        <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
            <div class="mb-4">
                <h2 class="font-medium text-lg text-gray-700">Patients</h2>
            </div>
            <!-- Search and Filter Section -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
                
                <!-- Status Filter -->
                <form action="{{ route('triagenurse_dashboard') }}" method="GET" class="flex flex-col sm:flex-row w-full sm:w-auto gap-4">
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

                <!-- Add Patient Button -->
                <div class="w-full sm:w-auto">
                    <a href="{{ route('triage_patient_register') }}" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md text-sm px-4 py-2 focus:ring-2 focus:ring-blue-300 transition duration-200 block text-center">Add Patient</a>
                </div>
            </div>

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
                        @foreach ($patients as $patient)
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-50">
                                {{ $loop->iteration }}
                            </th>
                            <td class="py-2 px-4 border-b border-gray-50">
                                {{ $patient->name }}
                            </td>
                            <td class="py-2 px-4 border-b border-gray-50">
                                {{ $patient->email }}
                            </td>
                            <td class="py-2 px-4 border-b border-gray-50">
                                {{ $patient->created_at->format('Y-m-d') }}
                            </td>
                            <td class="py-2 px-4 border-b border-gray-50">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('triagenurse_detailspatient', $patient->id) }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 transition duration-200">Details</a>
                                    <a href="{{ route('triagenurse_addpatient', $patient->id) }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 transition duration-200">Add Assessment</a>
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
