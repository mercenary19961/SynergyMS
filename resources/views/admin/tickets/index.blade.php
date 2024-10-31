@extends('layouts.app')

@section('content')
<div class="flex flex-col h-screen">
    <div class="flex-1 p-0 lg:p-6 bg-gray-100">
        @include('components.form.success')

        <div class="flex justify-between items-center mb-4 p-1">
            <h1 class="text-2xl font-semibold flex items-center">
                <i class="fas fa-ticket-alt mr-2 text-gray-600"></i> Tickets
            </h1>
            <div class="flex space-x-2">
                
                <div x-data="{ showModal: false }">

                    <!-- Quick Add Ticket Button -->
                    <button @click="showModal = true" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition inline-flex items-center">
                        <i class="fas fa-ticket-alt mr-2"></i> Quick Add Ticket
                    </button>
                    
                    <!-- Modal -->
                    <div x-show="showModal" class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                            <div class="inline-block bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <div class="sm:flex sm:items-start">
                                    <div class="text-center sm:text-left">
                                        <h3 class="text-lg font-medium text-gray-900" id="modal-title">Create a New Ticket</h3>
                                        <div class="mt-2">
                                            <!-- Form inside the modal with grid layout -->
                                            <form action="{{ route('admin.tickets.store') }}" method="POST">
                                                @csrf
                                                <div class="grid grid-cols-2 gap-4">
                                                    <!-- Priority Dropdown -->
                                                    <livewire:priority-dropdown />

                                                    <!-- Ticket Name Field -->
                                                    <div class="col-span-1 mb-4">
                                                        <label for="ticket_name" class="block text-sm font-bold text-gray-700">
                                                            <i class="fas fa-ticket-alt text-orange-500 mr-1"></i> Ticket Name
                                                        </label>
                                                        <input type="text" name="title" id="ticket_name" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" required>
                                                    </div>

                                                    <!-- Description Field (now spans 2 columns) -->
                                                    <div class="col-span-2 mb-4">
                                                        <label for="description" class="block text-sm font-bold text-gray-700">
                                                            <i class="fas fa-align-left text-orange-500 mr-1"></i> Description
                                                        </label>
                                                        <textarea name="description" id="description" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" required></textarea>
                                                    </div>
                                                </div>

                                                <!-- Automatically set the user_id of the ticket issuer -->
                                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                                                <!-- Submit and Cancel Buttons -->
                                                <div class="flex justify-end mt-4">
                                                    <button type="button" @click="showModal = false" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Cancel</button>
                                                    <button type="submit" class="ml-2 bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">Create Ticket</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Original Add Ticket Button -->
                    @role('Super Admin')
                    <a href="{{ route('admin.tickets.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition inline-flex items-center">
                        <i class="fas fa-plus mr-2"></i> Create New Ticket
                    </a>
                    @endrole
                </div>
            </div>
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.tickets.index') }}" class="mb-6 p-1">
            <div class="flex flex-col md:flex-row md:items-end md:space-x-4 space-y-4 md:space-y-0">
                <!-- Title Field -->
                <div class="flex-1">
                    <label for="title" class="block text-sm font-medium text-gray-700 flex items-center">
                        <i class="fas fa-ticket-alt mr-2 text-gray-700"></i> Title
                    </label>
                    <input type="text" name="title" id="title" value="{{ request('title') }}" placeholder="Ticket Title" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">
                </div>

                <!-- Status Dropdown -->
                <div class="flex-1">
                    <div x-data="{ open: false, selected: '{{ request('status') ?? 'Select Status' }}' }" class="relative">
                        <label for="status" class="block text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-info-circle mr-2 text-gray-700"></i> Status
                        </label>
                        <button @click="open = !open" type="button" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                            <span class="block truncate" x-text="selected"></span>
                            <span class="flex items-center">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a 1 1 0 01-1.414 0l-4-4a 1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>

                        <!-- Dropdown Menu -->
                        <ul x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
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
                        <label for="priority" class="block text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2 text-gray-700"></i> Priority
                        </label>
                        <button @click="open = !open" type="button" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                            <span class="block truncate" x-text="selected"></span>
                            <span class="flex items-center">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>

                        <!-- Dropdown Menu -->
                        <ul x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm" role="listbox">
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
                        <label for="employee" class="block text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-user mr-2 text-gray-700"></i> Employee
                        </label>
                        <button @click="open = !open" type="button" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                            <span class="block truncate" x-text="selected"></span>
                            <span class="flex items-center">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>

                        <!-- Dropdown Menu -->
                        <ul x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm" role="listbox">
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

        <div class="overflow-x-auto bg-white shadow-lg rounded-lg p-1">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100 text-left text-gray-600 uppercase text-xs leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left"><i class="fas fa-hashtag mr-2"></i></th>
                        <th class="py-3 px-6 text-left"><i class="fas fa-file-alt mr-2"></i>Title</th>
                        <th class="py-3 px-6 text-left"><i class="fas fa-tasks mr-2"></i>Status</th>
                        <th class="py-3 px-6 text-left"><i class="fas fa-exclamation-triangle mr-2"></i>Priority</th>
                        <th class="py-3 px-6 text-left hidden lg:table-cell"><i class="fas fa-user mr-2"></i>Employee</th>
                        <th class="py-3 px-6 text-left hidden lg:table-cell"><i class="fas fa-user-tie mr-2"></i>Project Manager</th>
                        <th class="py-3 px-6 text-center"><i class="fas fa-cogs mr-2"></i>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-black text-xs md:text-sm font-normal">
                    @foreach($tickets as $ticket)
                        <tr class="border-b border-gray-200 hover:bg-gray-100 {{ $loop->iteration % 2 == 0 ? 'bg-gray-200' : '' }}">
                            <td class="py-3 px-6">{{ $ticket->id }}</td>
                            <td class="py-3 px-6">{{ $ticket->title }}</td>
                            <td class="py-3 px-6">
                                <span class="font-semibold
                                    @if($ticket->status === 'In Progress') text-yellow-500
                                    @elseif($ticket->status === 'Open') text-orange-500
                                    @elseif($ticket->status === 'Closed') text-green-500
                                    @else text-gray-500 @endif">
                                    {{ $ticket->status }}
                                </span>
                            </td>
                            <td class="py-3 px-6">
                                <span class="font-semibold
                                    @if($ticket->priority === 'High') text-red-500
                                    @elseif($ticket->priority === 'Medium') text-yellow-500
                                    @elseif($ticket->priority === 'Low') text-green-500
                                    @endif">
                                    {{ $ticket->priority }}
                                </span>
                            </td>
                            <td class="py-3 px-6 hidden lg:table-cell">
                                @if($ticket->employee && $ticket->employee->user)
                                    {{ $ticket->employee->user->name }}
                                @else
                                    <span class="text-gray-500">Unassigned</span>
                                @endif
                            </td>
                            <td class="py-3 px-6 hidden lg:table-cell">
                                @if($ticket->projectManager && $ticket->projectManager->user)
                                    {{ $ticket->projectManager->user->name }}
                                @else
                                    <span class="text-gray-500">Unassigned</span>
                                @endif
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center space-x-4">
                                    <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="w-4 transform hover:text-blue-500 hover:scale-110">
                                        <i class="fas fa-eye fa-md text-orange-500 hover:text-blue-500"></i>
                                    </a>
                                    @php
                                        $isTicketIssuer = auth()->user()->id === $ticket->user_id;
                                        $isProjectManagerOfDepartment = $ticket->department 
                                            && $ticket->department->project_manager 
                                            && $ticket->department->project_manager->user_id === auth()->user()->id;
                                        $isSuperAdmin = auth()->user()->hasRole('Super Admin');
                                    @endphp
                                    
                                    @if($isSuperAdmin || $isProjectManagerOfDepartment || $isTicketIssuer)
                                        <!-- Only show edit and delete buttons for issuers if they are the ones who created the ticket -->
                                        @if($ticket->status !== 'Confirmed')
                                            <!-- Show the edit button only if the logged-in user is the ticket issuer or has higher access -->
                                            @if($isTicketIssuer || $isSuperAdmin || $isProjectManagerOfDepartment)
                                                <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="w-4 transform hover:text-orange-500 hover:scale-110">
                                                    <i class="fas fa-edit fa-md text-orange-500 hover:text-yellow-500"></i>
                                                </a>
                                            @endif
                                            <!-- Allow deletion only for users with Super Admin or Project Manager roles -->
                                            @if($isSuperAdmin || $isProjectManagerOfDepartment || $isTicketIssuer)
                                                <form id="delete-form-{{ $ticket->id }}" action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" class="inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-delete-button formId="delete-form-{{ $ticket->id }}" />
                                                </form>
                                            @endif
                                        @else
                                            <!-- Disabled Edit and Delete for Confirmed Tickets -->
                                            <i class="fas fa-edit fa-md text-gray-500"></i>
                                            <i class="fas fa-trash fa-md text-gray-500"></i>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                
                
            </table>
        </div>

        <x-pagination>
            {{ $tickets->appends(request()->query())->links('pagination::tailwind') }}
        </x-pagination>

    </div>
    <x-footer />
</div>

@endsection
