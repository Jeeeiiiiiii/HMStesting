@extends('layouts.nurse')

@section('title', 'Registration')

@section('contents')
<div class="p-6 bg-gray-100 min-h-screen">
    <div class="bg-white border border-gray-100 shadow-md p-6 rounded-md relative overflow-hidden max-w-3xl mx-auto">
        <!-- Progress Bar -->
        <div class="absolute top-0 left-0 h-2 bg-gray-200 w-full rounded-full">
            <div id="progress-bar" class="h-2 bg-blue-600 rounded-full transition-all duration-300" style="width: 50%;"></div>
        </div>

        <form action="{{ route('nurse_storeData', $patientRecord->id) }}" method="POST">
            @csrf

            <!-- Physical Assessment Section -->
            <div id="step1">
                <div class="bg-gray-600 text-white text-lg font-semibold rounded-t-lg p-4">
                    Physical Assessment
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <label for="general_appearance" class="block text-sm font-medium text-gray-700">General Appearance</label>
                        <input type="text" id="general_appearance" name="general_appearance" class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                        @error('general_appearance')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="pain_assessment" class="block text-sm font-medium text-gray-700">Pain Assessment</label>
                        <input type="text" id="pain_assessment" name="pain_assessment" class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                        @error('pain_assessment')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="pain_description" class="block text-sm font-medium text-gray-700">Pain Description</label>
                        <input type="text" id="pain_description" name="pain_description" class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                        @error('pain_description')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="changes_in_condition" class="block text-sm font-medium text-gray-700">Changes in Condition</label>
                        <input type="text" id="changes_in_condition" name="changes_in_condition" class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                        @error('changes_in_condition')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="rounds" class="block text-sm font-medium text-gray-700">Rounds</label>
                        <input type="text" id="rounds" name="rounds" class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                        @error('rounds')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="assessment_date" class="block text-sm font-medium text-gray-700">Assessment Date</label>
                        <input type="datetime-local" id="assessment_date" name="assessment_date" class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                        @error('assessment_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end mt-6">
                        <button id="next1" type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg shadow transition duration-200">Next</button>
                    </div>
                </div>
            </div>

            <!-- Patient Vital Signs Section -->
            <div id="step2" class="hidden">
                <div class="bg-gray-600 text-white text-lg font-semibold rounded-t-lg p-4">
                    Patient Vital Signs
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <label for="body_temperature" class="block text-sm font-medium text-gray-700">Body Temperature</label>
                        <input type="text" id="body_temperature" name="body_temperature" class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                        @error('body_temperature')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="blood_pressure" class="block text-sm font-medium text-gray-700">Blood Pressure</label>
                        <input type="text" id="blood_pressure" name="blood_pressure" class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                        @error('blood_pressure')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="respiratory_rate" class="block text-sm font-medium text-gray-700">Respiratory Rate</label>
                        <input type="text" id="respiratory_rate" name="respiratory_rate" class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                        @error('respiratory_rate')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="weight" class="block text-sm font-medium text-gray-700">Weight</label>
                        <input type="text" id="weight" name="weight" class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                        @error('weight')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="height" class="block text-sm font-medium text-gray-700">Height</label>
                        <input type="text" id="height" name="height" class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                        @error('height')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="pulse_rate" class="block text-sm font-medium text-gray-700">Pulse Rate</label>
                        <input type="text" id="pulse_rate" name="pulse_rate" class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                        @error('pulse_rate')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-between mt-6">
                        <button id="back1" type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-3 rounded-lg shadow transition duration-200">Back</button>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg shadow transition duration-200">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const progressBar = document.getElementById('progress-bar');

    document.getElementById('next1').addEventListener('click', function () {
        step1.classList.add('hidden');
        step2.classList.remove('hidden');
        progressBar.style.width = '100%'; // Adjust as needed
    });

    document.getElementById('back1').addEventListener('click', function () {
        step2.classList.add('hidden');
        step1.classList.remove('hidden');
        progressBar.style.width = '50%'; // Adjust as needed
    });
});
</script>
@endsection
