@extends('layouts.department')

@section('title', 'Departments')

@section('contents')

<div class="p-6">
    <div class="grid grid-cols-1 gap-6 mb-6">
        <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
            <div class="flex mb-4">
                <div class="font-medium text-lg text-gray-700">{{ $departments->department_name ?? $person->name }} Department</div>
            </div>

            <!-- Search and Filter Section -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
                
                <!-- Doctor/Nurse Filter -->
                <form action="{{ route('department_dashboard') }}" method="GET" class="flex flex-col sm:flex-row w-full sm:w-auto gap-4">
                    <div>
                        <select name="status" class="w-full sm:w-[180px] border border-gray-300 rounded-lg p-2" onchange="this.form.submit()">
                            <option value="doctor" {{ request('status', 'doctor') == 'doctor' ? 'selected' : '' }}>Doctors</option>
                            <option value="nurse" {{ request('status') == 'nurse' ? 'selected' : '' }}>Nurses</option>
                            <option value="triage_nurse" {{ request('status') == 'triage_nurse' ? 'selected' : '' }}>Triage Nurses</option> <!-- New option -->
                        </select>
                    </div>

                    <!-- Search Input -->
                    <div class="flex w-full sm:w-auto items-center space-x-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search staff..." class="w-full sm:w-auto bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md text-sm px-4 py-2 focus:ring-2 focus:ring-blue-300 transition duration-200">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </form>
            </div>

            <!-- Count Information -->
            <div class="flex justify-between items-center bg-gray-100 p-4 rounded-lg">
                <span class="text-sm font-medium">
                    Showing {{ request('status', 'doctor') == 'doctor' ? 'Doctors' : (request('status') == 'nurse' ? 'Nurses' : 'Triage Nurses') }}
                </span>
                <span class="text-sm text-gray-500">
                    Total: {{ $staff->count() }} {{ request('status', 'doctor') == 'doctor' ? 'Doctors' : (request('status') == 'nurse' ? 'Nurses' : 'Triage Nurses') }}
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
                    @foreach ($staff as $person)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b border-gray-200">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $person->user->name ?? $person->name }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $person->email }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $person->created_at->format('Y-m-d') }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">
                                <div class="flex gap-2">
                                   <a href="{{ request('status', 'doctor') == 'doctor' ? route('department_doctors_profile', $person->id) : (request('status') == 'nurse' ? route('department_nurses_profile', $person->id) : route('department_triage_nurses_profile', $person->id)) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-blue-300 transition duration-200">Detail</a>
                                    <!-- Form for removing staff -->
                                    <form action="{{ route(request('status', 'doctor') == 'doctor' ? 'department.doctors.remove' : (request('status') == 'nurse' ? 'department.nurses.remove' : 'department.triage_nurses.remove'), ['departmentId' => $department->id, request('status', 'doctor') == 'doctor' ? 'doctorId' : (request('status') == 'nurse' ? 'nurseId' : 'triagenurseId') => $person->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this {{ request('status', 'doctor') == 'doctor' ? 'doctor' : (request('status') == 'nurse' ? 'nurse' : 'triage nurse') }} from the department?')">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-orange-300 transition duration-200">
                                            Remove
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

<script>
    function toggleDropdown() {
        document.getElementById('dropdownMenu').classList.toggle('hidden');
    }
</script>
        
@endsection
