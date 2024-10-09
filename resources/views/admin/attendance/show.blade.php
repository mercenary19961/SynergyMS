@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    @include('partials.sidebar')

    <div class="flex-1 p-6 bg-gray-100">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold">Attendance Details</h1>
            <a href="{{ route('admin.attendance.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        <!-- Attendance Details -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-semibold mb-4">Employee: {{ $attendance->employee->user->name ?? 'N/A' }}</h2>

            <p><strong>Project Manager:</strong> {{ $attendance->projectManager->user->name ?? 'N/A' }}</p>
            <p><strong>Attendance Date:</strong> {{ $attendance->attendance_date }}</p>
            <p><strong>Clock In:</strong> {{ $attendance->clock_in }}</p>
            <p><strong>Clock Out:</strong> {{ $attendance->clock_out ?? 'N/A' }}</p>
            <p><strong>Total Hours:</strong> {{ $attendance->total_hours ?? 'N/A' }}</p>
            <p><strong>Leave Hours:</strong> {{ $attendance->leave_hours ?? 'N/A' }}</p>
            <p><strong>Status:</strong> {{ ucfirst($attendance->status) }}</p>

            <div class="mt-6">
                <a href="{{ route('admin.attendance.edit', $attendance->id) }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">
                    <i class="fas fa-edit mr-2"></i> Edit Attendance
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
