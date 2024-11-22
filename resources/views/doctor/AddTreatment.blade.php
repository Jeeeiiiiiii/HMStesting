@extends('layouts.doctor')

@section('title', 'Add Treatment Plan')

@section('contents')

<!-- Back Button -->
<div class="mb-6 p-6">
    <button onclick="goBack()" class="bg-blue-500 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <i class="ri-arrow-left-line text-xl"></i> <!-- Remixicon arrow left icon -->
    </button>
</div>

<div class="p-6 rounded-lg bg-gray-100 flex justify-center items-center">
    <div class="bg-white rounded-lg shadow-md w-full max-w-4xl">
        <div class="bg-gray-600 text-white text-lg font-semibold rounded-t-lg p-4">
            Test/Medication
        </div>
        <div class="p-6">
            <form action="{{ route('storeTreatment', $patientRecord->id) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" id="title" name="title" class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                    @error('title')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="hpi" class="block text-sm font-medium text-gray-700">History of Present Illness</label>
                    <input type="text" id="hpi" name="hpi" class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                    @error('hpi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="note" class="block text-sm font-medium text-gray-700">Note</label>
                    <input type="text" id="note" name="note" class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                    @error('note')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="medication" class="block text-sm font-medium text-gray-700">Medication</label>
                    <input type="text" id="medication" name="medication" class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                    @error('medication')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="chief_complaint" class="block text-sm font-medium text-gray-700">Chief Complaint</label>
                    <input type="text" id="chief_complaint" name="chief_complaint" class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                    @error('chief_complaint')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="diagnose" class="block text-sm font-medium text-gray-700">Diagnose</label>
                    <input type="text" id="diagnose" name="diagnose" class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                    @error('diagnose')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center mt-4">
                    <button type="submit" class="bg-blue-500 text-white font-semibold py-3 px-8 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

function goBack() {
    if (document.referrer) {
        // If there is a referrer, go back to the referring page
        window.location.href = document.referrer;
    } else {
        // Fallback URL if there is no referrer (e.g., when opened in a new tab)
        window.location.href = '/your-fallback-url'; // Replace with the URL you want to redirect to
    }
}

</script>

@endsection
