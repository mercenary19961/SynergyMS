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
            <livewire:summary-card 
                title="Total Employees" 
                icon="fas fa-users" 
                route="{{ route('admin.employees.index') }}" 
                countType="employees" 
            />

            <!-- Clients Card -->
            <livewire:summary-card 
                title="Total Clients" 
                icon="fas fa-handshake" 
                route="{{ route('admin.clients.index') }}" 
                countType="clients" 
            />

            <!-- Projects Card -->
            <livewire:summary-card 
                title="Total Projects" 
                icon="fas fa-briefcase" 
                route="{{ route('admin.projects.index') }}" 
                countType="projects" 
            />

            <!-- Tickets Card -->
            <livewire:summary-card 
                title="Total Tickets" 
                icon="fas fa-ticket-alt" 
                route="{{ route('admin.tickets.index') }}" 
                countType="tickets" 
            />
        </div>

        <!-- Recent Employees, Clients, and Projects -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <livewire:recent-employees />
            <livewire:recent-clients />
            <livewire:recent-projects />
        </div>

        <!-- Present and Absent Employees -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Present Employees Card -->
            <livewire:present-employees />

            <!-- Absent Employees Card -->
            <livewire:absent-employees />
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

