@extends('layouts.triagenurse')

@section('title', 'Admission Registration')

@section('contents')
<div class="p-6 bg-gray-100 min-h-screen">
    <div class="bg-white border border-gray-100 shadow-md p-6 rounded-md relative overflow-hidden max-w-3xl mx-auto">
        <!-- Progress Bar -->
        <div class="absolute top-0 left-0 h-2 bg-gray-200 w-full rounded-full">
            <div id="progress-bar" class="h-2 bg-blue-600 rounded-full transition-all duration-300" style="width: 33%;"></div>
        </div>

        <!-- Start of Form -->
        <form action="{{ route('storeData', $patient->id) }}" method="POST">
            @csrf

            <!-- Step 1: Test/Medication -->
            <div id="step1" class="step">
                <div class="font-semibold text-lg mb-4 text-gray-800 text-center">Step 1: Test/Medication</div>

                <div class="space-y-4">
                    <div>
                        <label for="hpi" class="block text-sm font-medium text-gray-700">History of Present Illness</label>
                        <input type="text" id="hpi" name="hpi" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @error('hpi')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="note" class="block text-sm font-medium text-gray-700">Note</label>
                        <input type="text" id="note" name="note" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @error('note')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="medication" class="block text-sm font-medium text-gray-700">Medication</label>
                        <input type="text" id="medication" name="medication" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @error('medication')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="chief_complaint" class="block text-sm font-medium text-gray-700">Chief Complaint</label>
                        <input type="text" id="chief_complaint" name="chief_complaint" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @error('chief_complaint')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="diagnose" class="block text-sm font-medium text-gray-700">Diagnose</label>
                        <input type="text" id="diagnose" name="diagnose" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @error('diagnose')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button id="next1" type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg shadow transition duration-200">Next</button>
                </div>
            </div>

            <!-- Step 2: Patient Vital Signs -->
            <div id="step2" class="hidden step">
                <div class="font-semibold text-lg mb-4 text-gray-800 text-center">Step 2: Patient Vital Signs</div>

                <div class="space-y-4">
                    <div>
                        <label for="body_temperature" class="block text-sm font-medium text-gray-700">Body Temperature</label>
                        <input type="text" id="body_temperature" name="body_temperature" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @error('body_temperature')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="blood_pressure" class="block text-sm font-medium text-gray-700">Blood Pressure</label>
                        <input type="text" id="blood_pressure" name="blood_pressure" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @error('blood_pressure')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="respiratory_rate" class="block text-sm font-medium text-gray-700">Respiratory Rate</label>
                        <input type="text" id="respiratory_rate" name="respiratory_rate" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @error('respiratory_rate')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700">Weight</label>
                        <input type="text" id="weight" name="weight" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @error('weight')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="height" class="block text-sm font-medium text-gray-700">Height</label>
                        <input type="text" id="height" name="height" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @error('height')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="pulse_rate" class="block text-sm font-medium text-gray-700">Pulse Rate</label>
                        <input type="text" id="pulse_rate" name="pulse_rate" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @error('pulse_rate')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-between mt-6">
                    <button id="back1" type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-3 rounded-lg shadow transition duration-200">Back</button>
                    <button id="next2" type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg shadow transition duration-200">Next</button>
                </div>
            </div>

            <!-- Step 3: Admission Details -->
            <div id="step3" class="hidden step">
                <div class="font-semibold text-lg mb-4 text-gray-800 text-center">Step 3: Admission Details</div>

                <div class="space-y-4">
                    <div>
                        <label for="reason_for_admission" class="block text-sm font-medium text-gray-700">Reason for Admission</label>
                        <input type="text" id="reason_for_admission" name="reason_for_admission" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @error('reason_for_admission')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="room" class="block text-sm font-medium text-gray-700">Room</label>
                        <input type="text" id="room" name="room" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @error('room')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="attending_physician" class="block text-sm font-medium text-gray-700">Attending Physician</label>
                        <select id="attending_physician" name="attending_physician" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                            <option value="" disabled selected>Select a physician</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                        @error('attending_physician')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="attending_nurse" class="block text-sm font-medium text-gray-700">Attending Nurse</label>
                        <select id="attending_nurse" name="attending_nurse" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                            <option value="" disabled selected>Select a nurse</option>
                            @foreach ($nurses as $nurse)
                                <option value="{{ $nurse->id }}">{{ $nurse->name }}</option>
                            @endforeach
                        </select>
                        @error('attending_nurse')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="admitting_date_and_time" class="block text-sm font-medium text-gray-700">Admission Date</label>
                        <input type="datetime-local" id="admitting_date_and_time" name="admitting_date_and_time" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @error('admitting_date_and_time')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="admitting_department" class="block text-sm font-medium text-gray-700">Admitting Department</label>
                        <select id="admitting_department" name="admitting_department" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                            <option value="">Select a department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="flex justify-between mt-6">
                    <button id="back2" type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-3 rounded-lg shadow transition duration-200">Back</button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg shadow transition duration-200">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('next1').addEventListener('click', function() {
        document.getElementById('step1').classList.add('hidden');
        document.getElementById('step2').classList.remove('hidden');
        document.getElementById('progress-bar').style.width = '66%';
    });

    document.getElementById('next2').addEventListener('click', function() {
        document.getElementById('step2').classList.add('hidden');
        document.getElementById('step3').classList.remove('hidden');
        document.getElementById('progress-bar').style.width = '100%';
    });

    document.getElementById('back1').addEventListener('click', function() {
        document.getElementById('step2').classList.add('hidden');
        document.getElementById('step1').classList.remove('hidden');
        document.getElementById('progress-bar').style.width = '33%';
    });

    document.getElementById('back2').addEventListener('click', function() {
        document.getElementById('step3').classList.add('hidden');
        document.getElementById('step2').classList.remove('hidden');
        document.getElementById('progress-bar').style.width = '66%';
    });
</script>
@endsection
