@extends('layouts.department')

@section('title', 'Medical Orders')

@section('contents')

<div class="p-6">
    <div class="grid grid-cols-1 gap-6 mb-6">
        <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
            <div class="flex mb-4">
                <div class="font-medium text-lg text-gray-700">Medical Orders</div>
            </div>

            <!-- Search and Filter Section -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
                <!-- Status Filter -->
                <form action="{{ route('department_medical_order') }}" method="GET" class="flex flex-col sm:flex-row w-full sm:w-auto gap-4">
                    <div>
                        <select name="status" class="w-full sm:w-[180px] border border-gray-300 rounded-lg p-2" onchange="this.form.submit()">
                            <option value="pending" {{ request('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <!-- Search Input -->
                    <div class="flex w-full sm:w-auto items-center space-x-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search orders..." class="w-full sm:w-auto bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md text-sm px-4 py-2 focus:ring-2 focus:ring-blue-300 transition duration-200">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </form>
            </div>

            <!-- Count Information -->
            <div class="flex justify-between items-center bg-gray-100 p-4 rounded-lg">
                <span class="text-sm font-medium">
                    Showing {{ request('status', 'pending') == 'pending' ? 'Pending' : 'Completed' }}
                </span>
                <span class="text-sm text-gray-500">
                    Total: {{ $orders->count() }} {{ request('status', 'pending') == 'pending' ? 'Pending' : 'Completed' }}
                </span>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[540px]">
                    <thead>
                        <tr>
                            <th class="text-xs uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tl-md">#</th>
                            <th class="text-xs uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">Patient Name</th>
                            <th class="text-xs uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">Doctor Name</th>
                            <th class="text-xs uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">Title</th>
                            <th class="text-xs uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">Order Date</th>
                            <th class="text-xs uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tr-md">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b border-gray-200">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $order->patient->name }}</td> <!-- Patient Name -->
                            <td class="py-2 px-4 border-b border-gray-200">{{ $order->doctor->name }}</td> <!-- Doctor Name -->
                            <td class="py-2 px-4 border-b border-gray-200">{{ $order->title }}</td> <!-- Admitting Department -->
                            <td class="py-2 px-4 border-b border-gray-200">{{ \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">
                                <div class="flex gap-2">
                                    <a href="{{ route('department_order', $order->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-blue-300 transition duration-200">View Details</a>
                                    
                                    <!-- Form for updating order status -->
                                    <form action="{{ route('department.updateOrderStatus', $order->id) }}" method="POST" class="flex items-center justify-center">
                                        @csrf
                                        <div class="flex items-center space-x-4">
                                            <select name="status" class="form-select border border-gray-300 rounded-md py-2 px-3 focus:ring focus:ring-blue-500 focus:border-blue-500">
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-5 rounded shadow transition-all duration-150 ease-in-out">
                                                Update Status
                                            </button>
                                        </div>
                                    </form>
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

<script>
    function toggleDropdown() {
        document.getElementById('dropdownMenu').classList.toggle('hidden');
    }
</script>
        
@endsection
