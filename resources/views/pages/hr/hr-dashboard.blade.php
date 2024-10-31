@extends('layouts.app')

@section('content')
<div class="flex flex-col h-screen">
    <div class="flex-1 bg-gray-100">
        <div x-data="{ showEmployeeModal: false, showTicketModal: false }">
            
            <!-- Dashboard Title with Buttons -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 p-2 lg:p-6 space-y-4 md:space-y-0">
                <!-- Left Side: Welcome Message -->
                <div>
                    <h1 class="text-2xl md:text-3xl font-semibold flex items-center text-gray-700">
                        <i class="fas fa-users-cog mr-2 text-gray-700"></i> Welcome, {{ Auth::user()->name }}!
                    </h1>
                    <p class="text-xl md:text-2xl font-semibold bg-clip-text text-transparent bg-gradient-to-r from-pink-600 to-orange-500 mt-2 ml-4 md:ml-9">
                        Let's Build a Better Workplace Together
                    </p>
                </div>

                <!-- Right Side: New Employee and New Ticket Buttons -->
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 w-full md:w-auto">
                    <!-- New Employee Button -->
                    <a href="{{ route('admin.employees.create') }}" class="bg-blue-500 text-white text-sm md:text-base px-4 py-2 rounded hover:bg-blue-600 transition inline-flex items-center justify-center w-full md:w-auto">
                        <i class="fas fa-user-plus mr-2"></i> New Employee?
                    </a>

                    <!-- New Ticket Button -->
                    <button @click="showTicketModal = true" class="bg-green-500 text-white text-sm md:text-base px-4 py-2 rounded hover:bg-green-600 transition inline-flex items-center justify-center w-full md:w-auto">
                        <i class="fas fa-ticket-alt mr-2"></i> New Ticket?
                    </button>
                </div>
            </div>

            <!-- Summary Cards (Employees, Tickets, Projects, Notifications) -->
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

                <!-- Project Managers Card -->
                <livewire:summary-card 
                    title="Total Project Managers" 
                    icon="fas fa-user-tie" 
                    route="{{ route('admin.project-managers.index') }}" 
                    countType="project_managers" 
                />

                <!-- Today's Clock-ins Card -->
                <livewire:summary-card 
                    title="Today's Clock-ins" 
                    icon="fas fa-clock" 
                    route="{{  route('admin.attendance.index') }}" 
                    countType="today_clockins" 
                />
            </div>

            <!-- Grid Layout for Detailed Sections -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-2 lg:p-6">
                <!-- Employees Section -->
                <div class="mb-4">
                    <h2 class="text-xl font-semibold mb-4 text-orange-500 flex items-center">
                        <i class="fas fa-users mr-2"></i> Employees Overview
                    </h2>
                    <livewire:recent-employees />
                </div>

                <!-- Tickets Section -->
                {{-- <div class="col-span-1 bg-white shadow rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4 text-orange-500 flex items-center">
                        <i class="fas fa-ticket-alt mr-2"></i> Open Tickets
                    </h2>
                    <livewire:recent-tickets />
                </div> --}}

                <!-- Notifications Section -->
                {{-- <div class="col-span-2 lg:col-span-1 bg-white shadow rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4 text-orange-500 flex items-center">
                        <i class="fas fa-bell mr-2"></i> Notifications
                    </h2>
                    <livewire:recent-notifications />
                </div> --}}
            </div>
        </div>
    </div>
    <x-footer />
</div>
@endsection
