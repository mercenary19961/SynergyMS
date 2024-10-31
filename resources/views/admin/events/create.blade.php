@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <div class="flex-1 p-6 bg-gray-100">
        @include('components.form.errors')

        <x-title-with-back title="Add New Event" />

        <form action="{{ route('admin.events.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="flex flex-col md:flex-row md:space-x-4">
                <!-- Event Name -->
                <div class="md:w-1/2">
                    <label for="name" class="block text-sm font-medium text-gray-700">Event Name</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('name') }}">
                </div>

                <!-- Event Description -->
                <div class="md:w-1/2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="flex flex-col md:flex-row md:space-x-4">
                <!-- Start Date -->
                <div class="md:w-1/2">
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input type="datetime-local" name="start_date" id="start_date" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('start_date') }}">
                </div>

                <!-- End Date -->
                <div class="md:w-1/2">
                    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                    <input type="datetime-local" name="end_date" id="end_date" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('end_date') }}">
                </div>
            </div>

            <div class="flex flex-col md:flex-row md:space-x-4">
                <!-- Sector (General, Role, Department) -->
                <div class="md:w-1/2 relative" x-data="{ open: false, selectedSector: '{{ old('target_role') ?? 'Select Sector' }}' }">
                    <label for="target_role" class="block text-sm font-medium text-gray-700">Sector</label>
                    <button type="button" @click="open = !open" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <span x-text="selectedSector"></span>
                        <span class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 111.414 1.414l-4 4a 1 1 0 01-1.414 0l-4-4a 1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>
                    <ul x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto">
                        <li @click="selectedSector = 'General'; open = false" class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center">
                            <i class="fas fa-users mr-2 text-orange-500 group-hover:text-white"></i> General
                        </li>
                        @foreach($roles as $role)
                            <li @click="selectedSector = '{{ $role }}'; open = false" class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center">
                                <i class="fas fa-user-tag mr-2 text-orange-500 group-hover:text-white"></i> {{ ucfirst($role) }}
                            </li>
                        @endforeach
                        @foreach($departments as $department)
                            <li @click="selectedSector = '{{ $department->name }}'; open = false" class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center">
                                <i class="fas fa-building mr-2 text-orange-500 group-hover:text-white"></i> {{ $department->name }}
                            </li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="target_role" x-ref="target_role" :value="selectedSector === 'Select Sector' ? '' : selectedSector">
                    @error('target_role')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- General Event Checkbox -->
                <div class="md:w-1/2 flex items-center mt-6">
                    <input type="hidden" name="is_general" value="0">
                    <input type="checkbox" name="is_general" id="is_general" class="mr-2 h-5 w-5 text-orange-500 focus:ring-orange-500 border-gray-300 rounded" {{ old('is_general') ? 'checked' : '' }}>
                    <label for="is_general" class="block text-sm font-medium text-gray-700">General Event</label>
                </div>

            </div>

            <x-form.button-submit label="Create Event" />
        </form>
    </div>
</div>
@endsection
