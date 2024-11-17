@extends('layouts.app')

@section('content')
<div class="flex flex-col h-screen">
    <div class="flex-1 p-2 lg:p-6 bg-gray-100">
        <!-- Back button and title -->
        <x-title-with-back title="Attendance Details" route="admin.attendance.index" />

        <!-- Attendance Details Card -->
        <div class="bg-white p-6 rounded-lg shadow-lg space-y-6">
            <!-- Employee and Project Manager Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Employee Info -->
                <div class="bg-gray-100 p-4 rounded-lg">
                    <h2 class="text-md font-semibold text-gray-700">
                        <i class="fas fa-user mr-2 text-orange-500"></i> Employee
                    </h2>
                    <p class="text-gray-600">
                        {{ $attendance->employee && $attendance->employee->user ? $attendance->employee->user->name : 'N/A' }}
                    </p>
                </div>

                <!-- Project Manager Info -->
                <div class="bg-gray-100 p-4 rounded-lg">
                    <h2 class="text-md font-semibold text-gray-700">
                        <i class="fas fa-briefcase mr-2 text-orange-500"></i> Project Manager
                    </h2>
                    <p class="text-gray-600">
                        {{ $attendance->employee && $attendance->employee->projectManager && $attendance->employee->projectManager->user ? $attendance->employee->projectManager->user->name : 'N/A' }}
                    </p>
                </div>
            </div>

            <!-- Attendance Information -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Attendance Date -->
                <div class="bg-gray-100 p-4 rounded-lg">
                    <h2 class="text-md font-semibold text-gray-700">
                        <i class="fas fa-calendar-alt mr-2 text-orange-500"></i> Attendance Date
                    </h2>
                    <p class="text-gray-600">{{ $attendance->attendance_date }}</p>
                </div>

                <!-- Clock In -->
                <div class="bg-gray-100 p-4 rounded-lg">
                    <h2 class="text-md font-semibold text-gray-700">
                        <i class="fas fa-clock mr-2 text-orange-500"></i> Clock In
                    </h2>
                    <p class="text-gray-600">{{ $attendance->clock_in ?? 'N/A' }}</p>
                </div>

                <!-- Clock Out -->
                <div class="bg-gray-100 p-4 rounded-lg">
                    <h2 class="text-md font-semibold text-gray-700">
                        <i class="fas fa-clock mr-2 text-orange-500"></i> Clock Out
                    </h2>
                    <p class="text-gray-600">{{ $attendance->clock_out ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Total and Leave Hours -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Total Hours -->
                <div class="bg-gray-100 p-4 rounded-lg">
                    <h2 class="text-md font-semibold text-gray-700">
                        <i class="fas fa-hourglass-start mr-2 text-orange-500"></i> Total Hours
                    </h2>
                    <p class="text-gray-600">{{ $attendance->total_hours ?? 'N/A' }}</p>
                </div>

                <!-- Leave Hours -->
                <div class="bg-gray-100 p-4 rounded-lg">
                    <h2 class="text-md font-semibold text-gray-700">
                        <i class="fas fa-clock mr-2 text-orange-500"></i> Leave Hours
                    </h2>
                    <p class="text-gray-600">{{ $attendance->leave_hours ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Status -->
            <div class="bg-gray-100 p-4 rounded-lg">
                <h2 class="text-md font-semibold text-gray-700">
                    <i class="fas fa-info-circle mr-2 text-orange-500"></i> Status
                </h2>
                <p class="text-gray-600">{{ ucfirst($attendance->status) }}</p>
            </div>

            <!-- Action Button -->
            @role('Super Admin|HR')
            <div class="flex justify-end">
                <a href="{{ route('admin.attendance.edit', $attendance->id) }}" class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition">
                    <i class="fas fa-edit mr-2"></i> Edit Attendance
                </a>
            </div>
            @endrole
        </div>
    </div>
</div>
@endsection
