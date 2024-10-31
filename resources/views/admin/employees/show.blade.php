@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <div class="flex-1 p-6 bg-gray-100 overflow-auto">
        <x-title-with-back title="Employee Details" />

        <!-- Employee Info Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6"> <!-- Using grid to align image and text -->
            <div class=" p-6 rounded-lg shadow-lg flex justify-center items-center"> <!-- Center the image -->
                <div class="flex-shrink-0 mb-4 md:mb-0">
                    <img loading="lazy" 
                        src="{{ $employee->user->image ? asset('storage/' . $employee->user->image) . '?v=' . time() : asset('images/default_user_image.png') }}" 
                        class="rounded-full object-cover h-40 w-40">
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg"> <!-- Right side (Information) -->
                <h2 class="text-lg font-semibold">
                    <i class="fas fa-user mr-2 text-orange-600"></i>{{ $employee->user->name }}
                </h2>
                <p class="text-gray-700">
                    <i class="fas fa-briefcase mr-2 text-orange-600"></i>{{ $employee->position->name }} - {{ $employee->department->name }}
                </p>
                <p class="text-gray-600">
                    <i class="fas fa-envelope mr-2 text-orange-600"></i>{{ $employee->user->email }}
                </p>
                <p class="text-gray-600">
                    <i class="fas fa-phone-alt mr-2 text-orange-600"></i>{{ $employee->phone }}
                </p>
            </div>
        </div>

        <!-- Personal Info & Employment Info (Responsive Grid) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Personal Info Section -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold mb-4">
                    <i class="fas fa-info-circle mr-2 text-orange-600"></i>Personal Information
                </h2>
                <p>
                    <i class="fas fa-flag mr-2 text-orange-600"></i><strong>Nationality:</strong> {{ $employee->nationality }}
                </p>
                <p>
                    <i class="fas fa-birthday-cake mr-2 text-orange-600"></i><strong>Age:</strong> {{ $employee->age }}
                </p>
                <p>
                    <i class="fas fa-calendar-alt mr-2 text-orange-600"></i><strong>Date of Birth:</strong> {{ $employee->date_of_birth->format('d M Y') }}
                </p>
                <p>
                    <i class="fas fa-map-marker-alt mr-2 text-orange-600"></i><strong>Address:</strong> {{ $employee->address }}
                </p>
            </div>

            <!-- Employment Info Section -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold mb-4">
                    <i class="fas fa-briefcase mr-2 text-orange-600"></i>Employment Information
                </h2>
                <p>
                    <i class="fas fa-user-tag mr-2 text-orange-600"></i><strong>Position:</strong> {{ $employee->position->name }}
                </p>
                <p>
                    <i class="fas fa-building mr-2 text-orange-600"></i><strong>Department:</strong> {{ $employee->department->name }}
                </p>
                <p>
                    <i class="fas fa-dollar-sign mr-2 text-orange-600"></i><strong>Salary:</strong> ${{ number_format($employee->salary, 2) }}
                </p>
                <p>
                    <i class="fas fa-calendar-check mr-2 text-orange-600"></i><strong>Date of Joining:</strong> {{ $employee->date_of_joining->format('d M Y') }}
                </p>
            </div>
        </div>

        <!-- Attendance Records & Tickets Section (Responsive Grid) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Attendance Section -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold mb-4">
                    <i class="fas fa-calendar-check mr-2 text-orange-600"></i>Attendance Records
                </h2>
                @if ($employee->attendances->isEmpty())
                    <p>
                        <i class="fas fa-exclamation-circle mr-2 text-orange-600"></i>No attendance records available.
                    </p>
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
                <h2 class="text-lg font-semibold mb-4">
                    <i class="fas fa-ticket-alt mr-2 text-orange-600"></i>Assigned Tickets
                </h2>
                @if ($employee->tickets->isEmpty())
                    <p>
                        <i class="fas fa-exclamation-circle mr-2 text-orange-600"></i>No tickets assigned.
                    </p>
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
