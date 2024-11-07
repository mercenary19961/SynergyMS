@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <div class="flex-1 p-6 bg-gray-100">
        <!-- Employee Name Header with Clock In/Out Button -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">
                <i class="fas fa-user mr-2 text-gray-600"></i> {{ $employee->name }}'s Dashboard
            </h1>

            <!-- Clock In/Out Button -->
            @if (!$todayAttendance)
                <form action="{{ route('employee.clockin') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                        Clock In
                    </button>
                </form>
            @elseif (!$todayAttendance->clock_out && Carbon\Carbon::now()->diffInHours($todayAttendance->clock_in) >= 6)
                <form action="{{ route('employee.clockout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                        Clock Out
                    </button>
                </form>
            @else
                <button class="bg-gray-500 text-white px-4 py-2 rounded" disabled>
                    {{ $todayAttendance->clock_out ? 'Clocked Out' : 'Clock Out (Cannot click yet!)' }}
                </button>
            @endif
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Assigned Projects Card -->
            <livewire:employee-summary-card 
                title="Assigned Projects" 
                icon="fas fa-briefcase" 
                route="{{ route('admin.projects.index') }}" 
                countType="assignedProjects" 
            />

            <!-- Tasks Card -->
            <livewire:employee-summary-card 
                title="Assigned Tasks" 
                icon="fas fa-tasks" 
                route="{{ route('admin.projects.index') }}" 
                countType="tasks" 
            />
        
            <!-- Tickets Card -->
            <livewire:employee-summary-card 
                title="Assigned Tickets" 
                icon="fas fa-ticket-alt" 
                route="{{ route('admin.tickets.index') }}" 
                countType="assignedTickets" 
            />
        
            <!-- Attending Events Card -->
            <livewire:employee-summary-card 
                title="Attending Events" 
                icon="fas fa-calendar-check" 
                route="{{ route('admin.events.index') }}" 
                countType="attendingEvents" 
            />
        </div>

        <!-- Employee's Assigned Projects -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-4">Your Projects</h2>
            <div class="grid grid-cols-1 gap-4">
                @foreach($assignedProjects as $project)
                    <div class="bg-white p-4 rounded shadow">
                        <h3 class="font-semibold">{{ $project->name }}</h3>
                        <p class="text-gray-500 text-sm">{{ $project->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Employee's Attendance Records -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Your Attendance Records</h2>
            <div class="bg-white p-4 rounded shadow">
                <table class="min-w-full bg-white rounded-lg shadow">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-2 px-4 text-left">Date</th>
                            <th class="py-2 px-4 text-left">Clock In</th>
                            <th class="py-2 px-4 text-left">Clock Out</th>
                            <th class="py-2 px-4 text-left">Hours Worked</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendanceRecords as $attendance)
                            <tr class="border-t">
                                <td class="py-2 px-4">{{ $attendance->attendance_date->format('D, M j, Y') }}</td>
                                <td class="py-2 px-4">{{ $attendance->clock_in }}</td>
                                <td class="py-2 px-4">{{ $attendance->clock_out ?? 'N/A' }}</td>
                                <td class="py-2 px-4">{{ $attendance->hours_worked ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
