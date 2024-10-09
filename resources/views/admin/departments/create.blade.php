@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    @include('partials.sidebar')

    <div class="flex-1 p-6 bg-gray-100">

        @include('components.form.errors')

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold">Add New Department</h1>
            <a href="{{ route('admin.departments.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        <form action="{{ route('admin.departments.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="flex flex-col md:flex-row md:space-x-4">
                <div class="md:w-1/2">
                    <label for="name" class="block text-sm font-medium text-gray-700">Department Name</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('name') }}">
                </div>
                <div class="md:w-1/2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="flex flex-col md:flex-row md:space-x-4">
                <div class="md:w-1/2">
                    <label for="positions" class="block text-sm font-medium text-gray-700">Positions</label>
                    <input type="text" name="positions" id="positions" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('positions') }}">
                </div>
                
                <!-- Project Manager Dropdown with Hidden Input -->
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

            <div>
                <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition inline-flex items-center">
                    <i class="fas fa-save mr-2"></i> Create Department
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
