@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100 overflow-auto">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">Employee Details</h1>
            <a href="{{ route('admin.employees.index') }}" class="bg-gray-500 text-white mt-4 px-4 py-2 rounded hover:bg-gray-600 transition">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
        </div>
        <!-- Employee Info Section -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <div class="flex items-center">
                <img src="{{ $employee->image ? asset('storage/' . $employee->image) : asset('images/default_user_image.png') }}" class="w-24 h-24 rounded-full object-cover mr-4" alt="Employee Image">
                <div>
                    <h2 class="text-lg font-semibold">{{ $employee->user->name }}</h2>
                    <p class="text-gray-700">{{ $employee->position }} - {{ $employee->department->name }}</p>
                    <p class="text-gray-600">{{ $employee->user->email }}</p>
                    <p class="text-gray-600">{{ $employee->phone }}</p>
                </div>
            </div>
        </div>

        <!-- Personal Info & Employment Info (Responsive Grid) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Personal Info Section -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold mb-4">Personal Information</h2>
                <p><strong>Nationality:</strong> {{ $employee->nationality }}</p>
                <p><strong>Age:</strong> {{ $employee->age }}</p>
                <p><strong>Date of Birth:</strong> {{ $employee->date_of_birth->format('d M Y') }}</p>
                <p><strong>Address:</strong> {{ $employee->address }}</p>
            </div>

            <!-- Employment Info Section -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold mb-4">Employment Information</h2>
                <p><strong>Position:</strong> {{ $employee->position }}</p>
                <p><strong>Department:</strong> {{ $employee->department->name }}</p>
                <p><strong>Salary:</strong> ${{ number_format($employee->salary, 2) }}</p>
                <p><strong>Date of Joining:</strong> {{ $employee->date_of_joining->format('d M Y') }}</p>
            </div>
        </div>

        <!-- Attendance Records & Tickets Section (Responsive Grid) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Attendance Section -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold mb-4">Attendance Records</h2>
                @if ($employee->attendances->isEmpty())
                    <p>No attendance records available.</p>
                @else
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-left">Date</th>
                                <th class="py-2 px-4 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employee->attendances as $attendance)
                                <tr class="border-t">
                                    <td class="py-2 px-4">{{ $attendance->date }}</td>
                                    <td class="py-2 px-4">{{ ucfirst($attendance->status) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <!-- Tickets Section -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold mb-4">Assigned Tickets</h2>
                @if ($employee->tickets->isEmpty())
                    <p>No tickets assigned.</p>
                @else
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-left">Ticket Title</th>
                                <th class="py-2 px-4 text-left">Priority</th>
                                <th class="py-2 px-4 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employee->tickets as $ticket)
                                <tr class="border-t">
                                    <td class="py-2 px-4">{{ $ticket->title }}</td>
                                    <td class="py-2 px-4">{{ ucfirst($ticket->priority) }}</td>
                                    <td class="py-2 px-4">{{ ucfirst($ticket->status) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
