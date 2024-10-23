@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <div class="flex-1 p-6 bg-gray-100">
        <!-- Project Manager Name Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">
                <i class="fas fa-user-tie mr-2 text-gray-600"></i> {{ $projectManager->user->name }}'s Dashboard
            </h1>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Managed Projects Card -->
            <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center transition-all duration-500 transform hover:scale-105 hover:shadow-2xl">
                <i class="fas fa-briefcase text-orange-500 text-4xl mb-2"></i>
                <h3 class="text-4xl font-bold text-orange-500">{{ $managedProjects->count() }}</h3>
                <p class="text-gray-600 mt-1">Managed Projects</p>
            </div>

            <!-- Tasks Card  -->
            <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center transition-all duration-500 transform hover:scale-105 hover:shadow-2xl">
                <i class="fas fa-tasks text-orange-500 text-4xl mb-2"></i>
                <h3 class="text-4xl font-bold text-orange-500">
                    {{ $managedProjects->pluck('tasks')->flatten()->count() }}
                </h3>
                <p class="text-gray-600 mt-1">Total Tasks</p>
            </div>

            <!-- Managed Employees Card -->
            <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center transition-all duration-500 transform hover:scale-105 hover:shadow-2xl">
                <i class="fas fa-users text-orange-500 text-4xl mb-2"></i>
                <h3 class="text-4xl font-bold text-orange-500">{{ $managedEmployees->count() }}</h3>
                <p class="text-gray-600 mt-1">Managed Employees</p>
            </div>

            <!-- Clients Card -->
            <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center transition-all duration-500 transform hover:scale-105 hover:shadow-2xl">
                <i class="fas fa-handshake text-orange-500 text-4xl mb-2"></i>
                <h3 class="text-4xl font-bold text-orange-500">
                    {{ $managedProjects->pluck('client')->unique('id')->count() }}
                </h3>
                <p class="text-gray-600 mt-1">Clients</p>
            </div>
        </div>


        <!-- Managed Projects -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Current Projects</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8 bg-gray-100">
                @foreach($managedProjects as $project)
                    <!-- Card without progress bar and with orange button at the bottom -->
                    <div class="bg-white p-4 rounded-lg shadow-lg w-full sm:w-full transition-all duration-500 transform hover:scale-105 hover:shadow-2xl flex flex-col justify-between">
                        <!-- Project Title -->
                        <h3 class="text-md font-semibold text-gray-700">{{ $project->name }}</h3>
                        
                        <!-- Task Summary -->
                        <p class="text-sm text-gray-600 mb-2">{{ $project->tasks_open }} <span class="text-orange-400">open</span> tasks, {{ $project->tasks_completed }} tasks <span class="text-green-500">completed</span></p>
                
                        <!-- Project Description -->
                        <p class="text-gray-600 mb-4">{{ Str::limit($project->description, 100, '...') }}</p>
                
                        <!-- Deadline -->
                        <p class="font-semibold text-gray-600">Deadline: <span class="font-normal">{{ $project->end_date->format('d M Y') }}</span></p>
                
                        <!-- Project Leader -->
                        <p class="font-semibold text-gray-600 mt-2">Project Leader:</p>
                        <div class="flex items-center mb-4">
                            <img src="{{ asset('storage/' . $projectManager->user->image) }}" alt="Project Leader" class="w-8 h-8 rounded-full">
                        </div>
                
                        <!-- Team Members -->
                        <p class="font-semibold text-gray-600">Team:</p>
                        <div class="flex items-center mb-4 -space-x-2">
                            @foreach($project->employees->filter(fn($employee) => $employee->department_id == $projectManager->department_id)->take(4) as $employee)
                                <img src="{{ $employee->user->image ? asset('storage/' . $employee->user->image) : asset('images/default_user_image.png') }}" alt="{{ $employee->name }}" class="w-8 h-8 rounded-full border-2 border-white">
                            @endforeach
                            @php
                                $departmentEmployeeCount = $project->employees->filter(fn($employee) => $employee->department_id == $projectManager->department_id)->count();
                            @endphp
                            @if($departmentEmployeeCount > 4)
                                <span class="text-sm  ml-2 bg-orange-500 text-white rounded-full px-2">+{{ $departmentEmployeeCount - 4 }}</span>
                            @endif
                        </div>

                        <!-- View Project Button -->
                        <a href="{{ route('admin.projects.show', $project->id) }}" class="mt-auto bg-orange-500 text-white text-center py-2 px-4 rounded hover:bg-orange-600 transition">
                            View Project
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Managed Employees -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-4">Team of Employees</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($managedEmployees->take(7) as $employee)
                    <div class="bg-white p-4 rounded-lg shadow transition-all duration-300 transform hover:scale-105 hover:shadow-2xl flex flex-col items-center">
                        <!-- Employee Image -->
                        <img 
                            class="w-16 h-16 rounded-full mb-3 object-cover" 
                            src="{{ $employee->user->image ? asset('storage/' . $employee->user->image) : asset('images/default_user_image.png') }}" 
                            alt="{{ $employee->user->name }}">
                        
                        <!-- Employee Name -->
                        <h3 class="font-semibold text-gray-700">{{ $employee->user->name }}</h3>
                        
                        <!-- Department -->
                        <p class="text-gray-500 text-sm">Department: {{ $employee->department->name }}</p>
                        
                        <!-- Position -->
                        <p class="text-gray-400 text-xs">Position: {{ $employee->position->name }}</p>
                    </div>
                @endforeach

                <!-- Show 'View All Employees' Button if there are more than 7 employees -->
                @if($managedEmployees->count() > 7)
                    <div class="bg-white p-4 rounded-lg shadow transition-all duration-300 transform hover:scale-105 hover:shadow-2xl flex flex-col items-center justify-center">
                        <a href="{{ route('admin.employees.index') }}" class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition flex items-center">
                            View All Employees
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Attendance Records -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Attendance Records</h2>
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
                                <td class="py-2 px-4">{{ $attendance->total_hours ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
