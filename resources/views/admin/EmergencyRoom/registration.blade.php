@extends('layouts.registration')

@section('title', 'EmergencyRoom Registration')

@section('contents')
<div class="p-6 max-w-2xl mx-auto">
    <div class="bg-white border border-gray-100 shadow-md p-6 rounded-md relative overflow-hidden">
        <!-- Progress Bar -->
        <div class="absolute top-0 left-0 h-2 bg-gray-200 w-full rounded-full">
            <div id="progress-bar" class="h-2 bg-blue-600 rounded-full transition-all duration-300" style="width: 50%;"></div>
        </div>

        <!-- Start of Form -->
        <form action="{{ route('emergency_room_post_final') }}" method="POST">
            @csrf <!-- Always include CSRF token for form security -->
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div id="step1" class="step">
                <div class="font-semibold text-lg mb-4 text-gray-800 text-center">Emergency Room Registration</div>
                <div class="font-semibold text-lg mb-4 text-gray-800 text-center">Step 1: Basic Information</div>

                <div class="space-y-4">
                    <div>
                        <label for="department_name" class="block text-sm font-medium text-gray-700">Emergency Room Name</label>
                        <input type="text" id="department_name" name="department_name" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required autofocus>
                        @if ($errors->has('department_name'))
                            <span class="text-red-500 text-sm">{{ $errors->first('department_name') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none pr-10" required>
                            <span onclick="togglePassword('password', 'passwordIcon')" class="absolute inset-y-0 right-3 flex items-center cursor-pointer">
                                <i id="passwordIcon" class="ri-eye-off-line"></i>
                            </span>
                        </div>
                        <span id="passwordError" class="text-red-500 text-sm hidden">Password must be at least 8 characters long, contain an uppercase letter, a number, and a special character.</span>
                    </div>

                    <div>
                        <label for="password_confirmation" class="text-sm font-medium text-gray-700">Confirm Password</label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none pr-10" required>
                            <span onclick="togglePassword('password_confirmation', 'confirmPasswordIcon')" class="absolute inset-y-0 right-3 flex items-center cursor-pointer">
                                <i id="confirmPasswordIcon" class="ri-eye-off-line"></i>
                            </span>
                        </div>
                        <span id="confirm-error" class="text-red-500 text-sm hidden">Passwords do not match.</span>
                    </div>

                </div>

                <div class="flex justify-end mt-6">
                    <button id="next1" type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg shadow transition duration-200">Next</button>
                </div>
            </div>

            <div id="step2" class="hidden step">
                <div class="font-semibold text-lg mb-4 text-gray-800 text-center">Step 2: Emergency Room Information</div>

                <div class="space-y-4">
                    <div>
                        <label for="department_code" class="block text-sm font-medium text-gray-700">Emergency Room Code</label>
                        <input type="text" id="department_code" name="department_code" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @if ($errors->has('department_code'))
                            <span class="text-red-500 text-sm">{{ $errors->first('department_code') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <input type="text" id="address" name="address" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @if ($errors->has('address'))
                            <span class="text-red-500 text-sm">{{ $errors->first('address') }}</span>
                        @endif
                    </div>
                    
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700">Telephone No.</label>
                        <input type="tel" id="phone_number" name="phone_number" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required placeholder="e.g. 09191234567">
                        <span id="phoneError" class="text-red-500 text-sm hidden">Invalid phone number format.</span>
                        @if ($errors->has('phone_number'))
                            <span class="text-red-500 text-sm">{{ $errors->first('phone_number') }}</span>
                        @endif
                    </div>

                </div>

                <div class="flex justify-between mt-6">
                    <button id="back1" type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-3 rounded-lg shadow transition duration-200">Back</button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg shadow transition duration-200">Register</button>
                </div>
            </div>
        </form>
        <!-- End of Form -->
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const progressBar = document.getElementById('progress-bar');

    // Define password requirements using a regular expression
    const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    const telephoneRegex = /^09\d{9}$/;

    function validateStep(step) {
        let valid = true;
        const inputs = step.querySelectorAll('input[required], select[required]');
        
        inputs.forEach(input => {
            if (!input.value) {
                input.classList.add('border-red-400'); // Highlight input with red border if invalid
                valid = false;
            } else {
                input.classList.remove('border-red-400');
            }

            // Additional validation for password field in Step 1
            if (input.id === 'password') {
                if (!passwordRegex.test(input.value)) {
                    input.classList.add('border-red-400');
                    document.getElementById('passwordError').classList.remove('hidden');
                    valid = false;
                } else {
                    input.classList.remove('border-red-400');
                    document.getElementById('passwordError').classList.add('hidden');
                }
            }

            // Validation for password confirmation
            if (input.id === 'password_confirmation') {
                const password = document.getElementById('password').value;
                const confirmPassword = input.value;

                if (password !== confirmPassword) {
                    input.classList.add('border-red-400');
                    document.getElementById('confirm-error').classList.remove('hidden');
                    valid = false;
                } else {
                    input.classList.remove('border-red-400');
                    document.getElementById('confirm-error').classList.add('hidden');
                }
            }

            // Additional validation for telephone field
            if (input.id === 'telephone_no') {
                const errorSpan = document.getElementById('phoneError'); // Reference to the phone error span
                if (!telephoneRegex.test(input.value)) {
                    input.classList.add('border-red-400');
                    errorSpan.classList.remove('hidden'); // Show custom error message
                    valid = false;
                } else {
                    input.classList.remove('border-red-400');
                    errorSpan.classList.add('hidden'); // Hide custom error message if valid
                }
            }
        });
        
        return valid;
    }

    document.getElementById('next1').addEventListener('click', function () {
        if (validateStep(step1)) {
            step1.classList.add('hidden');
            step2.classList.remove('hidden');
            progressBar.style.width = '100%'; // Set progress to 100% when moving to step 2
        } else {
            alert('Please fill out all required fields correctly before proceeding.');
        }
    });

    document.getElementById('back1').addEventListener('click', function () {
        step1.classList.remove('hidden');
        step2.classList.add('hidden');
        progressBar.style.width = '50%'; // Adjust progress for going back
    });
});

function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'ri-eye-line';
    } else {
        input.type = 'password';
        icon.className = 'ri-eye-off-line';
    }
}
</script>
@endsection
