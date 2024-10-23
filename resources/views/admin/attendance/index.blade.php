@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Main Content -->
    <div class="flex-1 p-0 lg:p-6 bg-gray-100">
        @include('components.form.success')

        <!-- Header Row -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold">
                <i class="fas fa-calendar-check mr-2 text-gray-600"></i> Attendance Records
            </h1>
            @role('Super Admin|HR')
            <a href="{{ route('admin.attendance.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">
                <i class="fas fa-plus mr-2"></i>Add New Attendance
            </a>
            @endrole
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.attendance.index') }}" class="mb-4">
            <div class="grid grid-cols-2 lg:grid-cols-6 gap-2 mb-4">

                <!-- Employee ID Field -->
                <div class="lg:col-span-1">
                    <label for="employee_id" class="block text-xs font-medium text-gray-700">
                        <i class="fas fa-id-badge mr-1 text-gray-600"></i> Employee ID
                    </label>
                    <input type="number" name="employee_id" id="employee_id" value="{{ request('employee_id') }}" placeholder="Employee ID" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-1.5">
                </div>

                <!-- Employee Name Field -->
                <div class="lg:col-span-1">
                    <label for="employee_name" class="block text-xs font-medium text-gray-700">
                        <i class="fas fa-user mr-1 text-gray-600"></i> Employee Name
                    </label>
                    <input type="text" name="employee_name" id="employee_name" value="{{ request('employee_name') }}" placeholder="Employee Name" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-1.5">
                </div>

                <!-- Status Field with Dropdown -->
                <div class="lg:col-span-1 relative" x-data="{ selected: '{{ request('status', 'Select Status') }}', open: false }">
                    <label for="status" class="block text-xs font-medium text-gray-700">
                        <i class="fas fa-info-circle mr-1 text-gray-600"></i> Status
                    </label>
                    <button type="button" @click="open = !open" class="mt-1 block w-full bg-white border border-gray-300 focus:ring-orange-500 focus:border-orange-500 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none">
                        <span x-text="selected" class="block truncate"></span>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                            <i class="fas fa-chevron-down fa-xs text-gray-400"></i>
                        </span>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute mt-1 w-full bg-white rounded-md shadow-lg z-10" x-cloak>
                        <ul class="py-1" role="listbox">
                            <li @click="selected = 'Select Status'; open = false" class="group cursor-pointer hover:bg-orange-500 hover:text-white px-4 py-2">
                                <i class="fas fa-clipboard-list mr-2 text-orange-500 group-hover:text-white"></i> Select Status
                            </li>
                            <li @click="selected = 'Present'; open = false" class="group cursor-pointer hover:bg-orange-500 hover:text-white px-4 py-2">
                                <i class="fas fa-user-check mr-2 text-orange-500 group-hover:text-white"></i> Present
                            </li>
                            <li @click="selected = 'Absent'; open = false" class="group cursor-pointer hover:bg-orange-500 hover:text-white px-4 py-2">
                                <i class="fas fa-user-times mr-2 text-orange-500 group-hover:text-white"></i> Absent
                            </li>
                            <li @click="selected = 'Sick Leave'; open = false" class="group cursor-pointer hover:bg-orange-500 hover:text-white px-4 py-2">
                                <i class="fas fa-notes-medical mr-2 text-orange-500 group-hover:text-white"></i> Sick Leave
                            </li>
                            <li @click="selected = 'Hourly Leave'; open = false" class="group cursor-pointer hover:bg-orange-500 hover:text-white px-4 py-2">
                                <i class="fas fa-clock mr-2 text-orange-500 group-hover:text-white"></i> Hourly Leave
                            </li>
                            <li @click="selected = 'Annual Leave'; open = false" class="group cursor-pointer hover:bg-orange-500 hover:text-white px-4 py-2">
                                <i class="fas fa-plane-departure mr-2 text-orange-500 group-hover:text-white"></i> Annual Leave
                            </li>
                        </ul>
                    </div>
                    <input type="hidden" name="status" :value="selected === 'Select Status' ? '' : selected">
                </div>

                <!-- Attendance Date Field -->
                <div class="lg:col-span-1">
                    <label for="attendance_date" class="block text-xs font-medium text-gray-700">
                        <i class="fas fa-calendar-alt mr-1 text-gray-600"></i> Attendance Date
                    </label>
                    <input type="date" name="attendance_date" id="attendance_date" value="{{ request('attendance_date') }}" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-1.5">
                </div>

                <!-- Search Button -->
                <div class="flex items-end">
                    <button type="submit" class="w-full lg:w-full lg:h-auto bg-green-500 text-white text-sm px-4 py-2 rounded hover:bg-green-600 transition flex items-center justify-center">
                        <i class="fas fa-search mr-1"></i> Search
                    </button>
                </div>

                <!-- Clear Button -->
                <div class="lg:col-span-1 flex items-end">
                    <a href="{{ route('admin.attendance.index') }}" class="w-full lg:w-full lg:h-auto bg-gray-500 text-white text-sm px-4 py-2 rounded hover:bg-gray-600 transition flex items-center justify-center">
                        <i class="fas fa-times mr-2"></i> Clear
                    </a>
                </div>
            </div>
        </form>

        <!-- Attendance Table -->
        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-200 uppercase text-[10px] sm:text-[10px] leading-tight text-gray-600">
                    <tr>
                        <th class="py-3 sm:py-4 px-2 sm:px-4 text-left">
                            <i class="fas fa-hashtag"></i> Employee ID
                        </th>
                        <th class="py-3 sm:py-4 px-2 sm:px-4 text-left">
                            <i class="fas fa-user mr-1"></i> Employee Name
                        </th>
                        <th class="hidden md:table-cell py-3 sm:py-4 px-2 sm:px-4 text-left">
                            <i class="fas fa-briefcase mr-1"></i> Project Manager
                        </th>
                        <th class="py-3 sm:py-4 px-2 sm:px-4 text-left">
                            <i class="fas fa-calendar-alt mr-1"></i> Attendance Date
                        </th>
                        <th class="hidden lg:table-cell py-3 sm:py-4 px-2 sm:px-4 text-left">
                            <i class="fas fa-clock mr-1"></i> Clock In
                        </th>
                        <th class="hidden lg:table-cell py-3 sm:py-4 px-2 sm:px-4 text-left">
                            <i class="fas fa-clock mr-1"></i> Clock Out
                        </th>
                        <th class="hidden xl:table-cell py-3 sm:py-4 px-2 sm:px-4 text-left">
                            <i class="fas fa-hourglass-half mr-1"></i> Total Hours
                        </th>
                        <th class="py-3 sm:py-4 px-2 sm:px-4 text-left">
                            <i class="fas fa-info-circle mr-1"></i> Status
                        </th>
                        <th class="py-3 sm:py-4 px-2 sm:px-4 text-center">
                            <i class="fas fa-tools mr-1"></i> Actions
                        </th>
                    </tr>
                </thead>
                
                
                <tbody class="text-black text-xs sm:text-xs font-normal">
                    @foreach($attendances as $attendance)
                        <tr class="border-b border-gray-200 hover:bg-gray-100 {{ $loop->iteration % 2 == 0 ? 'bg-gray-200' : '' }}">
                            <td class="py-2 sm:py-3 px-4 sm:px-6">
                                {{ $attendance->employee ? $attendance->employee->id : 'N/A' }} <!-- Employee ID -->
                            </td>
                            <td class="py-2 sm:py-3 px-4 sm:px-6">
                                {{ $attendance->employee && $attendance->employee->user ? $attendance->employee->user->name : 'N/A' }}
                            </td>
                            <td class="hidden md:table-cell py-2 sm:py-3 px-4 sm:px-6">
                                {{ $attendance->employee && $attendance->employee->projectManager && $attendance->employee->projectManager->user ? $attendance->employee->projectManager->user->name : 'N/A' }}
                            </td>
                            <td class="py-2 sm:py-3 px-4 sm:px-6">{{ $attendance->attendance_date }}</td>
                            <td class="hidden lg:table-cell py-2 sm:py-3 px-4 sm:px-6">{{ $attendance->clock_in ?? 'N/A' }} </td>
                            <td class="hidden lg:table-cell py-2 sm:py-3 px-4 sm:px-6">{{ $attendance->clock_out ?? 'N/A' }}</td>
                            <td class="hidden xl:table-cell py-2 sm:py-3 px-4 sm:px-6">{{ $attendance->total_hours ?? 'N/A' }}</td>
                            <td class="py-2 sm:py-3 px-4 sm:px-6">{{ $attendance->status }}</td>
                            <td class="py-2 sm:py-3 px-4 sm:px-6 flex space-x-4">
                                <a href="{{ route('admin.attendance.show', $attendance->id) }}" class="transform hover:text-blue-500 hover:scale-110">
                                    <i class="fas fa-eye text-orange-500 hover:text-blue-500"></i>
                                </a>
                                @role('Admin|Super Admin|HR')
                                <a href="{{ route('admin.attendance.edit', $attendance->id) }}" class="transform hover:text-yellow-500 hover:scale-110">
                                    <i class="fas fa-pen text-orange-500 hover:text-yellow-500"></i>
                                </a>
                                <form id="delete-form-{{ $attendance->id }}" action="{{ route('admin.attendance.destroy', $attendance->id) }}" method="POST" class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <x-delete-button formId="delete-form-{{ $attendance->id }}" />
                                </form>
                                @endrole
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>

        <x-pagination>
            {{ $attendances->appends(request()->query())->links('pagination::tailwind') }}
        </x-pagination>
        
    </div>
</div>
@endsection
