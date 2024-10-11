@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">
        @include('components.form.success')

        <!-- Header Row -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold flex items-center">
                <i class="fas fa-ticket-alt mr-2 text-gray-600"></i> Tickets
            </h1>
            <a href="{{ route('admin.tickets.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition inline-flex items-center">
                <i class="fas fa-plus mr-2"></i> Add New Ticket
            </a>
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.tickets.index') }}" class="mb-6">
            <div class="flex flex-col md:flex-row md:items-end md:space-x-4 space-y-4 md:space-y-0">
                <!-- Title Field -->
                <div class="flex-1">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" value="{{ request('title') }}" placeholder="Ticket Title" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">
                </div>

                <!-- Status Dropdown -->
                <div class="flex-1">
                    <div x-data="{ open: false, selected: '{{ request('status') ?? 'Select Status' }}' }" class="relative">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <button @click="open = !open" type="button" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                            <span class="block truncate" x-text="selected"></span>
                            <span class="flex items-center">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a 1 1 0 01-1.414 0l-4-4a 1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>

                        <!-- Dropdown Menu -->
                        <ul x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm" role="listbox" x-transition x-cloak>
                            <li @click="selected = 'Select Status'; open = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center group">
                                <i class="fas fa-circle-notch mr-2 text-orange-500 group-hover:text-white"></i> Select Status
                            </li>
                            <li @click="selected = 'Open'; open = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center group">
                                <i class="fas fa-circle-notch mr-2 text-orange-500 group-hover:text-white"></i> Open
                            </li>
                            <li @click="selected = 'In Progress'; open = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center group">
                                <i class="fas fa-spinner mr-2 text-orange-500 group-hover:text-white"></i> In Progress
                            </li>
                            <li @click="selected = 'Closed'; open = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center group">
                                <i class="fas fa-check mr-2 text-orange-500 group-hover:text-white"></i> Closed
                            </li>
                            <li @click="selected = 'Confirmed'; open = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center group">
                                <i class="fas fa-check-double mr-2 text-orange-500 group-hover:text-white"></i> Confirmed
                            </li>
                        </ul>

                        <!-- Hidden Input to Submit the Selected Value -->
                        <input type="hidden" name="status" :value="selected === 'Select Status' ? '' : selected">
                    </div>
                </div>

                <!-- Priority Dropdown -->
                <div class="flex-1">
                    <div x-data="{ open: false, selected: '{{ request('priority') ?? 'Select Priority' }}' }" class="relative">
                        <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                        <button @click="open = !open" type="button" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                            <span class="block truncate" x-text="selected"></span>
                            <span class="flex items-center">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a 1 1 0 01-1.414 0l-4-4a 1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>

                        <!-- Dropdown Menu -->
                        <ul x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm" role="listbox" x-transition x-cloak>
                            <li @click="selected = 'Select Priority'; open = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center group">
                                <i class="fas fa-exclamation-triangle mr-2 text-orange-500 group-hover:text-white"></i> Select Priority
                            </li>
                            <li @click="selected = 'Low'; open = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center group">
                                <i class="fas fa-exclamation-circle mr-2 text-orange-500 group-hover:text-white"></i> Low
                            </li>
                            <li @click="selected = 'Medium'; open = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center group">
                                <i class="fas fa-exclamation mr-2 text-orange-500 group-hover:text-white"></i> Medium
                            </li>
                            <li @click="selected = 'High'; open = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center group">
                                <i class="fas fa-exclamation-triangle mr-2 text-orange-500 group-hover:text-white"></i> High
                            </li>
                        </ul>

                        <!-- Hidden Input to Submit the Selected Value -->
                        <input type="hidden" name="priority" :value="selected === 'Select Priority' ? '' : selected">
                    </div>
                </div>

                <!-- Employee Dropdown -->
                <div class="flex-1">
                    <div x-data="{ open: false, selected: '{{ request('employee') ?? 'Select Employee' }}' }" class="relative">
                        <label for="employee" class="block text-sm font-medium text-gray-700">Employee</label>
                        <button @click="open = !open" type="button" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                            <span class="block truncate" x-text="selected"></span>
                            <span class="flex items-center">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a 1 1 0 01-1.414 0l-4-4a 1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>

                        <!-- Dropdown Menu -->
                        <ul x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm" role="listbox" x-transition x-cloak>
                            <li @click="selected = 'Select Employee'; open = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center group">
                                <i class="fas fa-user mr-2 text-orange-500 group-hover:text-white"></i> Select Employee
                            </li>
                            @foreach($employees as $employee)
                                <li @click="selected = '{{ $employee->user->name }}'; open = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center group">
                                    <i class="fas fa-user mr-2 text-orange-500 group-hover:text-white"></i> {{ $employee->user->name }}
                                </li>
                            @endforeach
                        </ul>

                        <!-- Hidden Input to Submit the Selected Value -->
                        <input type="hidden" name="employee" :value="selected === 'Select Employee' ? '' : selected">
                    </div>
                </div>

                <!-- Search and Clear Buttons -->
                <div class="flex-shrink-0 flex space-x-2">
                    <button type="submit" class="w-full md:w-auto bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition flex items-center">
                        <i class="fas fa-search mr-2"></i> Search
                    </button>

                    <a href="{{ route('admin.tickets.index') }}" class="w-full md:w-auto bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition flex items-center justify-center">
                        <i class="fas fa-times mr-2"></i> Clear
                    </a>
                </div>
            </div>
        </form>

        <!-- Tickets Table -->
        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100 text-left text-gray-600 uppercase text-xs leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left"><i class="fas fa-hashtag mr-2"></i></th>
                        <th class="py-3 px-6 text-left"><i class="fas fa-file-alt mr-2"></i>Title</th>
                        <th class="py-3 px-6 text-left"><i class="fas fa-tasks mr-2"></i>Status</th>
                        <th class="py-3 px-6 text-left"><i class="fas fa-exclamation-triangle mr-2"></i>Priority</th>
                        <th class="py-3 px-6 text-left"><i class="fas fa-user mr-2"></i>Employee</th>
                        <th class="py-3 px-6 text-left"><i class="fas fa-user-tie mr-2"></i>Project Manager</th>
                        <th class="py-3 px-6 text-center"><i class="fas fa-cogs mr-2"></i>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-black text-sm font-normal">
                    @foreach($tickets as $ticket)
                        <tr class="border-b border-gray-200 hover:bg-gray-100 {{ $loop->iteration % 2 == 0 ? 'bg-gray-200' : '' }}">
                            <td class="py-3 px-6">{{ $ticket->id }}</td>
                            <td class="py-3 px-6">{{ $ticket->title }}</td>
                            <td class="py-3 px-6">{{ $ticket->status }}</td>
                            <td class="py-3 px-6">{{ $ticket->priority }}</td>
                            <td class="py-3 px-6">
                                @if($ticket->employee && $ticket->employee->user)
                                    {{ $ticket->employee->user->name }}
                                @else
                                    <span class="text-gray-500">Unassigned</span>
                                @endif
                            </td>
                            <td class="py-3 px-6">
                                @if($ticket->projectManager && $ticket->projectManager->user)
                                    {{ $ticket->projectManager->user->name }}
                                @else
                                    <span class="text-gray-500">Unknown</span>
                                @endif
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center space-x-4">
                                    <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="w-4 transform hover:text-blue-500 hover:scale-110">
                                        <i class="fas fa-eye fa-md text-orange-500 hover:text-blue-500"></i>
                                    </a>
                                    <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="w-4 transform hover:text-orange-500 hover:scale-110">
                                        <i class="fas fa-edit fa-md text-orange-500 hover:text-yellow-500"></i>
                                    </a>
                                    <form id="delete-form-{{ $ticket->id }}" action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <x-delete-button formId="delete-form-{{ $ticket->id }}" />
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <x-pagination>
            {{ $tickets->links('pagination::tailwind') }}
        </x-pagination>

    </div>
</div>

@endsection
