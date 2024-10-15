@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">
        <!-- Dashboard Header -->
        <h1 class="text-2xl font-semibold mb-6">
            <i class="fas fa-tachometer-alt mr-2 text-gray-600"></i> Admin Dashboard
        </h1>

        <!-- Summary Cards (Employees, Clients, Projects, Tickets) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Employees Card -->
            <div class="bg-white p-6 rounded shadow text-center">
                <i class="fas fa-users fa-2x text-orange-500 mb-2"></i>
                <div class="text-4xl font-bold text-orange-500 mb-2">{{ $totalEmployees }}</div>
                <p class="text-sm font-semibold text-gray-600">Total Employees</p>
            </div>

            <!-- Clients Card -->
            <div class="bg-white p-6 rounded shadow text-center">
                <i class="fas fa-handshake fa-2x text-orange-500 mb-2"></i>
                <div class="text-4xl font-bold text-orange-500 mb-2">{{ $totalClients }}</div>
                <p class="text-sm font-semibold text-gray-600">Total Clients</p>
            </div>

            <!-- Projects Card -->
            <div class="bg-white p-6 rounded shadow text-center">
                <i class="fas fa-briefcase fa-2x text-orange-500 mb-2"></i>
                <div class="text-4xl font-bold text-orange-500 mb-2">{{ $totalProjects }}</div>
                <p class="text-sm font-semibold text-gray-600">Total Projects</p>
            </div>

            <!-- Tickets Card -->
            <div class="bg-white p-6 rounded shadow text-center">
                <i class="fas fa-ticket-alt fa-2x text-orange-500 mb-2"></i>
                <div class="text-4xl font-bold text-orange-500 mb-2">{{ $totalTickets }}</div>
                <p class="text-sm font-semibold text-gray-600">Total Tickets</p>
            </div>
        </div>

        <!-- Recent Employees, Clients, and Projects -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Recent Employees -->
            <div class="bg-white p-6 rounded shadow">
                <i class="fas fa-user-plus fa-2x text-orange-500 mb-2"></i>
                <h2 class="text-xl font-semibold mb-4">Recent Employees</h2>
                <ul class="text-sm">
                    @foreach ($recentEmployees as $employee)
                        <li class="mb-2">{{ $employee->user->name }} <span class="text-gray-500">(Joined {{ $employee->created_at->diffForHumans() }})</span></li>
                    @endforeach
                </ul>
                <a href="{{ route('admin.employees.index') }}" class="block bg-orange-500 text-white text-center py-2 rounded mt-4">View All Employees</a>
            </div>

            <!-- Recent Clients -->
            <div class="bg-white p-6 rounded shadow">
                <i class="fas fa-user-tie fa-2x text-orange-500 mb-2"></i>
                <h2 class="text-xl font-semibold mb-4">Recent Clients</h2>
                <ul class="text-sm">
                    @foreach ($recentClients as $client)
                        <li class="mb-2">{{ $client->user->name }} <span class="text-gray-500">(Joined {{ $client->created_at->diffForHumans() }})</span></li>
                    @endforeach
                </ul>
                <a href="{{ route('admin.clients.index') }}" class="block bg-orange-500 text-white text-center py-2 rounded mt-4">View All Clients</a>
            </div>

            <!-- Recent Projects -->
            <div class="bg-white p-6 rounded shadow">
                <i class="fas fa-list-check fa-2x text-orange-500 mb-2"></i>
                <h2 class="text-xl font-semibold mb-4">Recent Projects</h2>
                <ul class="text-sm">
                    @foreach ($recentProjects as $project)
                        <li class="mb-2">{{ $project->name }} <span class="text-gray-500">(Started {{ $project->created_at->diffForHumans() }})</span></li>
                    @endforeach
                </ul>
                <a href="{{ route('admin.projects.index') }}" class="block bg-orange-500 text-white text-center py-2 rounded mt-4">View All Projects</a>
            </div>
        </div>

        <!-- Present and Absent Employees -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Present Employees Card -->
            <div class="bg-white p-6 rounded shadow">
                <i class="fas fa-user-check fa-2x text-orange-500 mb-2"></i>
                <h2 class="text-xl font-semibold mb-4">Present Employees</h2>
                <ul class="text-sm">
                    @foreach ($presentEmployees as $attendance)
                        <li class="mb-2">{{ $attendance->employee->name }} <span class="text-gray-500">(Checked in on {{ \Carbon\Carbon::parse($attendance->attendance_date)->format('D M Y') }})</span></li>
                    @endforeach
                </ul>
            </div>

            <!-- Absent Employees Card -->
            <div class="bg-white p-6 rounded shadow">
                <i class="fas fa-user-times fa-2x text-orange-500 mb-2"></i>
                <h2 class="text-xl font-semibold mb-4">Absent Employees</h2>
                <ul class="text-sm">
                    @foreach ($absentEmployees as $attendance)
                        <li class="mb-2">{{ $attendance->employee->name }} <span class="text-gray-500">(Absent on {{ \Carbon\Carbon::parse($attendance->attendance_date)->format('D M Y') }})</span></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Log Table -->
        <div class="mt-8">
            <h2 class="text-xl font-bold mb-4">Daily Logs</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg shadow">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-2 px-4 text-left">#</th>
                            <th class="py-2 px-4 text-left">Date</th>
                            <th class="py-2 px-4 text-left">Punch In</th>
                            <th class="py-2 px-4 text-left">Punch Out</th>
                            <th class="py-2 px-4 text-left">Total Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-t">
                            <td class="py-2 px-4">1</td>
                            <td class="py-2 px-4">Tue Jul 2024</td>
                            <td class="py-2 px-4">15 PM</td>
                            <td class="py-2 px-4">15 PM</td>
                            <td class="py-2 px-4">0</td>
                        </tr>
                        <tr class="border-t">
                            <td class="py-2 px-4">2</td>
                            <td class="py-2 px-4">Tue Jul 2024</td>
                            <td class="py-2 px-4">16 PM</td>
                            <td class="py-2 px-4"></td>
                            <td class="py-2 px-4">0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
