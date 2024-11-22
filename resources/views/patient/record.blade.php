@extends('layouts.patient')
 
@section('title', 'Dashboard')
 
@section('contents')

<!-- Back Button -->
<div class="mb-6 p-6">
    <button onclick="goBack()" class="bg-blue-500 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <i class="ri-arrow-left-line text-xl"></i> <!-- Remixicon arrow left icon -->
    </button>
</div>

<div class="p-6 space-y-6"> <!-- Added space-y-6 to create uniform spacing between sections -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Vital Signs -->
        <div class="lg:col-span-1 bg-white p-4 rounded-md shadow-md border border-gray-200">
            <div class="flex justify-between items-center bg-gray-100 rounded-t-md p-4">
                <h2 class="text-lg font-semibold text-gray-800">Vital Signs</h2>
            </div>
            <div class="p-4 space-y-6">
                <div>
                    <p class="text-sm font-medium text-gray-500">Body Temperature</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $record->vital->body_temperature ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Blood Pressure</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $record->vital->blood_pressure ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Respiratory Rate</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $record->vital->respiratory_rate ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Weight</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $record->vital->weight ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Height</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $record->vital->height ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Pulse Rate</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $record->vital->pulse_rate ?? 'N/A' }}</p>
                </div>
                <div>
                    <!-- Trigger/Open The Modal -->
                    <button id="myBtn{{ $record->id }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" data-record-id="{{ $record->id }}">Open QR</button>

                    <!-- The Modal -->
                    <div id="myModal{{ $record->id }}" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 overflow-auto">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg mx-auto mt-20 p-6 w-11/12 md:w-1/3">
                            <div class="flex items-center justify-between border-b border-gray-200 pb-2 mb-4">
                                <h2 class="text-xl font-semibold text-gray-800">QR Code</h2>
                                <button class="text-gray-600 hover:text-gray-800 close" id="closeBtn{{ $record->id }}">&times;</button>
                            </div>
                            <div class="mb-4 text-center"> <!-- Added text-center class -->
                                <p class="text-gray-600 mb-4">Scan to show details</p>
                                <!-- QR Code Image -->
                                <img id="qrCodeImg{{ $record->id }}" src="" alt="QR Code" class="mx-auto"> <!-- Added mx-auto class -->
                            </div>     
                            <!-- Print Button -->
                            <div class="text-center">
                                <button onclick="printQRCode('{{ $record->id }}')" class="py-1 px-3 border border-gray-400 text-gray-700 bg-gray-200 rounded hover:bg-gray-300 focus:outline-none focus:ring-1 focus:ring-gray-300">
                                    Print
                                </button>
                            </div>                 
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Physical Assessment -->
        <div class="lg:col-span-2 bg-white p-4 rounded-md shadow-md border border-gray-200">
            <div class="flex justify-between items-center bg-gray-100 rounded-t-md p-4">
                <h2 class="text-lg font-semibold text-gray-800">Physical Assessment</h2>                
            </div>
            <div class="p-4 space-y-6">
                <div>
                    <p class="text-sm font-medium text-gray-500">General Appearance</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $record->physical_assessment->general_appearance ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Pain Assessment</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $record->physical_assessment->pain_assessment ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Pain Description</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $record->physical_assessment->pain_description ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Changes in Description</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $record->physical_assessment->changes_in_condition ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Assessment Date</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $record->physical_assessment->assessment_date ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Assessed by</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $record->physical_assessment->assessed_by ?? 'N/A' }}</p>
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
            console.log("Patient Record ID:", patientRecordId);
            fetch(`/patient/record/qr-code/${patientRecordId}`) // Update the endpoint URL as necessary
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
        var patientRecordId = this.getAttribute('data-record-id');
        openModal(modalId, patientRecordId); // Pass the PatientRecord ID
    });
});

document.querySelectorAll('[id^="closeBtn"]').forEach(function (btn) {
    btn.addEventListener('click', function () {
        var modalId = this.id.replace('closeBtn', 'myModal');
        closeModal(modalId);
    });
});

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target.classList.contains('fixed') && event.target.classList.contains('inset-0')) {
        document.querySelectorAll('[id^="myModal"]').forEach(function (modal) {
            modal.style.display = "none";
        });
    }
};

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
