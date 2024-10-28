@extends('layouts.app')

@section('content')
<div class="flex flex-col h-screen">
    <div class="flex-1 p-6 bg-gray-100">
        <!-- Add Alpine.js Data and Modals -->
        <div x-data="{ showTicketModal: false, showProjectModal: false }">
            
            <!-- Dashboard Title with Buttons -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
                <!-- Left Side: Welcome Message -->
                <div>
                    <h1 class="text-2xl md:text-3xl font-semibold flex items-center text-gray-700">
                        <i class="fas fa-user-tie mr-2 text-gray-700"></i> Welcome, {{ $client->user->name }}!
                    </h1>
                    <p class="text-xl md:text-2xl font-semibold bg-clip-text text-transparent bg-gradient-to-r from-pink-600 to-orange-500 mt-2 ml-4 md:ml-9">
                        HOW CAN WE HELP YOU TODAY?
                    </p>
                </div>

                <!-- Right Side: New Project and New Ticket Buttons -->
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 w-full md:w-auto">
                    <!-- New Project Button -->
                    <button @click="showProjectModal = true" class="bg-blue-500 text-white text-sm md:text-base px-4 py-2 rounded hover:bg-blue-600 transition inline-flex items-center justify-center w-full md:w-auto">
                        <i class="fas fa-plus mr-2"></i> New Project?
                    </button>

                    <!-- New Ticket Button -->
                    <button @click="showTicketModal = true" class="bg-green-500 text-white text-sm md:text-base px-4 py-2 rounded hover:bg-green-600 transition inline-flex items-center justify-center w-full md:w-auto">
                        <i class="fas fa-ticket-alt mr-2"></i> New Ticket?
                    </button>
                </div>
            </div>

            <!-- Modal for New Ticket -->
            <div x-show="showTicketModal" class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
                                            <button type="button" @click="showTicketModal = false" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Cancel</button>
                                            <button type="submit" class="ml-2 bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">Create Ticket</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for New Project -->
            <div x-show="showProjectModal" class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                    <div class="inline-block bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="sm:flex sm:items-start">
                            <div class="text-center sm:text-left w-full">
                                <h3 class="text-lg font-medium text-gray-900" id="modal-title">Create a New Project</h3>
                                <div class="mt-2">
                                    <!-- Form inside the modal with grid layout -->
                                    <form action="{{ route('admin.projects.storeRequest') }}" method="POST">
                                        @csrf
                                        <div class="grid grid-cols-2 gap-4">
                                            <!-- Project Name Field -->
                                            <div class="col-span-2 mb-4">
                                                <label for="project_name" class="block text-sm font-bold text-gray-700">
                                                    <i class="fas fa-project-diagram text-orange-500 mr-1"></i> Project Name
                                                </label>
                                                <input type="text" name="name" id="project_name" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" required>
                                            </div>

                                            <!-- Description Field -->
                                            <div class="col-span-2 mb-4">
                                                <label for="project_description" class="block text-sm font-bold text-gray-700">
                                                    <i class="fas fa-align-left text-orange-500 mr-1"></i> Description
                                                </label>
                                                <textarea name="description" id="project_description" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" required></textarea>
                                            </div>

                                            <!-- Department Selection Field in the Modal -->
                                            <div class="col-span-2 mb-4">
                                                <label for="department" class="block text-sm font-bold text-gray-700">
                                                    <i class="fas fa-building text-orange-500 mr-1"></i> Department
                                                </label>
                                                <select name="department_id" id="department" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" required
                                                        @change="document.getElementById('project_manager_id').value = getProjectManagerId($event.target.value)">
                                                    <option value="" disabled selected>Select Department</option>
                                                    @foreach($departments as $department)
                                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Start Date Field -->
                                            <div class="col-span-2 mb-4">
                                                <label for="start_date" class="block text-sm font-bold text-gray-700">
                                                    <i class="fas fa-calendar-alt text-orange-500 mr-1"></i> Start Date
                                                </label>
                                                <input type="date" name="start_date" id="start_date" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" required>
                                            </div>

                                            <!-- End Date Field -->
                                            <div class="col-span-2 mb-4">
                                                <label for="end_date" class="block text-sm font-bold text-gray-700">
                                                    <i class="fas fa-calendar-alt text-orange-500 mr-1"></i> End Date
                                                </label>
                                                <input type="date" name="end_date" id="end_date" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" required>
                                            </div>

                                            <!-- Hidden input for Project Manager ID -->
                                            <input type="hidden" name="project_manager_id" id="project_manager_id">

                                            <!-- Automatically set the client_id of the project -->
                                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                                        </div>

                                        <!-- Submit and Cancel Buttons -->
                                        <div class="flex justify-end mt-4">
                                            <button type="button" @click="showProjectModal = false" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Cancel</button>
                                            <button type="submit" class="ml-2 bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">Create Project</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function getProjectManagerId(departmentId) {
                    const departmentToManagerMap = {
                        1: 1,
                        2: 1,
                        3: 3,
                        4: 4,
                        5: 5,
                        6: 6
                    };
                    return departmentToManagerMap[departmentId] || '';
                }
            </script>

            <!-- SweetAlert Popup -->
            @if(session('show_popup'))
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: '{{ session('show_popup') }}',
                            confirmButtonColor: '#ff6600',
                        });
                    });
                </script>
            @endif
        </div>

        <!-- Grid Layout for the Dashboard Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Project Overview Section -->
            <div class="col-span-2 bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4 text-orange-500 flex items-center">
                    <i class="fas fa-project-diagram mr-2"></i> Project Overview
                </h2>
                @if($clientProjects->isEmpty())
                    <p class="text-xs font-semibold text-left text-gray-500">No projects available.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($clientProjects as $project)
                            <!-- Make the project clickable -->
                            <a href="{{ route('admin.projects.show', $project->id) }}" class="p-4 border border-gray-200 rounded-md bg-gray-50 hover:bg-gray-100 transition duration-300 ease-in-out">
                                <p class="text-sm font-semibold text-left text-gray-700">{{ $project->name }}</p>
                                <p class="text-xs font-semibold text-left text-gray-700">
                                    Status: 
                                    <span class="font-medium 
                                        @if($project->status == 'Pending') text-orange-500 
                                        @elseif($project->status == 'In Progress') text-yellow-500 
                                        @elseif($project->status == 'Completed') text-green-500 
                                        @else text-gray-500 @endif">
                                        {{ $project->status }}
                                    </span>
                                </p>
                                <p class="text-xs font-semibold text-left text-gray-700">Project Manager: <span class="font-medium text-gray-500">{{ $project->projectManager ? $project->projectManager->user->name : 'N/A' }}</span></p>
                                <p class="text-xs font-semibold text-left text-gray-700">Employees Assigned: 
                                    <span class="font-medium text-gray-500">{{ $project->taskEmployees->count() }}</span>
                                </p>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Invoice & Payments Section (takes 2 columns on small screens, 1 on large) -->
            <div class="col-span-2 lg:col-span-1 bg-white shadow rounded-lg p-4 md:p-6">
                <h2 class="text-lg md:text-xl font-semibold mb-4 text-orange-500 flex items-center">
                    <i class="fas fa-file-invoice-dollar mr-2"></i> Invoices & Payments
                </h2>

                <div class="flex flex-col space-y-4 w-full">
                    <!-- Unpaid Invoices Box -->
                    <div class="relative flex flex-col bg-gray-100 p-4 md:p-6 rounded-md shadow w-full">
                        <p class="text-xs font-semibold text-left text-gray-500">Total Unpaid Invoices</p>
                        <p class="text-2xl sm:text-3xl md:text-4xl font-bold text-orange-600">{{ number_format($totalUnpaidInvoices, 2) }} <span class="text-lg">USD</span></p>
                        <p class="absolute bottom-2 right-2 md:right-4 text-xs text-gray-500">Invoices: {{ $unpaidInvoicesCount }}</p>
                    </div>

                    <!-- Paid Invoices Box -->
                    <div class="relative flex flex-col bg-gray-100 p-4 md:p-6 rounded-md shadow w-full">
                        <p class="text-xs font-semibold text-left text-gray-500">Total Paid Invoices</p>
                        <p class="text-2xl sm:text-3xl md:text-4xl font-bold text-green-500">{{ number_format($totalPaidInvoices, 2) }} <span class="text-lg">USD</span></p>
                        <p class="absolute bottom-2 right-2 md:right-4 text-xs text-gray-500">Invoices: {{ $paidInvoicesCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Tickets Section -->
            <div class="col-span-2 bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4 text-orange-500 flex items-center">
                    <i class="fas fa-ticket-alt mr-2"></i> My Tickets
                </h2>
                @if($clientTickets->isEmpty())
                    <p class="text-xs font-semibold text-left text-gray-700">No tickets available.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($clientTickets as $ticket)
                            <!-- Make the ticket clickable -->
                            <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="p-4 border border-gray-200 rounded-md bg-gray-50 hover:bg-gray-100 transition duration-300 ease-in-out">
                                <p class="text-sm font-semibold text-left text-gray-700">{{ $ticket->title }}</p>
                                <p class="text-xs font-semibold text-left text-gray-700">
                                    Status: 
                                    <span class="font-medium 
                                        @if($ticket->status == 'Open') text-orange-500 
                                        @elseif($ticket->status == 'In Progress') text-yellow-500 
                                        @elseif($ticket->status == 'Confirmed') text-green-500 
                                        @else text-gray-500 @endif">
                                        {{ $ticket->status }}
                                    </span>
                                </p>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Notifications Section -->
            <div class="col-span-2 lg:col-span-1 bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4 text-orange-500 flex items-center">
                    <i class="fas fa-bell mr-2"></i> Messages / Notifications
                </h2>
                @if($clientNotifications->isEmpty())
                    <p class="text-xs font-semibold text-left text-gray-500">No notifications available.</p>
                @else
                    <ul class="space-y-3">
                        @foreach($clientNotifications as $notification)
                            @php
                                $data = $notification->data;
                            @endphp
                            <li class="p-3 border border-gray-200 rounded-md">
                                <p class="text-xs font-semibold text-left text-gray-500">
                                    Invoice #{{ $data['invoice_id'] }} - Amount: ${{ $data['amount'] }} - Status: {{ $data['status'] }}
                                </p>
                                <small class="block text-gray-500">{{ $notification->created_at->diffForHumans() }}</small>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
    <x-footer />
</div>
@endsection
