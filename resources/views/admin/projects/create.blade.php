@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <div class="flex-1 p-6 bg-gray-100">
        <x-title-with-back title="Add New Project" />

        @include('components.form.errors')

        <!-- Form -->
        <form method="POST" action="{{ route('admin.projects.store') }}">
            @csrf
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                
                <!-- Project Name -->
                <div class="lg:col-span-1">
                    <label for="name" class="block text-sm font-medium text-orange-500">
                        <i class="fas fa-tasks text-gray-700 mr-1"></i> Project Name
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Project Name" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-1.5" required>
                    @error('name')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Department Dropdown using Alpine.js -->
                <div x-data="{ open: false, selectedDepartment: '{{ old('department_id') ?? 'Select Department' }}', selectedDepartmentId: '', selectedProjectManagerId: '' }" class="lg:col-span-1 relative">
                    <label for="department_id" class="block text-sm font-medium text-orange-500">
                        <i class="fas fa-building text-gray-700 mr-1"></i> Department
                    </label>
                    <button @click="open = !open" type="button" class="mt-1 w-full bg-white border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-1.5 text-left flex items-center justify-between">
                        <span x-text="selectedDepartment"></span>
                        <i class="fas fa-chevron-down text-gray-500"></i>
                    </button>

                    <ul x-show="open" @click.away="open = false" x-cloak class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none">
                        <li @click="selectedDepartment = 'Select Department'; selectedDepartmentId = ''; selectedProjectManagerId = ''; open = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white group">
                            <i class="fas fa-building mr-2 text-orange-500 group-hover:text-white"></i> Select Department
                        </li>
                        @foreach($departments as $department)
                            <li 
                                @click="selectedDepartment = '{{ $department->name }}'; selectedDepartmentId = '{{ $department->id }}'; selectedProjectManagerId = '{{ optional($department->project_manager)->id ?? '' }}'; open = false" 
                                class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white group"
                            >
                                <i class="fas fa-building mr-2 text-orange-500 group-hover:text-white"></i> 
                                {{ $department->name }}
                            </li>
                        @endforeach
                    </ul>

                    <!-- Hidden Inputs for submission -->
                    <input type="hidden" name="department_id" :value="selectedDepartmentId">
                    <input type="hidden" name="project_manager_id" :value="selectedProjectManagerId">
                    
                    @error('department_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Client Dropdown using Alpine.js -->
                <div x-data="{ open: false, selectedClient: '{{ old('client_id') ?? 'Select Client' }}', selectedClientId: '' }" class="lg:col-span-1 relative">
                    <label for="client_id" class="block text-sm font-medium text-orange-500">
                        <i class="fas fa-handshake text-gray-700 mr-1"></i> Client
                    </label>
                    <button @click="open = !open" type="button" class="mt-1 w-full bg-white border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-1.5 text-left flex items-center justify-between">
                        <span x-text="selectedClient"></span>
                        <i class="fas fa-chevron-down text-gray-500"></i>
                    </button>

                    <ul x-show="open" @click.away="open = false" x-cloak class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none">
                        <li @click="selectedClient = 'Select Client'; selectedClientId = ''; open = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white group">
                            <i class="fas fa-handshake mr-2 text-orange-500 group-hover:text-white"></i> Select Client
                        </li>
                        @foreach($clients as $client)
                            <li 
                                @click="selectedClient = '{{ $client->company_name }}'; selectedClientId = '{{ $client->id }}'; open = false" 
                                class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white group"
                            >
                                <i class="fas fa-handshake mr-2 text-orange-500 group-hover:text-white"></i> 
                                {{ $client->company_name }}
                            </li>
                        @endforeach
                    </ul>

                    <!-- Hidden Inputs for submission -->
                    <input type="hidden" name="client_id" :value="selectedClientId">
                    
                    @error('client_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Status Dropdown using Alpine.js -->
                <div x-data="{ open: false, selectedStatus: '{{ old('status') ?? 'Select Status' }}' }" class="lg:col-span-1 relative">
                    <label for="status" class="block text-sm font-medium text-orange-500">
                        <i class="fas fa-tasks text-gray-700 mr-1"></i> Status
                    </label>
                    <button @click="open = !open" type="button" class="mt-1 w-full bg-white border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-1.5 text-left flex items-center justify-between">
                        <span x-text="selectedStatus"></span>
                        <i class="fas fa-chevron-down text-gray-500"></i>
                    </button>

                    <ul x-show="open" @click.away="open = false" x-cloak class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none">
                        <li @click="selectedStatus = 'In Progress'; open = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white group">
                            <i class="fas fa-spinner text-orange-500 group-hover:text-white mr-2"></i> In Progress
                        </li>
                        <li @click="selectedStatus = 'Pending'; open = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white group">
                            <i class="fas fa-clock text-orange-500 group-hover:text-white mr-2"></i> Pending
                        </li>
                        <li @click="selectedStatus = 'Completed'; open = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white group">
                            <i class="fas fa-check-circle text-orange-500 group-hover:text-white mr-2"></i> Completed
                        </li>
                    </ul>
                    
                    <!-- Hidden Input for submission -->
                    <input type="hidden" name="status" :value="selectedStatus">
                    
                    @error('status')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Start Date -->
                <div class="lg:col-span-1">
                    <label for="start_date" class="block text-sm font-medium text-orange-500">
                        <i class="fas fa-calendar-alt text-gray-700 mr-1"></i> Start Date
                    </label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-1.5" required>
                    @error('start_date')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- End Date -->
                <div class="lg:col-span-1">
                    <label for="end_date" class="block text-sm font-medium text-orange-500">
                        <i class="fas fa-calendar-alt text-gray-700 mr-1"></i> End Date
                    </label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-1.5">
                    @error('end_date')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Description -->
                <div class="lg:col-span-2">
                    <label for="description" class="block text-sm font-medium text-orange-500">
                        <i class="fas fa-align-left text-gray-700 mr-1"></i> Description
                    </label>
                    <textarea name="description" id="description" rows="4" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-1.5">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-4">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                    <i class="fas fa-save mr-2"></i>Create Project
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
