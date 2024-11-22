<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <title>@yield('title')</title>
</head>
<body class="text-gray-800 font-inter">
    
    <!-- start: Sidebar -->
    <div class="fixed left-0 top-0 w-64 h-full bg-gray-900 p-4 z-50 sidebar-menu transition-transform">
        <a href="{{ route('department_dashboard') }}" class="flex items-center pb-4 border-b border-b-gray-800">
            <img src="/logo.png" alt="" class="w-8 h-8 rounded object-cover">
            <span class="text-lg font-bold text-white ml-3">Hospital</span>
        </a>
        <ul class="mt-4">
            <li class="mb-1 group">
                <a href="{{ route('emergencyroom_dashboard') }}" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                    <i class="ri-file-line mr-3 text-lg"></i>
                    <span class="text-sm">Dashboard</span>
                </a>
            </li>
            <li class="mb-1 group">
                <a href="{{ route('emergencyroom_medical_order') }}" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                    <i class="ri-file-list-3-line mr-3 text-lg"></i>
                    <span class="text-sm">Medical Orders</span>
                </a>
            </li>
            <li class="mb-1 group">
                <a href="{{ route('emergencyroom_scan_qr') }}" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                    <i class="ri-qr-scan-line mr-3 text-lg"></i>
                    <span class="text-sm">Scan QR Code</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 md:hidden sidebar-overlay"></div>
    <!-- end: Sidebar -->

    
    <main class="w-full md:w-[calc(100%-256px)] md:ml-64 bg-gray-50 min-h-screen transition-all main">
        <div class="py-2 px-6 bg-white flex items-center shadow-md shadow-black/5 sticky top-0 left-0 z-30">
            <button type="button" class="text-lg text-gray-600 sidebar-toggle">
                <i class="ri-menu-line"></i>
            </button>
            
            <ul class="ml-auto flex items-center">    
                <!-- Notification Bell Icon -->
                <li class="relative ml-3 dropdown">
                    <button type="button" class="dropdown-toggle relative text-gray-600">
                        <i class="ri-notification-3-line text-xl"></i>
                        @php
                            $user = auth()->guard('eroom')->user();
                        @endphp

                        @if($user && optional($user->unreadNotifications)->count() > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                                {{ $user->unreadNotifications->count() }}
                            </span>
                        @endif

                    </button>

                    <!-- Notifications Dropdown -->
                    <div id="notificationDropdown" class="dropdown-menu hidden absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg max-h-80 overflow-y-auto">
                        <ul id="latestNotifications">
                            @foreach($latestNotifications as $notification)
                            <li class="p-2 border-b text-sm {{ $notification->read_at ? 'text-gray-500' : 'font-semibold text-black' }}">
                                @if(isset($notification->data['url']))
                                    <a href="{{ $notification->data['url'] }}" class="block hover:bg-gray-100 p-2 rounded-md flex items-center">
                                        @if(!$notification->read_at)
                                            <i class="ri-circle-fill text-blue-500 mr-2"></i>
                                        @endif
                                        {{ $notification->data['message'] }}
                                    </a>
                                @else
                                    <span class="block p-2 rounded-md flex items-center">
                                        @if(!$notification->read_at)
                                            <i class="ri-circle-fill text-blue-500 mr-2"></i>
                                        @endif
                                        {{ $notification->data['message'] }}
                                    </span>
                                @endif
                            </li>
                            @endforeach
                        </ul>

                        <!-- Hidden Section for Older Notifications -->
                        <ul id="olderNotifications" class="hidden">
                            @foreach($olderNotifications as $notification)
                            <li class="p-2 border-b text-sm {{ $notification->read_at ? 'text-gray-500' : 'font-semibold text-black' }}">
                                @if(isset($notification->data['url']))
                                    <a href="{{ $notification->data['url'] }}" class="block hover:bg-gray-100 p-2 rounded-md flex items-center">
                                        @if(!$notification->read_at)
                                            <i class="ri-circle-fill text-blue-500 mr-2"></i>
                                        @endif
                                        {{ $notification->data['message'] }}
                                    </a>
                                @else
                                    <span class="block p-2 rounded-md flex items-center">
                                        @if(!$notification->read_at)
                                            <i class="ri-circle-fill text-blue-500 mr-2"></i>
                                        @endif
                                        {{ $notification->data['message'] }}
                                    </span>
                                @endif
                            </li>
                            @endforeach
                        </ul>

                        <!-- Link to show older notifications -->
                        @if($olderNotifications->isNotEmpty())
                            <div class="p-2 text-center">
                                <button onclick="toggleOlderNotifications()" class="text-blue-500 text-sm" id="toggleButton">See Previous Notifications</button>
                            </div>
                        @endif
                    </div>
                </li>

                <li class="dropdown ml-3">
                    <button type="button" class="dropdown-toggle flex items-center">
                        <i class="ri-user-3-line text-xl text-blue-500 mr-2"></i>
                    </button>
                    <ul class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                        <li>
                            <a href="{{ route('emergencyroom_profile', $eroom->id) }}" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Profile</a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <script>
            function toggleNotifications() {
                var dropdown = document.getElementById('notificationDropdown');
                dropdown.classList.toggle('hidden');
            }

            function toggleOlderNotifications() {
                var olderNotifications = document.getElementById('olderNotifications');
                var toggleButton = document.getElementById('toggleButton');

                if (olderNotifications.classList.contains('hidden')) {
                    olderNotifications.classList.remove('hidden');
                    toggleButton.textContent = 'Show Less';
                } else {
                    olderNotifications.classList.add('hidden');
                    toggleButton.textContent = 'See Previous Notifications';
                }
            }
        </script>

        
        <div id="loading-spinner" class="hidden fixed inset-0 flex items-center justify-center bg-white bg-opacity-75 z-50">
            <div class="w-16 h-16 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
        </div>

        <div class="p-6">
            @if(session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            @if(session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            <div>@yield('contents')</div>
        </div>
    </main>

    


</body>
</html>