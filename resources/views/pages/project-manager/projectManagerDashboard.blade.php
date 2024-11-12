@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    <div class="flex-1 p-6 bg-gray-100">
        <!-- Alpine.js data for Modal -->
        <div x-data="{ showTicketModal: false }">

            <!-- Project Manager Name Header -->
            <div class="flex justify-between items-start mb-6">
                <div class="flex flex-col">
                    <h2 class="text-2xl md:text-2xl font-semibold flex items-center text-gray-700">
                        <i class="fas fa-user-tie mr-2 text-gray-600"></i> {{ $projectManager->user->name }}'s Dashboard
                    </h2>
                    <p class="text-xl md:text-xl font-semibold bg-clip-text text-transparent bg-gradient-to-r from-pink-600 to-orange-500 mt-2 ml-8">
                        READY TO LEAD YOUR TEAM TO SUCCESS TODAY?
                    </p>
                </div>

                <!-- New Ticket Button -->
                <button @click="showTicketModal = true" class="bg-orange-500 text-white px-4 py-2 rounded mt-4 hover:bg-orange-600 transition">
                    <i class="fas fa-ticket-alt mr-2"></i> New Ticket
                </button>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Managed Projects Card -->
                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center transition-all duration-500 transform hover:scale-105 hover:shadow-2xl">
                    <i class="fas fa-briefcase text-orange-500 text-4xl mb-2"></i>
                    <h3 class="text-4xl font-bold text-orange-500">{{ $managedProjects->count() }}</h3>
                    <p class="text-gray-600 mt-1">Managed Projects</p>
                </div>

                <!-- Tasks Card  -->
                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center transition-all duration-500 transform hover:scale-105 hover:shadow-2xl">
                    <i class="fas fa-tasks text-orange-500 text-4xl mb-2"></i>
                    <h3 class="text-4xl font-bold text-orange-500">
                        {{ $managedProjects->pluck('tasks')->flatten()->count() }}
                    </h3>
                    <p class="text-gray-600 mt-1">Total Tasks</p>
                </div>

                <!-- Managed Employees Card -->
                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center transition-all duration-500 transform hover:scale-105 hover:shadow-2xl">
                    <i class="fas fa-users text-orange-500 text-4xl mb-2"></i>
                    <h3 class="text-4xl font-bold text-orange-500">{{ $managedEmployees->count() }}</h3>
                    <p class="text-gray-600 mt-1">Managed Employees</p>
                </div>

                <!-- Clients Card -->
                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center transition-all duration-500 transform hover:scale-105 hover:shadow-2xl">
                    <i class="fas fa-handshake text-orange-500 text-4xl mb-2"></i>
                    <h3 class="text-4xl font-bold text-orange-500">
                        {{ $managedProjects->pluck('client')->unique('id')->count() }}
                    </h3>
                    <p class="text-gray-600 mt-1">Clients</p>
                </div>
            </div>

            <!-- Managed Projects -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2 flex items-center">
                    <i class="fas fa-tasks mr-2 text-gray-500"></i> 
                    Current Projects
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8 bg-gray-100">
                    @foreach($managedProjects as $project)
                        <!-- Card without progress bar and with orange button at the bottom -->
                        <div class="bg-white p-4 rounded-lg shadow-lg w-full sm:w-full transition-all duration-500 transform hover:scale-105 hover:shadow-2xl flex flex-col justify-between">
                            <!-- Project Title -->
                            <h3 class="text-md font-semibold text-gray-700">{{ $project->name }}</h3>
                            
                            <!-- Task Summary -->
                            <p class="text-sm text-gray-600 mb-2">{{ $project->tasks_open }} <span class="text-orange-400">open</span> tasks, {{ $project->tasks_completed }} tasks <span class="text-green-500">completed</span></p>
                    
                            <!-- Project Description -->
                            <p class="text-gray-600 mb-4">{{ Str::limit($project->description, 100, '...') }}</p>
                    
                            <!-- Deadline -->
                            <p class="font-semibold text-gray-600">Deadline: <span class="font-normal">{{ $project->end_date->format('d M Y') }}</span></p>
                    
                            <!-- Project Leader -->
                            <p class="font-semibold text-gray-600 mt-2">Project Leader:</p>
                            <div class="flex items-center mb-4">
                                <a href="{{ route('admin.project-managers.show', $projectManager->id) }}" class="hover:scale-110 transition-transform duration-200">
                                    <img src="{{ asset('storage/' . $projectManager->user->image) }}" alt="Project Leader" class="w-8 h-8 rounded-full">
                                </a>
                            </div>
                    
                            <!-- Team Members -->
                            <p class="font-semibold text-gray-600">Team:</p>
                            <div class="flex items-center mb-4 -space-x-2">
                                @foreach($project->employees->filter(fn($employee) => $employee->department_id == $projectManager->department_id)->take(4) as $employee)
                                    <a href="{{ route('admin.employees.show', $employee->id) }}" class="hover:scale-110 transition-transform duration-200">
                                        <img src="{{ $employee->user->image ? asset('storage/' . $employee->user->image) : asset('images/default_user_image.png') }}" 
                                            alt="{{ $employee->name }}" 
                                            class="w-8 h-8 rounded-full border-2 border-white">
                                    </a>
                                @endforeach
                                @php
                                    $departmentEmployeeCount = $project->employees->filter(fn($employee) => $employee->department_id == $projectManager->department_id)->count();
                                @endphp
                                @if($departmentEmployeeCount > 4)
                                    <span class="text-sm ml-2 bg-orange-500 text-white rounded-full px-2">+{{ $departmentEmployeeCount - 4 }}</span>
                                @endif
                            </div>

                            <!-- View Project Button -->
                            <a href="{{ route('admin.projects.show', $project->id) }}" class="mt-auto bg-orange-500 text-white text-center py-2 px-4 rounded hover:bg-orange-600 transition">
                                View Project
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Managed Employees -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4 flex items-center">
                    <i class="fas fa-users mr-2 text-gray-500"></i> 
                    Team of Employees
                </h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($managedEmployees->take(7) as $employee)
                        <div class="bg-white p-4 rounded-lg shadow transition-all duration-300 transform hover:scale-105 hover:shadow-2xl flex flex-col items-center">
                            <!-- Employee Image -->
                            <img 
                                class="w-16 h-16 rounded-full mb-3 object-cover" 
                                src="{{ $employee->user->image ? asset('storage/' . $employee->user->image) : asset('images/default_user_image.png') }}" 
                                alt="{{ $employee->user->name }}">
                            
                            <!-- Employee Name -->
                            <h3 class="font-semibold text-gray-700">{{ $employee->user->name }}</h3>
                            
                            <!-- Department -->
                            <p class="text-gray-500 text-sm">Department: {{ $employee->department->name }}</p>
                            
                            <!-- Position -->
                            <p class="text-gray-400 text-xs">Position: {{ $employee->position->name }}</p>
                        </div>
                    @endforeach

                    <!-- Show 'View All Employees' Button if there are more than 7 employees -->
                    @if($managedEmployees->count() > 7)
                        <div class="bg-white p-4 rounded-lg shadow transition-all duration-300 transform hover:scale-105 hover:shadow-2xl flex flex-col items-center justify-center">
                            <a href="{{ route('admin.employees.index', ['project_manager' => $projectManager->id]) }}" class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition flex items-center">
                                View All Employees
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    @endif

                </div>
            </div>

            <!-- Modal for New Ticket -->
            <div x-show="showTicketModal" class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                    <div class="inline-block bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="sm:flex sm:items-start">
                            <div class="text-center sm:text-left w-full">
                                <h3 class="text-lg font-medium text-gray-900" id="modal-title">Create a New Ticket</h3>
                                <div class="mt-2">
                                    <!-- Form inside the modal -->
                                    <form action="{{ route('admin.tickets.store') }}" method="POST">
                                        @csrf
                                        <div class="grid grid-cols-2 gap-4">
                                            <!-- Priority Dropdown (using Livewire or a simple dropdown) -->
                                            <livewire:priority-dropdown />

                                            <!-- Ticket Name Field -->
                                            <div class="col-span-2 mb-4">
                                                <label for="ticket_name" class="block text-sm font-bold text-gray-700">
                                                    <i class="fas fa-ticket-alt text-orange-500 mr-1"></i> Ticket Name
                                                </label>
                                                <input type="text" name="title" id="ticket_name" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" required>
                                            </div>

                                            <!-- Description Field -->
                                            <div class="col-span-2 mb-4">
                                                <label for="description" class="block text-sm font-bold text-gray-700">
                                                    <i class="fas fa-align-left text-orange-500 mr-1"></i> Description
                                                </label>
                                                <textarea name="description" id="description" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" required></textarea>
                                            </div>

                                            <!-- Automatically set the user_id of the ticket issuer -->
                                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                        </div>

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

        </div>
    </div>
    <x-footer />
</div>
@endsection

