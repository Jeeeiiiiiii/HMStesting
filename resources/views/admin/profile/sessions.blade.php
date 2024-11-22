@extends('layouts.Adminprofile')

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
                <div class="text-gray-800 font-bold text-3xl">{{ $admin->name }}</div>
            </div>
        </div>

        <!-- Sessions Section -->
        <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-lg overflow-x-auto mt-4">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Sessions</h2>
            <!-- Session Information Section -->
            @foreach($sessions as $session)
                <div class="flex items-center mb-4 p-4 bg-gray-50 rounded-md shadow-sm hover:bg-gray-100 transition">
                    <!-- Display Browser Icon -->
                    @if (strpos($session->browser_name, 'Chrome') !== false)
                        <i class="ri-chrome-line text-2xl text-blue-600 mr-4"></i>
                    @elseif (strpos($session->browser_name, 'Safari') !== false)
                        <i class="ri-safari-line text-2xl text-blue-400 mr-4"></i>
                    @elseif (strpos($session->browser_name, 'Firefox') !== false)
                        <i class="ri-firefox-line text-2xl text-orange-600 mr-4"></i>
                    @elseif (strpos($session->browser_name, 'Edge') !== false)
                        <i class="ri-edge-line text-2xl text-blue-700 mr-4"></i>
                    @elseif (strpos($session->browser_name, 'Opera') !== false)
                        <i class="ri-opera-line text-2xl text-red-600 mr-4"></i>
                    @else
                        <i class="ri-global-line text-2xl text-gray-600 mr-4"></i>
                    @endif

                    <!-- Display Session Details -->
                    <div>
                        <p class="font-medium text-gray-800">{{ $session->device_name }}</p>
                        <p class="text-sm text-gray-600">{{ $session->browser_name }} - {{ $session->last_active_at ? $session->last_active_at->diffForHumans() : 'No activity recorded' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
