@extends('layouts.app')

@section('content')
<div class="flex flex-col h-screen">
    <div class="flex-1 p-0 lg:p-6 bg-gray-100">
        @include('components.form.success')

        <div class="flex items-center justify-between mb-4 p-1">
            <h1 class="text-2xl font-semibold">
                <i class="fas fa-calendar-alt mr-2 text-gray-600"></i> Events
            </h1>
            
            @if(auth()->user()->hasRole('Super Admin|HR'))
            <a href="{{ route('admin.events.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition inline-flex items-center">
                <i class="fas fa-plus-circle mr-2"></i> Add New Event
            </a>
            @endif
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.events.index') }}" class="mb-6 p-1">
            <div class="flex flex-col md:flex-row md:items-end md:space-x-4 space-y-4 md:space-y-0">
                <!-- Event Name Field -->
                <div class="flex-1">
                    <label for="name" class="block text-sm font-medium text-gray-700 flex items-center">
                        <i class="fas fa-calendar-alt mr-2 text-gray-700"></i> Event Name
                    </label>
                    <input type="text" name="name" id="name" value="{{ request('name') }}" placeholder="Enter Event Name" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">
                </div>

                <!-- Sector Dropdown -->
                <div class="flex-1 relative" x-data="{ open: false, selected: '{{ request('target_role') ? ucfirst(request('target_role')) : 'Select Sector' }}' }">
                    <label for="target_role" class="block text-sm font-medium text-gray-700 flex items-center">
                        <i class="fas fa-user-tag mr-2 text-gray-700"></i> Sector
                    </label>
                    <button 
                        @click="open = !open" 
                        type="button" 
                        class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500"
                    >
                        <span x-text="selected" class="block truncate"></span>
                        <span class="absolute inset-y-11 right-0 flex items-center pr-2 pointer-events-none">
                            <i class="fas fa-chevron-down fa-xs text-gray-500"></i>
                        </span>
                    </button>

                    <ul 
                        x-show="open" 
                        @click.away="open = false" 
                        class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                    >
                        <li 
                            @click="selected = 'Select Sector'; open = false; $refs.target_role.value = ''" 
                            class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center"
                        >
                            <i class="fas fa-user-tag mr-2 text-orange-500 group-hover:text-white"></i> Select Sector
                        </li>

                        <!-- Dynamic roles including General -->
                        @foreach($roles as $role)
                            <li 
                                @click="selected = '{{ ucfirst($role) }}'; open = false; $refs.target_role.value = '{{ $role }}'" 
                                class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center"
                            >
                                <i class="fas fa-user-tag mr-2 text-orange-500 group-hover:text-white"></i> {{ ucfirst($role) }}
                            </li>
                        @endforeach
                    </ul>

                    <input type="hidden" name="target_role" x-ref="target_role" value="{{ request('target_role') }}">
                </div>

                <!-- Search and Clear Buttons -->
                <div class="flex-shrink-0 flex space-x-2">
                    <button type="submit" class="w-full md:w-auto bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                        <i class="fas fa-search mr-2"></i> Search
                    </button>

                    <a href="{{ route('admin.events.index') }}" class="w-full md:w-auto bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition flex items-center justify-center">
                        <i class="fas fa-times mr-2"></i> Clear
                    </a>
                </div>
            </div>
        </form>

        <!-- Event Table -->
        <div class="overflow-x-auto mt-4 p-1">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead class="bg-gray-100 text-left text-gray-600 uppercase text-xs leading-normal">
                    <tr>
                        <th class="py-2 px-4"><i class="fas fa-hashtag"></i></th>
                        <th class="py-2 px-4"><i class="fas fa-calendar-alt"></i> Event Name</th>
                        <th class="py-2 px-4 hidden lg:table-cell"><i class="fas fa-user-tag"></i> Sector</th>
                        <th class="py-2 px-4 "><i class="fas fa-clock"></i> Start Date</th>
                        <th class="py-2 px-4 hidden lg:table-cell"><i class="fas fa-clock"></i> End Date</th>
                        <th class="py-2 px-4"><i class="fas fa-tools"></i> Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-xs sm:text-sm">
                    @foreach($events as $index => $event)
                        <tr class="{{ $index % 2 == 1 ? 'bg-gray-100' : 'bg-white' }} border-t">
                            <td class="py-3 px-4">{{ $event->id }}</td>
                            <td class="py-3 px-4">{{ $event->name }}</td>
                            <td class="py-3 px-4 hidden lg:table-cell">
                                @if($event->is_general)
                                    General
                                @elseif($event->target_role)
                                    {{ ucfirst($event->target_role) }}
                                @elseif($event->department)
                                    {{ $event->department->name }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="py-3 px-4 ">
                                {{ \Carbon\Carbon::parse($event->start_date)->format('M d, H:i') }}
                            </td>
                            <td class="py-3 px-4 hidden lg:table-cell">
                                {{ $event->end_date ? \Carbon\Carbon::parse($event->end_date)->format('M d, H:i') : '-' }}
                            </td>
                            @php
                                $user = auth()->user();
                                $userDepartmentId = $user->employeeDetail ? $user->employeeDetail->department_id : ($user->humanResource ? $user->humanResource->department_id : null);
                                $isSuperAdminOrHR = $user->hasRole(['Super Admin', 'HR']);
                                $isSameDepartment = $event->target_department_id && $event->target_department_id === $userDepartmentId;
                                $isSameRole = $event->target_role && $user->hasRole($event->target_role);
                                $isGeneralEvent = $event->is_general;
                            @endphp
                            <td class="py-3 px-4 flex space-x-4">
                                <!-- Show Button -->
                                @if($isSuperAdminOrHR || $isGeneralEvent || $isSameDepartment || $isSameRole)
                                    <a href="{{ route('admin.events.show', $event->id) }}" class="transform hover:text-blue-500 hover:scale-110">
                                        <i class="fas fa-eye fa-md text-orange-500 hover:text-blue-500"></i>
                                    </a>
                                @endif
                            </td>
                                <!-- Edit and Delete Buttons for Super Admin and HR only -->
                                @if($isSuperAdminOrHR)
                                    <a href="{{ route('admin.events.edit', $event->id) }}" class="transform hover:text-orange-500 hover:scale-110">
                                        <i class="fas fa-pen fa-md text-orange-500 hover:text-yellow-500"></i>
                                    </a>
                                    <form id="delete-form-{{ $event->id }}" action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <x-delete-button formId="delete-form-{{ $event->id }}" />
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <x-pagination>
            {{ $events->appends(request()->query())->links('pagination::tailwind') }}
        </x-pagination>
    </div>
    <x-footer />
</div>
@endsection
