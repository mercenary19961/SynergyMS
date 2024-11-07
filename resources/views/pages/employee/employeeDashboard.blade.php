@extends('layouts.app')

@section('content')
<div class="flex flex-col h-screen">
    <div class="flex-1 p-2 lg:p-6 bg-gray-100">
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

        <!-- Employee's Assigned Projects and Tasks in one row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Left Side: Carousel of Assigned Components -->
            <div x-data="{ currentTab: 0, intervalId: null }" x-init="intervalId = setInterval(() => { currentTab = (currentTab + 1) % 3 }, 12000)">
                <template x-if="currentTab === 0">
                    <livewire:assigned-tasks />
                </template>
                <template x-if="currentTab === 1">
                    <livewire:assigned-projects />
                </template>
                <template x-if="currentTab === 2">
                    <livewire:assigned-tickets />
                </template>
        
                <!-- Pagination Dots -->
                <div class="flex justify-center space-x-2 mt-4">
                    <button @click="currentTab = 0" :class="{ 'bg-orange-500': currentTab === 0, 'bg-gray-300': currentTab !== 0 }" class="h-2 w-2 rounded-full"></button>
                    <button @click="currentTab = 1" :class="{ 'bg-orange-500': currentTab === 1, 'bg-gray-300': currentTab !== 1 }" class="h-2 w-2 rounded-full"></button>
                    <button @click="currentTab = 2" :class="{ 'bg-orange-500': currentTab === 2, 'bg-gray-300': currentTab !== 2 }" class="h-2 w-2 rounded-full"></button>
                </div>
            </div>
        
            <!-- Right Side: Calendar Component -->
            <div>
                <livewire:calendar />
            </div>
        </div>
        
    </div>
    <x-footer />
</div>
<script>
    // Function to scroll left
    function scrollLeft(containerId) {
        const container = document.getElementById(containerId);
        container.scrollBy({ left: -200, behavior: 'smooth' });
    }

    // Function to scroll right
    function scrollRight(containerId) {
        const container = document.getElementById(containerId);
        container.scrollBy({ left: 200, behavior: 'smooth' });
    }
</script>

@endsection
