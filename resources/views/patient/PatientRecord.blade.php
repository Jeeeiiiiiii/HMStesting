@extends('layouts.patient')
 
@section('title', 'Dashboard')
 
@section('contents')

<div class="p-6 space-y-6"> <!-- Added space-y-6 to create uniform spacing between sections -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Admission Details -->       
        <div class="lg:col-span-1 bg-white p-4 rounded-md shadow-md border border-gray-200">
            <div class="flex justify-between items-center bg-gray-100 rounded-t-md p-4">
                <h2 class="text-lg font-semibold text-gray-800">Admission Details</h2>
            </div>
            <div class="p-4 space-y-6"> <!-- Added space-y-6 for consistent spacing -->
                <div>
                    <p class="text-sm font-medium text-gray-500">Reason for Admission</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->reason_for_admission ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Room</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->admission->room ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Attending Physician</p>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ $patientRecord->admission->doctor->name ?? 'N/A' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Attending Nurse</p>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ $patientRecord->admission->nurse->name ?? 'N/A' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Admitting Date and Time</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->admitting_date_and_time ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Admitting Department</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->admission->department->department_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <!-- Trigger/Open The Modal -->
                    <button id="myBtn{{ $patientRecord->id }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" data-patient-record-id="{{ $patientRecord->id }}">Open QR</button>

                    <!-- The Modal -->
                    <div id="myModal{{ $patientRecord->id }}" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 overflow-auto">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg mx-auto mt-20 p-6 w-11/12 md:w-1/3">
                            <div class="flex items-center justify-between border-b border-gray-200 pb-2 mb-4">
                                <h2 class="text-xl font-semibold text-gray-800">QR Code</h2>
                                <button class="text-gray-600 hover:text-gray-800 close" id="closeBtn{{ $patientRecord->id }}">&times;</button>
                            </div>
                            <div class="mb-4 text-center"> <!-- Added text-center class -->
                                <p class="text-gray-600 mb-4">Scan to show details</p>
                                <!-- QR Code Image -->
                                <img id="qrCodeImg{{ $patientRecord->id }}" src="" alt="QR Code" class="mx-auto"> <!-- Added mx-auto class -->
                            </div>     
                            <!-- Print Button -->
                            <div class="text-center">
                                <button onclick="printQRCode('{{ $patientRecord->id }}')" class="py-1 px-3 border border-gray-400 text-gray-700 bg-gray-200 rounded hover:bg-gray-300 focus:outline-none focus:ring-1 focus:ring-gray-300">
                                    Print
                                </button>
                            </div>                 
                        </div>
                    </div>
                </div>

                <!-- Add Buttons to Open the Modal -->
                <div class="flex space-x-4">
                    <button id="openVitalSignsModal{{ $patientRecord->id }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">View Vital Signs</button>
                </div>

                <!-- Add Buttons to Open the Modal -->
                <div class="flex space-x-4">
                    <button id="openTestsModal{{ $patientRecord->id }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">View Tests/Medications</button>
                </div>

                <!-- Modal Structure -->
                <div id="vitalSignsModal{{ $patientRecord->id }}" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 overflow-auto">
                    <div class="relative bg-white rounded-lg mx-auto mt-20 p-6 w-11/12 md:w-1/3">
                        <!-- Vital Signs Content -->
                        <div class="flex justify-between items-center bg-gray-100 rounded-t-md p-4">
                            <h2 class="text-lg font-semibold text-gray-800">Vital Signs</h2>
                            <button class="text-gray-600 hover:text-gray-800 close" id="closeVitalSignsModal{{ $patientRecord->id }}">&times;</button>
                        </div>
                        <div class="p-4 space-y-6">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Body Temperature</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->vital->body_temperature ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Blood Pressure</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->vital->blood_pressure ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Respiratory Rate</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->vital->respiratory_rate ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Weight</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->vital->weight ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Height</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->vital->height ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Pulse Rate</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->vital->pulse_rate ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="testsModal{{ $patientRecord->id }}" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 overflow-auto">
                    <div class="relative bg-white rounded-lg mx-auto mt-20 p-6 w-11/12 md:w-1/3">
                        <!-- Tests/Medications Content -->
                        <div class="flex justify-between items-center bg-gray-100 rounded-t-md p-4">
                            <h2 class="text-lg font-semibold text-gray-800">Tests/Medications</h2>
                            <button class="text-gray-600 hover:text-gray-800 close" id="closeTestsModal{{ $patientRecord->id }}">&times;</button>
                        </div>
                        <div class="p-4 space-y-6">
                            <div>
                                <p class="text-sm font-medium text-gray-500">History of Present Illness</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->test->hpi ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Note</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->test->note ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Medication</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->test->medication ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Lab Test</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->test->chief_complaint ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Diagnosis</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $patientRecord->test->diagnose ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Admission Details -->
        <div class="lg:col-span-2 bg-white rounded-md border border-gray-100 shadow-lg p-4">
            <div class="flex justify-between items-center bg-gray-100 rounded-t-md p-4 mb-6">
                <h2 class="text-lg font-semibold text-gray-800">Status Details</h2>
            </div>

            <!-- Rounds Section -->
            <div class="p-6 mb-8">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-center text-gray-600 border-collapse border border-gray-200 mb-4">
                        <thead>
                            <tr>
                                <th class="px-9 py-2 font-semibold border-b border-r border-gray-300">Rounds</th>
                                <th class="px-4 py-2 font-semibold border-b border-gray-300">Date of Rounds</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patientRecord->record as $record)
                            <tr>
                                <td class="px-4 py-2 border-b border-r border-gray-200">
                                    <a href="{{ route('patient_record', $record->id) }}" class="text-blue-700 hover:text-blue-500 font-semibold transition-colors duration-100 ease-in-out">
                                        {{ $record->rounds }}
                                    </a>
                                </td>
                                <td class="px-4 py-2 border-b border-gray-200">
                                    {{ $record->admitting_date_and_time }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination for Rounds -->
                <div class="mt-4">
                    <!-- Assuming you're using Laravel pagination -->
                </div>
            </div>

            <!-- Treatment Plan Section -->
            <div class="p-6 mb-8">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-center text-gray-600 border-collapse border border-gray-200 mb-4">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 font-semibold border-b border-r border-gray-300">Treatment Plan</th>
                                <th class="px-4 py-2 font-semibold border-b border-gray-300">Date of Treatment Plan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patientRecord->treatment_plan as $plan)
                            <tr>
                                <td class="px-4 py-2 border-b border-r border-gray-200">
                                    <a href="{{ route('patient_treatmentplanpage', $plan->id) }}" class="text-blue-700 hover:text-blue-500 font-semibold transition-colors duration-100 ease-in-out">
                                        {{ $plan->title }}
                                    </a>
                                </td>
                                <td class="px-4 py-2 border-b border-gray-200">
                                    {{ $plan->created_at }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination for Treatment Plan -->
                <div class="mt-4">
                    <!-- Assuming you're using Laravel pagination -->
                </div>
            </div>

            <!-- Medical Orders Section -->
            <div class="p-6 mb-8">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-center text-gray-600 border-collapse border border-gray-200 mb-4">
                        <thead>
                            <tr>
                                <th class="px-6 py-4 font-semibold border-b border-r border-gray-300">Medical Orders</th>
                                <th class="px-6 py-4 font-semibold border-b border-r border-gray-300">Date of Medical Orders</th>
                                <th class="px-6 py-4 font-semibold border-b border-r border-gray-300">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patientRecord->order as $order)
                            <tr class="hover:bg-gray-100">
                                <!-- Order Title -->
                                <td class="px-6 py-4 border-b border-r border-gray-200">
                                    <a href="{{ route('patient_orderpage', $order->id) }}" class="text-blue-600 hover:text-blue-400 font-semibold transition-colors duration-150">
                                        {{ $order->title }}
                                    </a>
                                </td>

                                <!-- Order Date -->
                                <td class="px-6 py-4 border-b border-r border-gray-200">
                                    {{ $order->order_date }}
                                </td>

                                <!-- Order Status Display -->
                                <td class="px-6 py-4 border-b border-r border-gray-200 text-center">
                                    @if ($order->status === 'pending')
                                        <span class="inline-block text-yellow-500 font-semibold bg-yellow-100 py-2 px-4 rounded-md">Pending</span>
                                    @elseif ($order->status === 'completed')
                                        <span class="inline-block text-green-500 font-semibold bg-green-100 py-2 px-4 rounded-md">Completed</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination for Medical Orders -->
                <div class="mt-4">
                    <!-- Assuming you're using Laravel pagination -->
                </div>
            </div>

        </div>
    </div>
