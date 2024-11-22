@extends('layouts.admin')
 
@section('title', 'Add Emergency Room')
 
@section('contents')



<div class="p-6">
    <div class="grid grid-cols-1 lg:grid-cols-1 gap-6 mb-6">
        <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
            <div class="flex mb-4">
                <div class="font-medium">Initial Emergency Room Registration</div>
            </div>
            <form action="{{ route('emergency.room.register.post') }}" method="POST">
                @csrf
                <div class="flex justify-between mb-4 items-start">
                    <div class="flex items-center w-full">
                        <input type="text" id="email_address" name="email" placeholder="Enter email..." class="bg-gray-50 text-sm font-medium text-gray-400 py-2 px-4 rounded-tl-md rounded-bl-md hover:text-gray-600 focus:text-gray-600 w-full">
                        <button type="submit" class="ml-2 bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-300 font-medium text-white rounded-lg text-sm px-3 py-2">Submit</button>
                    </div>
                </div>
                @if ($errors->has('email'))
                    <span class="text-red-500 text-sm">{{ $errors->first('email') }}</span>
                @endif
            </form>
        </div>
    </div>
</div>

        
        
    @endsection 