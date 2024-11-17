@extends('layouts.app')

@section('content')
<div class="flex flex-col h-screen">
    <div class="flex-1 bg-gray-100">
        <div x-data="{ showEmployeeModal: false, showTicketModal: false }">
            
            <!-- Dashboard Title with Buttons -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-1 p-2 lg:pt-6 lg:pr-6 lg:pl-6 lg:pb-1 space-y-4 md:space-y-0">
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
                    <a href="{{ route('admin.employees.index') }}" class="bg-pink-600 text-white text-sm md:text-base px-4 py-2 rounded hover:bg-pink-700 transition inline-flex items-center justify-center w-full md:w-auto">
                        <i class="fas fa-user mr-2"></i> Check Employees
                    </a>

                    <!-- New Ticket Button -->
                    <a href="{{ route('admin.tickets.index') }}" class="bg-green-500 text-white text-sm md:text-base px-4 py-2 rounded hover:bg-green-600 transition inline-flex items-center justify-center w-full md:w-auto">
                        <i class="fas fa-ticket-alt mr-2"></i> New Ticket
                    </a>

                </div>
            </div>

            <!-- Summary Cards (Employees, Tickets, Projects, Notifications) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-1 p-2 md:pt-2 md:pr-6 md:pb-2 md:pl-6 ">
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
                <livewire:events />
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6 p-2 md:pt-2 md:pr-6 md:pb-2 md:pl-6">
                <!-- Left Side: Recent Components with Carousel -->
                <div x-data="{ currentTab: 0, intervalId: null }" x-init="intervalId = setInterval(() => { currentTab = (currentTab + 1) % 3 }, 10000)" class="">
                    <template x-if="currentTab === 0">
                        <livewire:recent-employees />
                    </template>
                    <template x-if="currentTab === 1">
                        <livewire:recent-clients />
                    </template>
                    <template x-if="currentTab === 2">
                        <livewire:recent-projects />
                    </template>
                    
                    <!-- Pagination Dots -->
                    <div class="flex justify-center space-x-2 mt-4">
                        <button @click="currentTab = 0" :class="{'bg-orange-500': currentTab === 0, 'bg-gray-300': currentTab !== 0}" class="h-2 w-2 rounded-full"></button>
                        <button @click="currentTab = 1" :class="{'bg-orange-500': currentTab === 1, 'bg-gray-300': currentTab !== 1}" class="h-2 w-2 rounded-full"></button>
                        <button @click="currentTab = 2" :class="{'bg-orange-500': currentTab === 2, 'bg-gray-300': currentTab !== 2}" class="h-2 w-2 rounded-full"></button>
                    </div>
                </div>
            
                <!-- Right Side: Calendar Component -->
                <div>
                    <livewire:calendar />
                </div>
            </div>

            <!-- Present and Absent Employees -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6 p-2 md:pt-2 md:pr-6 md:pb-2 md:pl-6">
                <livewire:present-employees />
                <livewire:absent-employees />
            </div>
        </div>
    </div>
    <x-footer />
</div>
@endsection
