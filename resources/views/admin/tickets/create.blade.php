{{-- resources/views/admin/tickets/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100 overflow-auto">
        <h1 class="mb-4 text-2xl font-semibold">Add New Ticket</h1>


        <!-- Error Message -->
        @if($errors->any())
            <div x-data="{ show: true }" x-show="show" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Whoops!</strong>
                <span class="block sm:inline">There were some problems with your input.</span>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-red-700 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Create Ticket Form -->
        <form action="{{ route('admin.tickets.store') }}" method="POST" x-data="ticketForm()">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Title -->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" value="{{ old('title') }}" placeholder="Enter Ticket Title">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" placeholder="Enter Ticket Description">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Dropdown -->
                <div class="relative mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <button type="button" @click="openStatus = !openStatus" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <span class="block truncate" x-text="selectedStatus || 'Select Status'"></span>
                        <span class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>
                    <ul x-show="openStatus" @click.away="openStatus = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto">
                        <li @click="selectedStatus = 'Open'; $refs.status.value = 'Open'; openStatus = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">Open</li>
                        <li @click="selectedStatus = 'In Progress'; $refs.status.value = 'In Progress'; openStatus = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">In Progress</li>
                        <li @click="selectedStatus = 'Closed'; $refs.status.value = 'Closed'; openStatus = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">Closed</li>
                    </ul>
                    <input type="hidden" name="status" x-ref="status" value="{{ old('status') }}">
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority Dropdown -->
                <div class="relative mb-4">
                    <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                    <button type="button" @click="openPriority = !openPriority" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <span class="block truncate" x-text="selectedPriority || 'Select Priority'"></span>
                        <span class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>
                    <ul x-show="openPriority" @click.away="openPriority = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto">
                        <li @click="selectedPriority = 'High'; $refs.priority.value = 'High'; openPriority = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">High</li>
                        <li @click="selectedPriority = 'Medium'; $refs.priority.value = 'Medium'; openPriority = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">Medium</li>
                        <li @click="selectedPriority = 'Low'; $refs.priority.value = 'Low'; openPriority = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">Low</li>
                    </ul>
                    <input type="hidden" name="priority" x-ref="priority" value="{{ old('priority') }}">
                    @error('priority')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Assigned Employee Dropdown -->
                <div class="relative mb-4">
                    <label for="employee_id" class="block text-sm font-medium text-gray-700">Assigned Employee</label>
                    <button type="button" @click="openEmployee = !openEmployee" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <span class="block truncate" x-text="selectedEmployee || 'Select Employee'"></span>
                        <span class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>
                    <ul x-show="openEmployee" @click.away="openEmployee = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto">
                        @foreach($employees as $employee)
                            <li @click="selectedEmployee = '{{ $employee->user->name }}'; $refs.employee_id.value = '{{ $employee->id }}'; openEmployee = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">
                                {{ $employee->user->name }}
                            </li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="employee_id" x-ref="employee_id" value="{{ old('employee_id') }}">
                    @error('employee_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Project Dropdown -->
                <div class="relative mb-4">
                    <label for="project_id" class="block text-sm font-medium text-gray-700">Project</label>
                    <button type="button" @click="openProject = !openProject" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <span class="block truncate" x-text="selectedProject || 'Select Project'"></span>
                        <span class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>
                    <ul x-show="openProject" @click.away="openProject = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto">
                        @foreach($projects as $project)
                            <li @click="selectedProject = '{{ $project->name }}'; $refs.project_id.value = '{{ $project->id }}'; openProject = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">
                                {{ $project->name }}
                            </li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="project_id" x-ref="project_id" value="{{ old('project_id') }}">
                    @error('project_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Project Manager Dropdown -->
                <div class="relative mb-4">
                    <label for="project_manager_id" class="block text-sm font-medium text-gray-700">Project Manager</label>
                    <button type="button" @click="openProjectManager = !openProjectManager" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <span class="block truncate" x-text="selectedProjectManager || 'Select Project Manager'"></span>
                        <span class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>
                    <ul x-show="openProjectManager" @click.away="openProjectManager = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto">
                        @foreach($projectManagers as $manager)
                            <li @click="selectedProjectManager = '{{ $manager->user->name }}'; $refs.project_manager_id.value = '{{ $manager->id }}'; openProjectManager = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">
                                {{ $manager->user->name }}
                            </li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="project_manager_id" x-ref="project_manager_id" value="{{ old('project_manager_id') }}">
                    @error('project_manager_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">
                    <i class="fas fa-save mr-2"></i>Create Ticket
                </button>
                <a href="{{ route('admin.tickets.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Back
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    function ticketForm() {
        return {
            openStatus: false,
            openPriority: false,
            openEmployee: false,
            openProject: false,
            openProjectManager: false,
            selectedStatus: '{{ old('status') }}',
            selectedPriority: '{{ old('priority') }}',
            selectedEmployee: '{{ old('employee_id') ? $employees->firstWhere('id', old('employee_id'))->user->name : "" }}',
            selectedProject: '{{ old('project_id') ? $projects->firstWhere('id', old('project_id'))->name : "" }}',
            selectedProjectManager: '{{ old('project_manager_id') ? $projectManagers->firstWhere('id', old('project_manager_id'))->user->name : "" }}',
        }
    }
</script>

@endsection
