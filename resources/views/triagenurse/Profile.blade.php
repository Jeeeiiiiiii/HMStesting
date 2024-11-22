@extends('layouts.triagenurse')

@section('title', 'Registration')

@section('contents')
<div class="flex items-center justify-center min-h-screen p-6 bg-gray-100">
    <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md w-full max-w-3xl">
        <div class="text-center mb-6">
            <h2 class="text-xl font-semibold">Attendees</h2>
        </div>
        <form action="{{ route('storeProfile', $patient->id) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-6">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" name="name" class="bg-gray-50 text-sm font-medium text-gray-400 py-2 px-4 rounded-md hover:text-gray-600 focus:text-gray-600 w-full" required>
                    @if ($errors->has('name'))
                        <span class="text-red-500 text-sm">{{ $errors->first('name') }}</span>
                    @endif
                </div>

                <div class="mb-4">
                    <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                    <input type="number" id="age" name="age" class="bg-gray-50 text-sm font-medium text-gray-400 py-2 px-4 rounded-md hover:text-gray-600 focus:text-gray-600 w-full" required>
                    @if ($errors->has('age'))
                        <span class="text-red-500 text-sm">{{ $errors->first('age') }}</span>
                    @endif
                </div>

                <div class="mb-4">
                    <label for="birthday" class="block text-sm font-medium text-gray-700">Birthday</label>
                    <input type="date" id="birthday" name="birthday" class="bg-gray-50 text-sm font-medium text-gray-400 py-2 px-4 rounded-md hover:text-gray-600 focus:text-gray-600 w-full" required>
                    @if ($errors->has('birthday'))
                        <span class="text-red-500 text-sm">{{ $errors->first('birthday') }}</span>
                    @endif
                </div>

                <div class="mb-4">
                    <label for="birthplace" class="block text-sm font-medium text-gray-700">Birthplace</label>
                    <input type="text" id="birthplace" name="birthplace" class="bg-gray-50 text-sm font-medium text-gray-400 py-2 px-4 rounded-md hover:text-gray-600 focus:text-gray-600 w-full" required>
                    @if ($errors->has('birthplace'))
                        <span class="text-red-500 text-sm">{{ $errors->first('birthplace') }}</span>
                    @endif
                </div>

                <div class="mb-4">
                    <label for="civil_status" class="block text-sm font-medium text-gray-700">Civil Status</label>
                    <input type="text" id="civil_status" name="civil_status" class="bg-gray-50 text-sm font-medium text-gray-400 py-2 px-4 rounded-md hover:text-gray-600 focus:text-gray-600 w-full" required>
                    @if ($errors->has('civil_status'))
                        <span class="text-red-500 text-sm">{{ $errors->first('civil_status') }}</span>
                    @endif
                </div>

                <div class="mb-4">
                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                    <select id="gender" name="gender" class="bg-gray-50 text-sm font-medium text-gray-400 py-2 px-4 rounded-md hover:text-gray-600 focus:text-gray-600 w-full" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                    @if ($errors->has('gender'))
                        <span class="text-red-500 text-sm">{{ $errors->first('gender') }}</span>
                    @endif
                </div>

                <div class="mb-4">
                    <label for="telephone_no" class="block text-sm font-medium text-gray-700">Telephone No</label>
                    <input type="tel" id="telephone_no" name="telephone_no" class="bg-gray-50 text-sm font-medium text-gray-400 py-2 px-4 rounded-md hover:text-gray-600 focus:text-gray-600 w-full" required>
                    @if ($errors->has('telephone_no'))
                        <span class="text-red-500 text-sm">{{ $errors->first('telephone_no') }}</span>
                    @endif
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2">Add</button>
            </div>
        </form>
    </div>
</div>
@endsection
