@extends('layouts.registration')

@section('title', 'Nurse Registration')

@section('contents')
<div class="p-6 max-w-2xl mx-auto">
    <div class="bg-white border border-gray-100 shadow-md p-6 rounded-md relative overflow-hidden">
        <!-- Progress Bar -->
        <div class="absolute top-0 left-0 h-2 bg-gray-200 w-full rounded-full">
            <div id="progress-bar" class="h-2 bg-blue-600 rounded-full transition-all duration-300" style="width: 33%;"></div>
        </div>

        <!-- Start of Form -->
        <form action="{{ route('nurse_post_final') }}" method="POST">
            @csrf <!-- Always include CSRF token for form security -->
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div id="step1" class="step">
                <div class="font-semibold text-lg mb-4 text-gray-800 text-center">Nurse Registration</div>
                <div class="font-semibold text-lg mb-4 text-gray-800 text-center">Step 1: Basic Information</div>

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="name" name="name" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required autofocus>
                        @if ($errors->has('name'))
                            <span class="text-red-500 text-sm">{{ $errors->first('name') }}</span>
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

                <div class="bg-blue-100 text-blue-800 p-4 rounded-md mt-4">
                    <p class="text-sm">Note: The new password must be at least 8 characters long, contain at least one uppercase letter, one number, and one special character (@$!%*?&).</p>
                </div>

                <div class="flex justify-end mt-6">
                    <button id="next1" type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg shadow transition duration-200">Next</button>
                </div>
            </div>

            <div id="step2" class="hidden step">
                <div class="font-semibold text-lg mb-4 text-gray-800 text-center">Step 2: Personal Information</div>

                <div class="space-y-4">

                    <div>
                        <label for="birthday" class="block text-sm font-medium text-gray-700">Birthday</label>
                        <input type="date" id="birthday" name="birthday" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @if ($errors->has('birthday'))
                            <span class="text-red-500 text-sm">{{ $errors->first('birthday') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                        <select id="gender" name="gender" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                        @if ($errors->has('gender'))
                            <span class="text-red-500 text-sm">{{ $errors->first('gender') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="birthplace" class="block text-sm font-medium text-gray-700">Birthplace</label>
                        <input type="text" id="birthplace" name="birthplace" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @if ($errors->has('birthplace'))
                            <span class="text-red-500 text-sm">{{ $errors->first('birthplace') }}</span>
                        @endif
                    </div>
                    
                    <div>
                        <label for="telephone_no" class="block text-sm font-medium text-gray-700">Telephone No.</label>
                        <input type="tel" id="telephone_no" name="telephone_no" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required placeholder="e.g. 09191234567">
                        <span id="phoneError" class="text-red-500 text-sm hidden">Invalid phone number format.</span>
                        @if ($errors->has('telephone_no'))
                            <span class="text-red-500 text-sm">{{ $errors->first('telephone_no') }}</span>
                        @endif
                    </div>

                </div>

                <div class="flex justify-between mt-6">
                    <button id="back1" type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-3 rounded-lg shadow transition duration-200">Back</button>
                    <button id="next2" type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg shadow transition duration-200">Next</button>
                </div>
            </div>

            <div id="step3" class="hidden step">
                <div class="font-semibold text-lg mb-4 text-gray-800 text-center">Step 3: Additional Information</div>

                <div class="space-y-4">
                    <div>
                        <label for="civil_status" class="block text-sm font-medium text-gray-700">Civil Status</label>
                        <input type="text" id="civil_status" name="civil_status" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @if ($errors->has('civil_status'))
                            <span class="text-red-500 text-sm">{{ $errors->first('civil_status') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="religion" class="block text-sm font-medium text-gray-700">Religion</label>
                        <input type="text" id="religion" name="religion" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @if ($errors->has('religion'))
                            <span class="text-red-500 text-sm">{{ $errors->first('religion') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="nationality" class="block text-sm font-medium text-gray-700">Nationality</label>
                        <input type="text" id="nationality" name="nationality" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @if ($errors->has('nationality'))
                            <span class="text-red-500 text-sm">{{ $errors->first('nationality') }}</span>
                        @endif
                    </div>
                </div>

                <div class="flex justify-between mt-6">
                    <button id="back2" type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-3 rounded-lg shadow transition duration-200">Back</button>
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
    const step3 = document.getElementById('step3');
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
            progressBar.style.width = '66%';
        } else {
            alert('Please fill out all required fields correctly before proceeding.');
        }
    });

    document.getElementById('back1').addEventListener('click', function () {
        step1.classList.remove('hidden');
        step2.classList.add('hidden');
        progressBar.style.width = '33%';
    });

    document.getElementById('next2').addEventListener('click', function () {
        if (validateStep(step2)) {
            step2.classList.add('hidden');
            step3.classList.remove('hidden');
            progressBar.style.width = '100%';
        } else {
            alert('Please fill out all required fields before proceeding.');
        }
    });

    document.getElementById('back2').addEventListener('click', function () {
        step2.classList.remove('hidden');
        step3.classList.add('hidden');
        progressBar.style.width = '66%';
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
