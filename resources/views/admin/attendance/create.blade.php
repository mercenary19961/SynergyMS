{{-- resources/views/admin/attendance/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">
        <h1 class="mb-4 text-2xl font-semibold">Create Attendance Record</h1>

        <!-- Error Handling -->
        @include('components.form.errors')

        <form method="POST" action="{{ route('admin.attendance.store') }}">
            @csrf

            <!-- Employee Dropdown -->
            <div class="mb-4">
                <label for="employee_id" class="block text-sm font-medium text-gray-700">Employee</label>
                <select name="employee_id" id="employee_id" class="w-full border rounded-lg p-2">
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Project Manager Dropdown -->
            <div class="mb-4">
                <label for="project_manager_id" class="block text-sm font-medium text-gray-700">Project Manager</label>
                <select name="project_manager_id" id="project_manager_id" class="w-full border rounded-lg p-2">
                    @foreach($projectManagers as $manager)
                        <option value="{{ $manager->id }}">{{ $manager->user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Attendance Date -->
            <div class="mb-4">
                <label for="attendance_date" class="block text-sm font-medium text-gray-700">Attendance Date</label>
                <input type="date" name="attendance_date" id="attendance_date" class="w-full border rounded-lg p-2" required>
            </div>

            <!-- Clock In -->
            <div class="mb-4">
                <label for="clock_in" class="block text-sm font-medium text-gray-700">Clock In</label>
                <input type="time" name="clock_in" id="clock_in" class="w-full border rounded-lg p-2" required>
            </div>

            <!-- Clock Out -->
            <div class="mb-4">
                <label for="clock_out" class="block text-sm font-medium text-gray-700">Clock Out</label>
                <input type="time" name="clock_out" id="clock_out" class="w-full border rounded-lg p-2">
            </div>

            <!-- Total Hours -->
            <div class="mb-4">
                <label for="total_hours" class="block text-sm font-medium text-gray-700">Total Hours</label>
                <input type="number" name="total_hours" id="total_hours" class="w-full border rounded-lg p-2">
            </div>

            <!-- Leave Hours -->
            <div class="mb-4">
                <label for="leave_hours" class="block text-sm font-medium text-gray-700">Leave Hours</label>
                <input type="number" name="leave_hours" id="leave_hours" class="w-full border rounded-lg p-2">
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <input type="text" name="status" id="status" class="w-full border rounded-lg p-2" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg">Create Attendance</button>

            <!-- Back Button -->
            <x-back-button />
        </form>
    </div>
</div>
@endsection
