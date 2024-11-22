@extends('layouts.patient')

@section('title', 'Dashboard')

@section('contents')
<div class="p-6">
    <div class="grid grid-cols-1 lg:grid-cols-1 gap-6">
        <div class="grid grid-cols-1 gap-6">
            <!-- Latest Medical Orders Section with Progress Bar -->
            <div class="bg-white border border-gray-200 shadow-lg p-4 rounded-lg">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Admission Status: {{ $admission->reason_for_admission ?? 'N/A' }}</h2>
                <ul class="space-y-4">
                    @if($admission)
                        <li class="flex flex-col p-4 bg-gray-50 rounded-md">
                            <!-- Progress Bar -->
                            @php
                                // Define the steps for the progress bar
                                $steps = ['Triage', 'ER', 'Lab', 'Admitted'];
                                
                                // Determine the current step based on status
                                $currentStep = array_search($admission->step_status, $steps) + 1;
                                $totalSteps = count($steps);
                            @endphp

                            <div class="flex items-center justify-between">
                            @foreach($steps as $index => $step)

                                @if ($index === 3) <!-- Skip the "discharged" step -->
                                    <div class="flex items-center justify-between">
                                        <!-- Step Circle -->
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 z-10
                                            {{ $index + 1 <= $currentStep ? 'bg-green-600 border-green-600 text-white' : 'border-gray-300 bg-white' }}">
                                            @if ($index + 1 < $currentStep)
                                                <Check className="w-6 h-6 text-white" />
                                            @else
                                                <span class="text-sm font-medium">{{ $index + 1 }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @break
                                @endif

                                <div class="flex items-center justify-between flex-1">
                                    <!-- Step Circle -->
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 z-10
                                        {{ $index + 1 <= $currentStep ? 'bg-blue-600 border-blue-600 text-white' : 'border-gray-300 bg-white' }}">
                                        @if ($index + 1 < $currentStep)
                                            <span class="text-sm font-medium">{{ $index + 1 }}</span>
                                        @else
                                            <span class="text-sm font-medium">{{ $index + 1 }}</span>
                                        @endif
                                    </div>
                                    <!-- Connector Line -->
                                    @if ($index < $totalSteps - 1)
                                        <div class="flex-1 h-1 {{ $index + 1 < $currentStep ? 'bg-blue-500' : 'bg-gray-600' }} px-2" style="margin-top: 10px;">
                                            <!-- This line represents the connector between steps -->
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            </div>

                            <!-- Step Labels -->
                            <div class="flex items-center justify-between mt-2">
                                @foreach($steps as $index => $step)
                                    <span class="text-xs font-medium {{ $index + 1 <= $currentStep ? 'text-blue-600' : 'text-gray-500' }}">
                                        {{ $step }}
                                    </span>
                                @endforeach
                            </div>
                        </li>
                    @else
                        <li class="p-2 text-gray-500">No admission record found.</li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Latest Medical Orders Section -->
            <div class="bg-white border border-gray-200 shadow-lg p-4 rounded-lg">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Latest Medical Orders</h2>
                <ul class="space-y-2">
                    @forelse($medicalOrders as $order)
                            <li class="flex flex-col p-3 bg-gray-50 rounded-md">
                            <div class="flex justify-between mb-2">
                                <div>
                                    <i class="ri-capsule-fill text-xl text-blue-500 mr-2"></i>
                                    <span class="font-semibold">{{ $order->type ?? 'N/A' }}</span>
                                </div>
                                <span class="text-gray-600">
                                    {{ Str::limit($order->description ?? 'No description available', 30, '...') }}
                                </span>
                            </div>
                            <p class="text-md text-gray-700">
                                Status: {{ $order->status ?? 'N/A' }}
                            </p>
                            <p class="text-md text-gray-700">
                                Ordered by Dr. {{ $order->doctor->name ?? 'N/A' }}
                            </p>
                            <p class="text-sm text-gray-700">
                                {{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('F j, Y \a\t g:i A') : 'N/A' }}
                            </p>
                        </li>
                    @empty
                        <li class="p-2 text-gray-500">No medical orders found.</li>
                    @endforelse
                </ul>
            </div>


            <!-- Latest Rounds Section -->
            <div class="bg-white border border-gray-200 shadow-lg p-4 rounded-lg">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Latest Rounds</h2>
                <ul class="space-y-3">
                    @forelse($rounds as $round)
                        <li class="flex flex-col p-3 bg-gray-50 rounded-md">
                            <div class="flex justify-between mb-2">
                                <div>
                                    <i class="ri-time-line text-xl text-blue-500 mr-2"></i>
                                    <span class="font-semibold">{{ $round->rounds ?? 'N/A' }}</span>
                                </div>
                                <span class="text-gray-600">{{ $round->doctor->name ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">
                                    Reason for admission: {{ Str::limit($round->patientRecord->reason_for_admission ?? 'N/A', 50, '...') }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-700">
                                {{ $round->admitting_date_and_time ? \Carbon\Carbon::parse($round->admitting_date_and_time)->format('F j, Y \a\t g:i A') : 'N/A' }}
                            </p>
                        </li>
                    @empty
                        <li class="p-2 text-gray-500">No rounds found.</li>
                    @endforelse
                </ul>
            </div>


            <!-- Admission Information Section -->
            <div class="bg-white border border-gray-200 shadow-lg p-4 rounded-lg">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Admission Information</h2>
                <div class="space-y-4">
                    <div class = "bg-gray-50 rounded-md">
                        <div class = "flex">
                            <i class="ri-calendar-2-line  text-xl text-blue-500 mr-2"></i>
                            <h3 class="font-semibold text-gray-700">Admission Date</h3>
                        </div>
                        <p>{{ $admission && $admission->admitting_date_and_time ? \Carbon\Carbon::parse($admission->admitting_date_and_time)->format('F j, Y \a\t g:i A') : 'N/A' }}</p>

                    </div>
                    <div class="bg-gray-50 rounded-md">
                        <h3 class="font-semibold text-gray-700">Reason for Admission</h3>
                        <p>{{ Str::limit($admission ? $admission->reason_for_admission : 'N/A', 50, '...') }}</p>
                    </div>

                    <div class = "bg-gray-50 rounded-md">
                        <h3 class="font-semibold text-gray-700">Attending Physician</h3>
                        <p>{{ $admission ? $admission->doctor->name : 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Emergency Room Medical Order Section -->
            <div class="bg-white border border-gray-200 shadow-lg p-4 rounded-lg">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Emergency Room Medical Order</h2>
                <div class="space-y-4">
                    <div class = "bg-gray-50 rounded-md">
                        <div class = "flex">
                            <i class="ri-calendar-2-line  text-xl text-blue-500 mr-2"></i>
                            <h3 class="font-semibold text-gray-700">Order Date</h3>
                        </div>
                        <p>{{ $erorder && $erorder->order_date ? \Carbon\Carbon::parse($admission->admitting_date_and_time)->format('F j, Y \a\t g:i A') : 'N/A' }}</p>

                    </div>
                    <div class="bg-gray-50 rounded-md">
                        <h3 class="font-semibold text-gray-700">Title</h3>
                        <p>{{ Str::limit($erorder ? $erorder->title : 'N/A', 50, '...') }}</p>
                    </div>

                    <div class = "bg-gray-50 rounded-md">
                        <h3 class="font-semibold text-gray-700">Type</h3>
                        <p>{{ $erorder ? $erorder->type : 'N/A' }}</p>
                    </div>

                    <!-- Button to open the QR Code modal -->
                    <button 
                        id="myBtn{{ $erorder ? $erorder->id : '' }}" data-patient-record-id="{{ $erorder ? $erorder->id : '' }}" class="mt-2 py-1 px-3 border border-gray-400 text-gray-700 bg-gray-200 rounded hover:bg-gray-300 focus:outline-none">
                        View QR Code
                    </button>
                    
                    <!-- The Modal -->
                    @isset($erorder)
                        <div id="myModal{{ $erorder->id }}" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 overflow-auto">
                            <div class="relative bg-white rounded-lg mx-auto mt-20 p-6 w-11/12 md:w-1/3">
                                <div class="flex items-center justify-between border-b border-gray-200 pb-2 mb-4">
                                    <h2 class="text-xl font-semibold text-gray-800">QR Code</h2>
                                    <button class="text-gray-600 hover:text-gray-800 close" id="closeBtn{{ $erorder->id }}">&times;</button>
                                </div>
                                <div class="mb-4 text-center">
                                    <p class="text-gray-600 mb-4">Scan to show details</p>
                                    <img id="qrCodeImg{{ $erorder->id }}" src="" alt="QR Code" class="mx-auto">
                                </div>
                                <div class="text-center">
                                    <button onclick="printQRCode('{{ $erorder->id }}')" class="py-1 px-3 border border-gray-400 text-gray-700 bg-gray-200 rounded hover:bg-gray-300 focus:outline-none">
                                        Print
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endisset
                    <div class="bg-gray-50 rounded-md">
                        <h3 class="font-semibold text-gray-700">Status</h3>
                        <!-- Conditional Styling for Order Status -->
                        @if ($erorder)
                            @if ($erorder->order_status === 'pending')
                                <p class="text-lg font-semibold text-yellow-400">{{ $erorder->order_status }}</p>
                            @elseif ($erorder->order_status === 'completed')
                                <p class="text-lg font-semibold text-green-400">{{ $erorder->order_status }}</p>
                            @else
                                <p class="text-lg font-semibold text-gray-400">{{ $erorder->order_status }}</p>
                            @endif
                        @else
                            <p class="text-lg font-semibold text-gray-400">N/A</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <!-- Sessions Section -->
        <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-lg mt-4 overflow-x-auto">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Sessions</h2>
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
            fetch(`/patient/erorder/qr-code/${patientRecordId}`)
                .then(response => response.json())
                .then(data => {
                    qrCodeImg.src = data.path || ''; // Replace with actual QR code path
                })
                .catch(error => {
                    console.error('Error fetching QR code:', error);
                    qrCodeImg.src = ''; // Handle error appropriately
                });
        }
        modal.style.display = "block"; // Show modal
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = "none"; // Hide modal
    }
}

// Event listeners for opening and closing modals
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

// Hide modal when clicking outside
window.onclick = function(event) {
    if (event.target.classList.contains('fixed') && event.target.classList.contains('inset-0')) {
        document.querySelectorAll('[id^="myModal"]').forEach(modal => {
            modal.style.display = "none"; // Hide all modals
        });
    }
};
</script>
@endsection