</div>


<script>
// Attach to global scope
window.printQRCode = printQRCode;

function printQRCode(patientId) {
    // Get the QR code image element
    const qrCodeImg = document.querySelector('#myModal' + patientId + ' img').outerHTML;
    
    // Create a new window for printing
    const printWindow = window.open('', '', 'height=600,width=800');
    
    // Write the HTML content to the new window
    printWindow.document.write('<html><head><title>Print QR Code</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body {');
    printWindow.document.write('  display: flex;');
    printWindow.document.write('  justify-content: center;');
    printWindow.document.write('  align-items: center;');
    printWindow.document.write('  height: 100vh;'); // Full viewport height
    printWindow.document.write('  margin: 0;'); // Remove default margin
    printWindow.document.write('  font-family: Arial, sans-serif;');
    printWindow.document.write('}');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write(qrCodeImg); // Only include the QR code in the print content
    printWindow.document.write('</body></html>');
    
    // Close the document to finish writing and open the print dialog
    printWindow.document.close();
    printWindow.print();
}




function openModal(modalId, patientRecordId) {
    var modal = document.getElementById(modalId);
    if (modal) {
        var qrCodeImg = modal.querySelector('img'); // Get the QR code image element

        if (qrCodeImg) {
            // Fetch the QR code path for the patient record
            fetch(`/patient/qr-code/${patientRecordId}`) // Update the endpoint URL as necessary
                .then(response => response.json())
                .then(data => {
                    if (data.path) {
                        qrCodeImg.src = data.path; // Set the image source
                    } else {
                        qrCodeImg.src = ''; // Handle case where QR code path is not found
                    }
                })
                .catch(error => {
                    console.error('Error fetching QR code path:', error);
                    qrCodeImg.src = ''; // Handle error
                });
        }

        modal.style.display = "block";
    }
}

