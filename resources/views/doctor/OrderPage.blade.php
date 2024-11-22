@extends('layouts.doctor')
 
@section('title', 'Dashboard')
 
@section('contents')
<!-- Back Button -->
<div class="p-6">
    <button onclick="window.history.back()" class="bg-blue-500 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <i class="ri-arrow-left-line text-xl"></i> <!-- Remixicon arrow left icon -->
    </button>
</div>

<div class="p-6 rounded-lg bg-gray-100 flex justify-center items-center">
    <div class="bg-white rounded-lg shadow-md w-full max-w-4xl">
        <div class="bg-gray-600 text-white text-lg font-semibold rounded-t-lg p-4">
            Order Details
        </div>
        <div class="p-6">
            <!-- Title -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Title</label>
                <p class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full">{{ $patient->title }}</p>
            </div>

            <!-- Order Type -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Order Type</label>
                <p class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full">{{ $patient->type }}</p>
            </div>

            <!-- Order Description -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <p class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full">{{ $patient->description }}</p>
            </div>

            <!-- Order Status -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <p class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full">{{ $patient->status }}</p>
            </div>

             <!-- Order Date -->
             <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Order Date</label>
                @php
                    $orderDate = new DateTime($patient->order_date); // Convert string to DateTime object
                @endphp
                <p class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full">{{ $orderDate->format('F j, Y') }}</p>
            </div>

            <div>
                <!-- Trigger/Open The Modal -->
                <button id="myBtn{{ $patient->id }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" data-order-id="{{ $patient->id }}">Open QR</button>

                <!-- The Modal -->
                <div id="myModal{{ $patient->id }}" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 overflow-auto">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg mx-auto mt-20 p-6 w-11/12 md:w-1/3">
                        <div class="flex items-center justify-between border-b border-gray-200 pb-2 mb-4">
                            <h2 class="text-xl font-semibold text-gray-800">QR Code</h2>
                            <button class="text-gray-600 hover:text-gray-800 close" id="closeBtn{{ $patient->id }}">&times;</button>
                        </div>
                        <div class="mb-4 text-center"> <!-- Added text-center class -->
                            <p class="text-gray-600 mb-4">Scan to show details</p>
                            <!-- QR Code Image -->
                            <img id="qrCodeImg{{ $patient->id }}" src="" alt="QR Code" class="mx-auto"> <!-- Added mx-auto class -->
                        </div>     
                        <!-- Print Button -->
                        <div class="text-center">
                            <button onclick="printQRCode('{{ $patient->id }}')" class="py-1 px-3 border border-gray-400 text-gray-700 bg-gray-200 rounded hover:bg-gray-300 focus:outline-none focus:ring-1 focus:ring-gray-300">
                                Print
                            </button>
                        </div>                 
                    </div>
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
            fetch(`/doctor/order/qr-code/${patientRecordId}`) // Update the endpoint URL as necessary
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
        var patientRecordId = this.getAttribute('data-order-id');
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

</script>

@endsection
