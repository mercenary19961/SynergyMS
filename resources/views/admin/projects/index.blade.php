@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <div class="flex-1 p-6 bg-gray-100">
        @include('components.form.success')

        <!-- Header Row -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold">
                <i class="fas fa-tasks mr-2 text-gray-600"></i> Projects
            </h1>
            <a href="{{ route('admin.projects.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">
                <i class="fas fa-plus mr-2"></i>Add New Project
            </a>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.projects.index') }}" class="mb-4 text-sm">
            <div class="grid grid-cols-2 lg:grid-cols-6 gap-2 mb-4">
                
                <!-- Project Name Field -->
                <div class="lg:col-span-1">
                    <label for="name" class="block text-sm font-medium text-gray-700">Project Name</label>
                    <input type="text" name="name" id="name" value="{{ request('name') }}" placeholder="Project Name" class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                </div>

                <!-- Department Dropdown -->
                <div class="lg:col-span-1 text-sm relative" x-data="{ open: false, selected: '{{ request('department') ?? 'Select Department' }}' }">
                    <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                    <button @click="open = !open" type="button" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <span x-text="selected" class="block truncate"></span>
                        <span class="absolute inset-y-11 right-0 flex items-center pr-2 pointer-events-none">
                            <i class="fas fa-chevron-down text-orange-500"></i>
                        </span>
                    </button>

                    <ul x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                        <li @click="selected = 'Select Department'; open = false; $refs.department.value = ''" class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center">
                            <i class="fas fa-building mr-2 text-orange-500 group-hover:text-white"></i> Select Department
                        </li>
                        @foreach($departments as $department)
                            <li @click="selected = '{{ $department->name }}'; open = false; $refs.department.value = '{{ $department->name }}'" class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center">
                                <i class="fas fa-building mr-2 text-orange-500 group-hover:text-white"></i> {{ $department->name }}
                            </li>
                        @endforeach
                    </ul>

                    <input type="hidden" name="department" x-ref="department" value="{{ request('department') }}">
                </div>

                <!-- Project Manager Dropdown -->
                <div class="lg:col-span-1 text-sm relative" x-data="{ open: false, selected: '{{ request('project_manager') ?? 'Select Project Manager' }}' }">
                    <label for="project_manager" class="block text-sm font-medium text-gray-700">Project Manager</label>
                    <button @click="open = !open" type="button" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <span x-text="selected" class="block truncate"></span>
                        <span class="absolute inset-y-11 right-0 flex items-center pr-2 pointer-events-none">
                            <i class="fas fa-chevron-down text-orange-500"></i>
                        </span>
                    </button>

                    <ul x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                        <li @click="selected = 'Select Project Manager'; open = false; $refs.project_manager.value = ''" class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center">
                            <i class="fas fa-user-tie mr-2 text-orange-500 group-hover:text-white"></i> Select Project Manager
                        </li>
                        @foreach($projectManagers as $manager)
                            <li @click="selected = '{{ $manager->user->name }}'; open = false; $refs.project_manager.value = '{{ $manager->user->name }}'" class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center">
                                <i class="fas fa-user-tie mr-2 text-orange-500 group-hover:text-white"></i> {{ $manager->user->name }}
                            </li>
                        @endforeach
                    </ul>

                    <input type="hidden" name="project_manager" x-ref="project_manager" value="{{ request('project_manager') }}">
                </div>

                <!-- Status Dropdown -->
                <div class="lg:col-span-1 text-sm relative" x-data="{ open: false, selected: '{{ request('status') ?? 'Select Status' }}' }">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <button @click="open = !open" type="button" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <span x-text="selected" class="block truncate"></span>
                        <span class="absolute inset-y-11 right-0 flex items-center pr-2 pointer-events-none">
                            <i class="fas fa-chevron-down text-orange-500"></i>
                        </span>
                    </button>

                    <ul x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                        <li @click="selected = 'Select Status'; open = false; $refs.status.value = ''" class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center">
                            <i class="fas fa-tasks mr-2 text-orange-500 group-hover:text-white"></i> Select Status
                        </li>
                        <li @click="selected = 'In Progress'; open = false; $refs.status.value = 'In Progress'" class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center">
                            <i class="fas fa-spinner mr-2 text-orange-500 group-hover:text-white"></i> In Progress
                        </li>
                        <li @click="selected = 'Pending'; open = false; $refs.status.value = 'Pending'" class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center">
                            <i class="fas fa-hourglass-half mr-2 text-orange-500 group-hover:text-white"></i> Pending
                        </li>
                        <li @click="selected = 'Completed'; open = false; $refs.status.value = 'Completed'" class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center">
                            <i class="fas fa-check-circle mr-2 text-orange-500 group-hover:text-white"></i> Completed
                        </li>
                    </ul>

                    <input type="hidden" name="status" x-ref="status" value="{{ request('status') }}">
                </div>

                <!-- Search Button -->
                <div class="flex items-end">
                    <button type="submit" class="w-full lg:w-full lg:h-auto bg-green-500 text-white text-sm px-4 py-2 rounded hover:bg-green-600 transition flex items-center justify-center">
                        <i class="fas fa-search mr-1"></i> Search
                    </button>
                </div>

                <!-- Clear Button -->
                <div class="lg:col-span-1 flex items-end">
                    <a href="{{ route('admin.projects.index') }}" class="w-full lg:w-full lg:h-auto bg-gray-500 text-white text-sm px-4 py-2 rounded hover:bg-gray-600 transition flex items-center justify-center">
                        <i class="fas fa-times mr-2"></i> Clear
                    </a>
                </div>
            </div>
        </form>

        <!-- Projects Table -->
        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-200 uppercase text-xxs sm:text-xs leading-tight text-gray-600">
                    <tr>
                        <!-- ID Column -->
                        <th class="py-3 sm:py-4 px-2 sm:px-3 text-left w-12">
                            <i class="fas fa-hashtag"></i> 
                        </th>
                        <th class="py-3 sm:py-4 px-2 sm:px-4 text-left">
                            <i class="fas fa-tasks"></i> Project Name
                        </th>
                        <th class="py-3 sm:py-4 px-2 sm:px-4 text-left">
                            <i class="fas fa-building"></i> Department
                        </th>
                        <th class="py-3 sm:py-4 px-2 sm:px-4 text-left hidden md:table-cell">
                            <i class="fas fa-user"></i> Project Manager
                        </th>
                        <th class="py-3 sm:py-4 px-2 sm:px-4 text-left">
                            <i class="fas fa-info-circle"></i> Status
                        </th>
                        <th class="py-3 sm:py-4 px-2 sm:px-4 text-left hidden lg:table-cell">
                            <i class="fas fa-calendar-alt"></i> Start Date
                        </th>
                        <th class="py-3 sm:py-4 px-2 sm:px-4 text-left hidden lg:table-cell">
                            <i class="fas fa-calendar-alt"></i> End Date
                        </th>
                        <th class="py-3 sm:py-4 px-2 sm:px-4 text-center">
                            <i class="fas fa-tools"></i> Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="text-black text-xs lg:text-sm font-normal">
                    @foreach($projects as $project)
                        <tr class="border-b border-gray-200 hover:bg-gray-100 {{ $loop->iteration % 2 == 0 ? 'bg-gray-200' : '' }}">
                            <!-- ID Column -->
                            <td class="py-2 sm:py-3 px-2 sm:px-3">{{ $project->id }}</td>
                            <td class="py-2 sm:py-3 px-2 sm:px-6">{{ $project->name }}</td>
                            <td class="py-2 sm:py-3 px-2 sm:px-6">{{ $project->department->name ?? 'N/A' }}</td>
                            <td class="py-2 sm:py-3 px-2 sm:px-6 hidden md:table-cell">{{ $project->projectManager->user->name ?? 'N/A' }}</td>
                            <td class="py-2 sm:py-3 px-2 sm:px-6">{{ $project->status }}</td>
                            <td class="py-2 sm:py-3 px-2 sm:px-6 hidden lg:table-cell">{{ $project->start_date ? $project->start_date->format('Y-m-d') : 'Not Set' }}</td>
                            <td class="py-2 sm:py-3 px-2 sm:px-6 hidden lg:table-cell">{{ $project->end_date ? $project->end_date->format('Y-m-d') : 'Not Set' }}</td>
                            <td class="py-2 sm:py-3 px-2 sm:px-6 flex space-x-1 md:space-x-4">
                                <a href="{{ route('admin.projects.show', $project->id) }}" class="transform hover:text-blue-500 hover:scale-110">
                                    <i class="fas fa-eye text-orange-500 hover:text-blue-500"></i>
                                </a>
                                <a href="{{ route('admin.projects.edit', $project->id) }}" class="transform hover:text-yellow-500 hover:scale-110">
                                    <i class="fas fa-pen text-orange-500 hover:text-yellow-500"></i>
                                </a>
                                <form id="delete-form-{{ $project->id }}" action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <x-delete-button formId="delete-form-{{ $project->id }}" />
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <!-- Pagination -->
        <x-pagination>
            {{ $projects->appends(request()->query())->links('pagination::tailwind') }}
        </x-pagination>
        
    </div>
</div>
@endsection
