{{-- resources/views/admin/attendance/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">
        <h1 class="mb-4 text-2xl font-semibold">Attendance Records</h1>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Add New Attendance Button -->
        <a href="{{ route('admin.attendance.create') }}" class="btn btn-primary mb-3">Add New Attendance</a>

        <!-- Attendance Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 text-left">#</th>
                        <th class="py-2 px-4 text-left">Employee</th>
                        <th class="py-2 px-4 text-left">Project Manager</th>
                        <th class="py-2 px-4 text-left">Attendance Date</th>
                        <th class="py-2 px-4 text-left">Clock In</th>
                        <th class="py-2 px-4 text-left">Clock Out</th>
                        <th class="py-2 px-4 text-left">Total Hours</th>
                        <th class="py-2 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $attendance)
                        <tr class="border-t">
                            <td class="py-2 px-4">{{ $attendance->id }}</td>
                            <td class="py-2 px-4">{{ $attendance->employee->user->name ?? 'N/A' }}</td>
                            <td class="py-2 px-4">{{ $attendance->projectManager->user->name ?? 'N/A' }}</td>
                            <td class="py-2 px-4">{{ $attendance->attendance_date }}</td>
                            <td class="py-2 px-4">{{ $attendance->clock_in }}</td>
                            <td class="py-2 px-4">{{ $attendance->clock_out ?? 'N/A' }}</td>
                            <td class="py-2 px-4">{{ $attendance->total_hours ?? 'N/A' }}</td>
                            <td class="py-2 px-4">
                                <a href="{{ route('admin.attendance.edit', $attendance->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.attendance.destroy', $attendance->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
