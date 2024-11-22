@extends('layouts.patient')

@section('title', 'Medical Abstract')

@section('contents')
<div class="p-6 space-y-6">

    <!-- Patient Case and Name Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-md border border-gray-100 p-6 shadow-lg">
            <div class="flex justify-between items-center">
                <div class="text-lg font-semibold text-gray-600">PATIENT CASE:</div>
                <div class="text-lg font-semibold text-gray-600">#</div>
            </div>
        </div>

        <div class="bg-white rounded-md border border-gray-100 p-6 shadow-lg">
            <div class="flex justify-between items-center">
                <div class="text-lg font-semibold text-gray-600">PATIENT NAME:</div>
                <div class="text-lg font-semibold text-gray-800">{{ $patient->profile->name ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    <!-- Details and Doctors Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Admission Details -->
        <div class="lg:col-span-3 bg-white rounded-md border border-gray-100 shadow-lg">
            <div class="bg-gray-200 rounded-t-md p-4 flex justify-between items-center">
                <div class="font-semibold text-gray-700">Medical Abstract</div>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-center text-gray-600 border-collapse border border-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 font-semibold border-b border-r border-gray-300">Admission</th>
                                <th class="px-4 py-2 font-semibold border-b border-r border-gray-300">Date of Admission</th>
                                <th class="px-4 py-2 font-semibold border-b border-gray-300">QR Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patient->patientrecord->filter(fn($record) => $record->status === 'discharged') as $record)
                            <tr>
                                <td class="px-4 py-2 border-b border-r border-gray-200">
                                    <a href="{{ route('patient_medicalabstractpage', $record->id) }}" class="text-blue-700 hover:text-blue-500 font-semibold transition-colors duration-100 ease-in-out">
                                        {{ $record->reason_for_admission }}
                                    </a>
                                </td>
                                <td class="px-4 py-2 border-b border-r border-gray-200">
                                    {{ $record->admitting_date_and_time }}
                                </td>
                                <td class="px-4 py-2 border-b border-gray-200">
                                    <button id="myBtn{{ $record->id }}" class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-700 focus:outline-none" data-patient-record-id="{{ $record->id }}">Open QR</button>
                                </td>
                            </tr>

                            <!-- The Modal -->
                            <div id="myModal{{ $record->id }}" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 overflow-auto">
                                <div class="relative bg-white rounded-lg mx-auto mt-20 p-6 w-11/12 md:w-1/3">
                                    <div class="flex items-center justify-between border-b border-gray-200 pb-2 mb-4">
                                        <h2 class="text-xl font-semibold text-gray-800">QR Code</h2>
                                        <button class="text-gray-600 hover:text-gray-800 close" id="closeBtn{{ $record->id }}">&times;</button>
                                    </div>
                                    <div class="mb-4 text-center">
                                        <p class="text-gray-600 mb-4">Scan to show details</p>
                                        <img id="qrCodeImg{{ $record->id }}" src="" alt="QR Code" class="mx-auto">
                                    </div>
                                    <div class="text-center">
                                        <button onclick="printQRCode('{{ $record->id }}')" class="py-1 px-3 border border-gray-400 text-gray-700 bg-gray-200 rounded hover:bg-gray-300 focus:outline-none">
                                            Print
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
// Attach print function to the global scope
window.printQRCode = printQRCode;

function printQRCode(recordId) {
    const qrCodeImg = document.querySelector('#myModal' + recordId + ' img').outerHTML;
    const printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write('<html><head><title>Print QR Code</title><style>body{display:flex;justify-content:center;align-items:center;height:100vh;margin:0;font-family:Arial,sans-serif;}</style></head><body>');
    printWindow.document.write(qrCodeImg);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

function openModal(modalId, patientRecordId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        const qrCodeImg = modal.querySelector('img');
        if (qrCodeImg) {
            fetch(`/patient/abstract/qr-code/${patientRecordId}`)
                .then(response => response.json())
                .then(data => {
                    qrCodeImg.src = data.path || '';
                })
                .catch(error => {
                    console.error('Error fetching QR code:', error);
                    qrCodeImg.src = '';
                });
        }
        modal.style.display = "block";
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = "none";
    }
}

document.querySelectorAll('[id^="myBtn"]').forEach(function (btn) {
    btn.addEventListener('click', function () {
        const modalId = this.id.replace('myBtn', 'myModal');
        const patientRecordId = this.getAttribute('data-patient-record-id');
        openModal(modalId, patientRecordId);
    });
});

document.querySelectorAll('[id^="closeBtn"]').forEach(function (btn) {
    btn.addEventListener('click', function () {
        const modalId = this.id.replace('closeBtn', 'myModal');
        closeModal(modalId);
    });
});

window.onclick = function(event) {
    if (event.target.classList.contains('fixed') && event.target.classList.contains('inset-0')) {
        document.querySelectorAll('[id^="myModal"]').forEach(modal => {
            modal.style.display = "none";
        });
    }
};
</script>
@endsection
