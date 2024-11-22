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
        <a href="{{ route('patient_dashboard') }}" class="flex items-center pb-4 border-b border-b-gray-800">
            <img src="/logo.png" alt="" class="w-8 h-8 rounded object-cover">
            <span class="text-lg font-bold text-white ml-3">Hospital</span>
        </a>
        <ul class="mt-4">
            <li class="mb-1 group">
                <a href="{{ route('patient_dashboard') }}" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                    <i class="ri-home-2-line mr-3 text-lg"></i>
                    <span class="text-sm">Dashboard</span>
                </a>
            </li>
            <!-- Trigger/Open The Modal -->
                <a href="javascript:void(0)" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md" onclick="openPasswordModal('{{ route('patient_detailspatient', $patient->id) }}')">
                    <i class="ri-file-line mr-3 text-lg"></i>
                    <span class="text-sm">Admission</span>
                </a>
            <li class="mb-1 group">
                <a href="{{ route('patient_treatmentplan', $patient->id) }}" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                    <i class="ri-calendar-line mr-3 text-lg"></i>
                    <span class="text-sm">Treatment Plan</span>
                </a>
            </li>
            <li class="mb-1 group">
                <a href="{{ route('patient_medicalabstract', $patient->id) }}" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                    <i class="ri-calendar-line mr-3 text-lg"></i>
                    <span class="text-sm">Medical Abstract</span>
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
                        @if(auth()->guard('patient')->check() && auth()->guard('patient')->user()->unreadNotifications->count() > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                                {{ auth()->guard('patient')->user()->unreadNotifications->count() }}
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

                <!-- Profile Dropdown -->
                <li class="dropdown ml-3">
                    <button type="button" class="dropdown-toggle flex items-center">
                        <i class="ri-user-3-line text-xl text-blue-500 mr-2"></i>
                    </button>
                    <ul class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                        <li>
                            <a href="{{ route('patient_profile', $patient->id) }}" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Profile</a>
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

        <!-- Password Modal -->
        <div id="password-modal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Enter Password</h2>
                <form id="password-form">
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password" class="mt-1 p-2 border border-gray-300 rounded-md w-full">
                    </div>
                    <div class="text-red-500" id="error-message" style="display: none;"></div>
                    <div class="flex justify-end">
                        <button type="button" class="mr-2 bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 rounded-md" onclick="closePasswordModal()">Cancel</button>
                        <button type="button" class="bg-blue-600 hover:bg-blue-800 text-white py-2 px-4 rounded-md" onclick="submitPassword()">Submit</button>
                    </div>
                </form>
            </div>
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
    <script>
        let redirectUrl = '';

function openPasswordModal(url) {
    document.getElementById('password-modal').style.display = 'flex';
    redirectUrl = url;
}

function closePasswordModal() {
    document.getElementById('password-modal').style.display = 'none';
    document.getElementById('password').value = '';
    document.getElementById('error-message').style.display = 'none';
    hideLoadingSpinner(); // Ensure spinner is hidden
}

function submitPassword() {
    const password = document.getElementById('password').value;
    showLoadingSpinner();

    fetch('{{ route("verify-password") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ password: password })
    })
    .then(response => response.json())
    .then(data => {
        hideLoadingSpinner();
        if (data.status === 'success') {
            window.location.href = redirectUrl;
        } else {
            document.getElementById('error-message').style.display = 'block';
            document.getElementById('error-message').innerText = data.message;
        }
    })
    .catch(error => {
        hideLoadingSpinner();
        console.error('Error during fetch:', error);
    });
}

function showLoadingSpinner() {
    document.getElementById('loading-spinner').classList.remove('hidden');
}

function hideLoadingSpinner() {
    document.getElementById('loading-spinner').classList.add('hidden');
}

window.addEventListener('beforeunload', function() {
    showLoadingSpinner();
});

    </script>
</body>
</html>