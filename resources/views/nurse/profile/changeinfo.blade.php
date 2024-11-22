@extends('layouts.Nurseprofile')

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
                <div class="text-gray-800 font-bold text-3xl">{{ $nurse->name }}</div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 shadow-md p-6 rounded-lg mt-4">
            <!-- Contact Information Section -->
            <div class="flex items-center mb-6">
                <div class="font-medium text-xl text-gray-700">Contact Information</div>
                <div class="ml-auto">
                    <button type="button" class="edit-button text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md flex items-center transition">
                        <i class="ri-edit-box-line mr-2"></i> 
                        Edit
                    </button>
                </div>
            </div>
            <hr class="my-4 border-gray-300">
            <div class="flex flex-col md:flex-row mb-4">
                <div class="w-full md:w-52 mb-2 md:mb-0">
                    <div class="font-medium text-gray-600">Email Address</div>
                </div>
                <div class="font-bold text-2xl text-gray-800">{{ $nurse->email }}</div>
            </div>
            <hr class="my-4 border-gray-300">
            <div class="flex flex-col md:flex-row mb-4">
                <div class="w-full md:w-52 mb-2 md:mb-0">
                    <div class="font-medium text-gray-600">Contact Number</div>
                </div>
                <div class="font-bold text-2xl text-gray-800">{{ $nurse->profile->telephone_no ?? 'N/A' }}</div>
            </div>
            <hr class="my-4 border-gray-300">

            <!-- Emergency Contact Information Section -->
            <div class="flex items-center mb-6">
                <div class="font-medium text-xl text-gray-700">Emergency Contact Information</div>
                <div class="ml-auto">
                    <button type="button" class="edit-button2 text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md flex items-center transition">
                        <i class="ri-edit-box-line mr-2"></i> 
                        Edit
                    </button>
                </div>
            </div>
            <hr class="my-4 border-gray-300">
            <div class="flex flex-col md:flex-row mb-4">
                <div class="w-full md:w-52 mb-2 md:mb-0">
                    <div class="font-medium text-gray-600">Emergency Contact Name</div>
                </div>
                <div class="font-bold text-2xl text-gray-800">{{ $nurse->profile->emergency_email ?? 'N/A' }}</div>
            </div>
            <hr class="my-4 border-gray-300">
            <div class="flex flex-col md:flex-row mb-4">
                <div class="w-full md:w-52 mb-2 md:mb-0">
                    <div class="font-medium text-gray-600">Emergency Contact No.</div>
                </div>
                <div class="font-bold text-2xl text-gray-800">{{ $nurse->profile->emergency_telephone_no ?? 'N/A' }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Include the modal -->
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative mx-auto p-6 border w-96 shadow-xl rounded-md bg-white mt-20 top-1/3 transform -translate-y-1/2">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Contact Information</h3>
            <div class="mt-4">
                <form action="{{ route('nurse_submitinfo') }}" method="POST">
                    @csrf

                    <!-- Form fields -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ $nurse->email }}" class="mt-1 block w-full p-2 border rounded-md shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label for="telephone_no" class="block text-sm font-medium text-gray-700">Contact Number</label>
                        <input type="text" name="telephone_no" id="telephone_no" value="{{ $nurse->profile->telephone_no }}" class="mt-1 block w-full p-2 border rounded-md shadow-sm">
                    </div>

                    <div class="mt-4">
                        <button type="button" class="text-gray-500 mr-4 px-4 py-2 rounded" onclick="toggleModal()">Cancel</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include the second modal -->
<div id="editModal2" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative mx-auto p-6 border w-96 shadow-xl rounded-md bg-white mt-20 top-1/3 transform -translate-y-1/2">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Emergency Contact Information</h3>
            <div class="mt-4">
                <form action="{{ route('nurse_submitemergencyinfo') }}" method="POST">
                    @csrf

                    <!-- Form fields -->
                    <div class="mb-4">
                        <label for="emergency_email" class="block text-sm font-medium text-gray-700">Emergency Contact Email</label>
                        <input type="email" name="emergency_email" id="emergency_email" value="{{ $nurse->profile->emergency_email ?? 'N/A' }}" class="mt-1 block w-full p-2 border rounded-md shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label for="emergency_telephone_no" class="block text-sm font-medium text-gray-700">Emergency Contact Number</label>
                        <input type="text" name="emergency_telephone_no" id="emergency_telephone_no" value="{{ $nurse->profile->emergency_telephone_no ?? 'N/A' }}" class="mt-1 block w-full p-2 border rounded-md shadow-sm">
                    </div>

                    <div class="mt-4">
                        <button type="button" class="text-gray-500 mr-4 px-4 py-2 rounded" onclick="toggleModal2()">Cancel</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to toggle visibility of the first modal
    function toggleModal() {
        const modal = document.getElementById('editModal');
        modal.classList.toggle('hidden');
    }

    // Function to toggle visibility of the second modal
    function toggleModal2() {
        const modal = document.getElementById('editModal2');
        modal.classList.toggle('hidden');
    }

    // Add event listeners to buttons to open modals
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', toggleModal);
    });

    document.querySelectorAll('.edit-button2').forEach(button => {
        button.addEventListener('click', toggleModal2);
    });

    // Function to close modals when clicking outside
    function closeModals(event) {
        if (event.target.classList.contains('fixed') && event.target.classList.contains('inset-0')) {
            document.querySelectorAll('[id^="editModal"]').forEach(function (modal) {
                modal.classList.add('hidden');
            });
        }
    }

    // Add event listener to the window to detect clicks outside modals
    window.addEventListener('click', closeModals);
</script>

@endsection
