@extends('layouts.admin')
 
@section('title', 'Departments')
 
@section('contents')

<div class="p-6">
    <div class="grid grid-cols-1 gap-6 mb-6">
        <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
            <div class="flex mb-4">
                <div class="font-medium text-lg text-gray-700">Department</div>
            </div>

            <!-- Search and Add Buttons -->
            <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-4 gap-4 sm:gap-0">
                <form action="{{ route('admin_departments') }}" method="GET" class="flex w-full sm:w-auto items-center">
                    <input type="text" id="searchInput" name="search" placeholder="Search..." value="{{ request('search') }}" class="w-full sm:w-auto bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-l-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-r-md text-sm px-4 py-2 focus:ring-2 focus:ring-blue-300 transition duration-200">Search</button>
                </form>
                <div class="w-full sm:w-auto">
                    <a href="{{ route('department_register') }}" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md text-sm px-4 py-2 focus:ring-2 focus:ring-blue-300 transition duration-200 block text-center">Add Department</a>
                </div>
            </div>

            <!-- Count Information -->
            <div class="flex justify-between items-center bg-gray-100 p-4 rounded-lg">
                <span class="text-sm text-gray-500">
                    Total: {{ $departments->count() }} departments
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
                    @foreach ($departments as $department)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b border-gray-200">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $department->user->department_name ?? $department->department_name }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $department->email }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $department->created_at->format('Y-m-d') }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">
                                <div class="flex gap-2">
                                    <a href="{{ route('department_details', $department->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-blue-300 transition duration-200">Detail</a>
                                    <form action="{{ route('users.delete', ['userType' => 'department', 'id' => $department->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this department?')">
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