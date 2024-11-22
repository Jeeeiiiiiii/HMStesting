@extends('layouts.EmergencyRoomProfile')

@section('title', 'Profile')

@section('contents')
<div class="p-6">
    <div class="grid grid-cols-1 lg:grid-cols-1 gap-6">
        <!-- Welcome Section -->
        <div class="bg-gray-100 shadow-lg p-6 rounded-lg">
            <div class="mb-4">
                <div class="text-gray-600 font-medium text-lg">Welcome!</div>
            </div>
            <div>
                <div class="text-gray-800 font-bold text-3xl">{{ $eroom->department_name }}</div>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <ul class="mt-1 ml-4 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white border border-gray-200 shadow-md p-6 rounded-lg mt-4">
            <div class="flex mb-6 items-center">
                <div class="text-xl font-semibold text-gray-800">Change Your Password</div>
            </div>
            
            <form action="{{ route('emergencyroom_submitpass') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="w-full md:w-1/3 mb-2 md:mb-0">
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                        </div>
                        <div class="w-full md:w-2/3">
                            <input type="password" name="current_password" id="current_password" class="w-full border border-gray-300 p-3 rounded-md" required>
                        </div>
                    </div>
                    
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="w-full md:w-1/3 mb-2 md:mb-0">
                            <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                        </div>
                        <div class="w-full md:w-2/3">
                            <input type="password" name="new_password" id="new_password" class="w-full border border-gray-300 p-3 rounded-md" required>
                        </div>
                    </div>
                    
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="w-full md:w-1/3 mb-2 md:mb-0">
                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Retype New Password</label>
                        </div>
                        <div class="w-full md:w-2/3">
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="w-full border border-gray-300 p-3 rounded-md" required>
                        </div>
                    </div>
                    
                    <div class="flex justify-center">
                        <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 transition duration-200">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-blue-100 text-blue-800 p-4 rounded-md mt-4">
            <p class="text-sm">Enter your current and new password, then click the "Save Changes" button to change your password.</p>
        </div>
    </div>
</div>
@endsection
