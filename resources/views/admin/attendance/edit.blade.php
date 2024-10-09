{{-- resources/views/admin/attendance/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">
        <x-title-with-back title="Edit Attendance Record" route="admin.attendance.index" />

        @include('components.form.errors')

        <form method="POST" action="{{ route('admin.attendance.update', $attendance->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="employee_id" class="block text-sm font-medium text-gray-700">Employee</label>
                <select name="employee_id" id="employee_id" class="w-full border rounded-lg p-2">
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ $attendance->employee_id == $employee->id ? 'selected' : '' }}>
                            {{ $employee->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="project_manager_id" class="block text-sm font-medium text-gray-700">Project Manager</label>
                <select name="project_manager_id" id="project_manager_id" class="w-full border rounded-lg p-2">
                    @foreach($projectManagers as $manager)
                        <option value="{{ $manager->id }}" {{ $attendance->project_manager_id == $manager->id ? 'selected' : '' }}>
                            {{ $manager->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="attendance_date" class="block text-sm font-medium text-gray-700">Attendance Date</label>
                <input type="date" name="attendance_date" id="attendance_date" class="w-full border rounded-lg p-2" value="{{ $attendance->attendance_date }}" required>
            </div>

            <div class="mb-4">
                <label for="clock_in" class="block text-sm font-medium text-gray-700">Clock In</label>
                <input type="time" name="clock_in" id="clock_in" class="w-full border rounded-lg p-2" value="{{ $attendance->clock_in }}" required>
            </div>

            <div class="mb-4">
                <label for="clock_out" class="block text-sm font-medium text-gray-700">Clock Out</label>
                <input type="time" name="clock_out" id="clock_out" class="w-full border rounded-lg p-2" value="{{ $attendance->clock_out }}">
            </div>

            <div class="mb-4">
                <label for="total_hours" class="block text-sm font-medium text-gray-700">Total Hours</label>
                <input type="number" name="total_hours" id="total_hours" class="w-full border rounded-lg p-2" value="{{ $attendance->total_hours }}">
            </div>

            <div class="mb-4">
                <label for="leave_hours" class="block text-sm font-medium text-gray-700">Leave Hours</label>
                <input type="number" name="leave_hours" id="leave_hours" class="w-full border rounded-lg p-2" value="{{ $attendance->leave_hours }}">
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <input type="text" name="status" id="status" class="w-full border rounded-lg p-2" value="{{ $attendance->status }}" required>
            </div>

            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg">Update Attendance</button>
        </form>
    
</div>
@endsection
