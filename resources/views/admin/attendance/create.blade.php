@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    @include('partials.sidebar')

    <div class="flex-1 p-6 bg-gray-100">
        <!-- Error Handling -->
        @include('components.form.errors')

        <x-title-with-back title="Create Attendance Record" route="admin.attendance.index" />

        <!-- Form -->
        <form method="POST" action="{{ route('admin.attendance.store') }}" class="space-y-4">
            @csrf

            <div class="flex flex-col md:flex-row md:space-x-4">
                <!-- Employee Dropdown -->
                <div x-data="{ open: false, selected: '{{ old('employee_id') ?? 'Select Employee' }}' }" class="relative md:w-1/2">
                    <label for="employee_id" class="block text-sm font-medium text-gray-700">Employee</label>
                    <button @click="open = !open" type="button" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <span x-text="selected"></span>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                            <i class="fas fa-chevron-down text-orange-500 group-hover:text-white"></i>
                        </span>
                    </button>
                    <ul x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none">
                        @foreach($employees as $employee)
                            <li @click="selected = '{{ $employee->user->name }}'; $refs.employee_id.value = '{{ $employee->id }}'; open = false" class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">
                                <span class="flex items-center">
                                    <i class="fas fa-user mr-2 text-orange-500 group-hover:text-white"></i> {{ $employee->user->name }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="employee_id" x-ref="employee_id" :value="selected === 'Select Employee' ? '' : selected">
                </div>
            
                <!-- Project Manager Dropdown -->
                <div x-data="{ open: false, selected: '{{ old('project_manager_id') ?? 'Select Project Manager' }}' }" class="relative md:w-1/2">
                    <label for="project_manager_id" class="block text-sm font-medium text-gray-700">Project Manager</label>
                    <button @click="open = !open" type="button" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <span x-text="selected"></span>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                            <i class="fas fa-chevron-down text-orange-500 group-hover:text-white"></i>
                        </span>
                    </button>
                    <ul x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none">
                        @foreach($projectManagers as $manager)
                            <li @click="selected = '{{ $manager->user->name }}'; $refs.project_manager_id.value = '{{ $manager->id }}'; open = false" class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">
                                <span class="flex items-center">
                                    <i class="fas fa-user-tie mr-2 text-orange-500 group-hover:text-white"></i> {{ $manager->user->name }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="project_manager_id" x-ref="project_manager_id" :value="selected === 'Select Project Manager' ? '' : selected">
                </div>
            </div>

            <!-- Status Dropdown -->
            <div class="flex flex-col md:flex-row md:space-x-4">
                <div x-data="{ open: false, selected: '{{ old('status') ?? 'Present' }}' }" class="md:w-1/2 relative">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <button @click="open = !open" type="button" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <span x-text="selected"></span>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                            <i class="fas fa-chevron-down text-orange-500 group-hover:text-white"></i>
                        </span>
                    </button>
                    <ul x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none">
                        <li @click="selected = 'Present'; $refs.status.value = 'present'; open = false" class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">
                            <span class="flex items-center">
                                <i class="fas fa-check-circle mr-2 text-orange-500 group-hover:text-white"></i> Present
                            </span>
                        </li>
                        <li @click="selected = 'Hourly Leave'; $refs.status.value = 'hourly_leave'; open = false" class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">
                            <span class="flex items-center">
                                <i class="fas fa-clock mr-2 text-orange-500 group-hover:text-white"></i> Hourly Leave
                            </span>
                        </li>
                        <li @click="selected = 'Annual Leave'; $refs.status.value = 'annual_leave'; open = false" class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">
                            <span class="flex items-center">
                                <i class="fas fa-calendar-alt mr-2 text-orange-500 group-hover:text-white"></i> Annual Leave
                            </span>
                        </li>
                        <li @click="selected = 'Sick Leave'; $refs.status.value = 'sick_leave'; open = false" class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">
                            <span class="flex items-center">
                                <i class="fas fa-medkit mr-2 text-orange-500 group-hover:text-white"></i> Sick Leave
                            </span>
                        </li>
                        <li @click="selected = 'Absent'; $refs.status.value = 'absent'; open = false" class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">
                            <span class="flex items-center">
                                <i class="fas fa-times-circle mr-2 text-orange-500 group-hover:text-white"></i> Absent
                            </span>
                        </li>
                    </ul>
                    <input type="hidden" name="status" x-ref="status" :value="selected === 'Present' ? '' : selected">
                </div>

                <div class="md:w-1/2">
                    <label for="attendance_date" class="block text-sm font-medium text-gray-700">Attendance Date</label>
                    <input type="date" name="attendance_date" id="attendance_date" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">
                </div>
            </div>
                
            <!-- Clock In -->
            <div class="flex flex-col md:flex-row md:space-x-4">
                <div class="md:w-1/2">
                    <label for="clock_in" class="block text-sm font-medium text-gray-700">Clock In</label>
                    <input type="time" name="clock_in" id="clock_in" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">
                </div>

                <!-- Clock Out and Total Hours -->
                <div class="md:w-1/2">
                    <label for="clock_out" class="block text-sm font-medium text-gray-700">Clock Out</label>
                    <input type="time" name="clock_out" id="clock_out" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">
                </div>
            </div>

            <div class="flex flex-col md:flex-row md:space-x-4">
                <div class="md:w-1/2">
                    <label for="total_hours" class="block text-sm font-medium text-gray-700">Total Hours</label>
                    <input type="number" name="total_hours" id="total_hours" placeholder="e.g., 8" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">
                </div>

                <div class="md:w-1/2">
                    <label for="leave_hours" class="block text-sm font-medium text-gray-700">Leave Hours</label>
                    <input type="number" name="leave_hours" id="leave_hours" placeholder="e.g., 2" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">
                </div>
            </div>

            <x-form.button-submit label="Creae Attendance" />
        </form>
    </div>
</div>
@endsection