function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = "none";
    }
}

document.querySelectorAll('[id^="myBtn"]').forEach(function (btn) {
    btn.addEventListener('click', function () {
        var modalId = this.id.replace('myBtn', 'myModal');
        var patientRecordId = this.getAttribute('data-patient-record-id');
        openModal(modalId, patientRecordId); // Pass the PatientRecord ID
    });
});

document.querySelectorAll('[id^="closeBtn"]').forEach(function (btn) {
    btn.addEventListener('click', function () {
        var modalId = this.id.replace('closeBtn', 'myModal');
        closeModal(modalId);
    });
});

// Consolidated window.onclick logic for all modals
window.onclick = function(event) {
    // Handle QR code modals
    if (event.target.classList.contains('fixed') && event.target.classList.contains('inset-0')) {
        document.querySelectorAll('[id^="myModal"]').forEach(function (modal) {
            modal.style.display = "none";
        });
    }

    // Handle Vital Signs and Tests modals
    var vitalSignsModal = document.getElementById('vitalSignsModal{{ $patientRecord->id }}');
    var testsModal = document.getElementById('testsModal{{ $patientRecord->id }}');

    if (event.target === vitalSignsModal) {
        vitalSignsModal.classList.add('hidden');
    }
    if (event.target === testsModal) {
        testsModal.classList.add('hidden');
    }
};

document.addEventListener('DOMContentLoaded', function() {
    // Get the modal elements
    var vitalSignsModal = document.getElementById('vitalSignsModal{{ $patientRecord->id }}');
    var testsModal = document.getElementById('testsModal{{ $patientRecord->id }}');

    // Get the buttons that open the modals
    var openVitalSignsBtn = document.getElementById('openVitalSignsModal{{ $patientRecord->id }}');
    var openTestsBtn = document.getElementById('openTestsModal{{ $patientRecord->id }}');

    // Get the elements that close the modals
    var closeVitalSignsBtn = document.getElementById('closeVitalSignsModal{{ $patientRecord->id }}');
    var closeTestsBtn = document.getElementById('closeTestsModal{{ $patientRecord->id }}');

    // When the user clicks the button, open the modal 
    openVitalSignsBtn.onclick = function() {
        vitalSignsModal.classList.remove('hidden');
    }
    openTestsBtn.onclick = function() {
        testsModal.classList.remove('hidden');
    }

    // When the user clicks on close button, close the modal
    closeVitalSignsBtn.onclick = function() {
        vitalSignsModal.classList.add('hidden');
    }
    closeTestsBtn.onclick = function() {
        testsModal.classList.add('hidden');
    }

});

</script>
@endsection
