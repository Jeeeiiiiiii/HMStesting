@extends('layouts.emergencyroom')

@section('title', 'QR Code Scanner')

@section('contents')
<div class="max-w-md mx-auto mt-10">
    <div class="bg-white shadow rounded-lg">
        <!-- Card Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold">QR Code Scanner</h2>
        </div>
        
        <!-- Card Content -->
        <div class="px-6 py-4 space-y-4">
            <div class="space-y-2">
                <!-- Input Label -->
                <label for="code" class="block text-sm font-medium text-gray-700">Enter or Scan Code</label>

                <!-- QR Code Input Section -->
                <div class="flex justify-center">
                    <input type="text" id="qr-input" placeholder="Scan QR Code Here"
                        class="appearance-none bg-gray-100 rounded-full px-4 py-2 w-full sm:w-[250px] focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent shadow-md text-gray-700 placeholder-gray-500 transition ease-in-out duration-300 transform hover:scale-105" />
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const qrInput = document.getElementById('qr-input');

        // Check if the qrInput field is found
        if (!qrInput) {
            console.error('QR input field not found.');
            return;
        }

        console.log('QR input field found. Listening for change events...');

        qrInput.addEventListener('change', (event) => {
            const scannedValue = qrInput.value;
            console.log('Full scanned value:', scannedValue); // Log the full scanned value

            // Try to open a new tab with the full scanned value
            try {
                const newTab = window.open(scannedValue, '_blank');
                if (newTab) {
                    newTab.focus(); // Bring the new tab into focus
                    console.log('New tab opened successfully.');
                } else {
                    console.error('Failed to open new tab. It might be blocked by a pop-up blocker.');
                }
            } catch (error) {
                console.error('Error opening new tab:', error);
            }

            qrInput.value = ''; // Clear the input field for the next scan
        });
    });
</script>
@endsection
