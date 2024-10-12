@extends('layouts.app')

@section('content')
<div class="flex h-screen">

    <div class="flex-1 p-6 bg-gray-100 overflow-auto">
        <x-title-with-back title="Add New Ticket" />

        @include('components.form.errors')

        <form action="{{ route('admin.tickets.store') }}" method="POST" x-data="ticketForm()">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="mb-4">
                    <label for="title" class="block text-sm font-bold text-gray-700">
                        <i class="fas fa-file-alt mr-2 text-orange-500"></i> Title
                    </label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" value="{{ old('title') }}" placeholder="Enter Ticket Title">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-bold text-gray-700">
                        <i class="fas fa-align-left mr-2 text-orange-500"></i> Description
                    </label>
                    <textarea name="description" id="description" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" placeholder="Enter Ticket Description">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="relative mb-4">
                    <label for="status" class="block text-sm font-bold text-gray-700">
                        <i class="fas fa-tasks mr-2 text-orange-500"></i> Status
                    </label>
                    <button type="button" class="mt-1 w-full bg-gray-200 border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between focus:outline-none" disabled>
                        <span class="block truncate">Open</span>
                    </button>
                    <input type="hidden" name="status" value="Open">
                </div>

                <div class="relative mb-4">
                    <label for="priority" class="block text-sm font-bold text-gray-700">
                        <i class="fas fa-exclamation-triangle mr-2 text-orange-500"></i> Priority
                    </label>
                    <button type="button" @click="openPriority = !openPriority" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <span class="block truncate" x-text="selectedPriority || 'Select Priority'"></span>
                        <span class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a 1 1 0 01-1.414 0l-4-4a 1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>
                    <ul x-show="openPriority" @click.away="openPriority = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto">
                        <li @click="selectedPriority = 'Low'; $refs.priority.value = 'Low'; openPriority = false" class="cursor-pointer group select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center">
                            <i class="fas fa-exclamation-circle mr-2 text-orange-500 group-hover:text-white"></i> Low
                        </li>
                        <li @click="selectedPriority = 'Medium'; $refs.priority.value = 'Medium'; openPriority = false" class="cursor-pointer group select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center">
                            <i class="fas fa-minus mr-2 text-orange-500 group-hover:text-white"></i> Medium
                        </li>
                        <li @click="selectedPriority = 'High'; $refs.priority.value = 'High'; openPriority = false" class="cursor-pointer group select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2 text-orange-500 group-hover:text-white"></i> High
                        </li>
                    </ul>
                    <input type="hidden" name="priority" x-ref="priority" value="{{ old('priority') }}">
                    @error('priority')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="relative mb-4">
                    <label for="project_manager_id" class="block text-sm font-bold text-gray-700">
                        <i class="fas fa-user-tie mr-2 text-orange-500"></i> Project Manager
                    </label>
                    <button type="button" @click="openProjectManager = !openProjectManager" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <span class="block truncate" x-text="selectedProjectManager || 'Select Project Manager'"></span>
                        <span class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a 1 1 0 01-1.414 0l-4-4a 1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>
                    <ul x-show="openProjectManager" @click.away="openProjectManager = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto">
                        @foreach($projectManagers as $manager)
                            <li @click="selectedProjectManager = '{{ $manager->user->name }}'; $refs.project_manager_id.value = '{{ $manager->id }}'; openProjectManager = false" class="cursor-pointer group select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center">
                                <i class="fas fa-user-tie mr-2 text-orange-500 group-hover:text-white"></i> {{ $manager->user->name }}
                            </li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="project_manager_id" x-ref="project_manager_id" value="{{ old('project_manager_id') }}">
                    @error('project_manager_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <x-form.button-submit label="Create Ticket" />
        </form>
    </div>
</div>

<script>
    function ticketForm() {
        return {
            openStatus: false,
            openPriority: false,
            openProjectManager: false,
            selectedStatus: '{{ old('status') }}',
            selectedPriority: '{{ old('priority') }}',
            selectedProjectManager: '{{ old('project_manager_id') ? $projectManagers->firstWhere('id', old('project_manager_id'))->user->name : "" }}',
        }
    }
</script>

@endsection
