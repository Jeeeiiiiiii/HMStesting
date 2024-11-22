@extends('layouts.doctor')

@section('title', 'Treatment Plan')

@section('contents')

<div class="p-6">
    <div class="grid grid-cols-1 gap-6 mb-6">
        <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
            <div class="mb-4">
                <h2 class="font-medium text-lg text-gray-700">Treatment Plan</h2>
            </div>

            <!-- Adjusting this section for responsiveness -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[540px]">
                    <thead>
                        <tr>
                            <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tl-md rounded-bl-md">#</th>
                            <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tl-md rounded-bl-md">Name</th>
                            <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">Email</th>
                            <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">Date</th>
                            <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tr-md rounded-br-md">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patientRecords as $record)
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-50">
                                {{ $loop->iteration }}
                            </th>
                            <td class="py-2 px-4 border-b border-gray-50">
                                {{ $record->patient->name }}                                            
                            </td>
                            <td class="py-2 px-4 border-b border-gray-50">
                                {{ $record->patient->email }}
                            </td>
                            <td class="py-2 px-4 border-b border-gray-50">
                                {{ $record->created_at->format('Y-m-d') }}
                            </td>
                            <td class="py-2 px-4 border-b border-gray-50">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('doctor_addplan', $record->patient->id) }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 transition duration-200">Add Plan</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
