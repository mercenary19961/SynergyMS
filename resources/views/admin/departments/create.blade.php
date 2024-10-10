@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    @include('partials.sidebar')

    <div class="flex-1 p-6 bg-gray-100">
        @include('components.form.errors')

        <x-title-with-back title="Add New Department" />

        <form action="{{ route('admin.departments.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Department Name and Description -->
            <div class="flex flex-col md:flex-row md:space-x-4">
                <!-- Department Name -->
                <div class="md:w-1/2">
                    <label for="name" class="block text-sm font-medium text-gray-700">Department Name</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('name') }}">
                </div>

                <!-- Department Description -->
                <div class="md:w-1/2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Dynamic Positions Input -->
            <div class="flex flex-col md:flex-row md:space-x-4">
                <div class="md:w-1/2">
                    <label for="positions" class="block text-sm font-medium text-gray-700">Positions</label>
                    <div x-data="{ positions: [''] }">
                        <template x-for="(position, index) in positions" :key="index">
                            <div class="flex mt-1">
                                <input :name="'positions[' + index + ']'" type="text" x-model="positions[index]" class="block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" placeholder="Enter position">
                                <button type="button" @click="positions.push('')" class="ml-2 text-green-500 hover:text-green-700">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                                <button type="button" @click="positions.splice(index, 1)" class="ml-2 text-red-500 hover:text-red-700" x-show="positions.length > 1">
                                    <i class="fas fa-minus-circle"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Project Manager Dropdown -->
                <div class="md:w-1/2" x-data="{ open: false, selected: '' }">
                    <label for="project_manager" class="block text-sm font-medium text-gray-700">Assign Project Manager</label>
                    <button type="button" @click="open = !open" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <span x-text="selected || 'Select a Project Manager'"></span>
                        <span class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>
                    <ul x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto">
                        @foreach($projectManagers as $manager)
                            <li @click="selected = '{{ $manager->user->name }}'; $refs.project_manager.value = '{{ $manager->id }}'; open = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">
                                {{ $manager->user->name }}
                            </li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="project_manager" x-ref="project_manager" value="{{ old('project_manager') }}">
                    @error('project_manager')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Assign Employees Field -->
            <div class="md:w-1/2" x-data="{ open: false, selectedEmployees: [] }">
                <label for="employees" class="block text-sm font-medium text-gray-700">Assign Employees</label>
                <button type="button" @click="open = !open" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                    <span x-text="selectedEmployees.length > 0 ? selectedEmployees.join(', ') : 'Select Employees'"></span>
                    <span class="flex items-center">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </button>
                <ul x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto">
                    @foreach($employees as $employee)
                        <li @click="selectedEmployees.push('{{ $employee->name }}'); $refs.employees.value = selectedEmployees.join(', '); open = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">
                            {{ $employee->name }}
                        </li>
                    @endforeach
                </ul>
                <input type="hidden" name="employees" x-ref="employees" value="{{ old('employees') }}">
                @error('employees')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <x-form.button-submit label="Create Department" />
        </form>
    </div>
</div>
@endsection
