@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">
        @include('components.form.success')

        <!-- Header Row -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold">Projects</h1>
            <a href="{{ route('admin.projects.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">
                <i class="fas fa-plus mr-2"></i>Add New Project
            </a>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.projects.index') }}" class="mb-4 text-sm">
            <div class="grid grid-cols-2 lg:grid-cols-6 gap-2 mb-4">
                
                <!-- Project Name Field -->
                <div class="lg:col-span-1">
                    <label for="name" class="block text-xs font-medium text-gray-700">Project Name</label>
                    <input type="text" name="name" id="name" value="{{ request('name') }}" placeholder="Project Name" class="mt-1 py-2 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-1.5">
                </div>

                <!-- Department Dropdown -->
                <div class="lg:col-span-1 text-sm">
                    <div x-data="{ open: false, selected: '{{ request('department') ?? 'Select Department' }}' }" class="relative text-sm">
                        <label for="department" class="block text-xs font-medium text-gray-700">Department</label>
                        <button 
                            @click="open = !open" 
                            type="button" 
                            aria-haspopup="listbox" 
                            :aria-expanded="open" 
                            class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500"
                        >
                            <span class="block truncate" x-text="selected"></span>
                            <span class="flex items-center">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a 1 1 0 01-1.414 0l-4-4a 1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>

                        <!-- Dropdown Menu -->
                        <ul 
                            x-show="open" 
                            @click.away="open = false" 
                            class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm" 
                            role="listbox"
                            x-transition
                            x-cloak
                        >
                            <li 
                                @click="selected = 'Select Department'; open = false" 
                                class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center group"
                            >
                                <i class="fas fa-building mr-2 text-orange-500 group-hover:text-white"></i> Select Department
                            </li>
                            @foreach($departments as $department)
                                <li 
                                    @click="selected = '{{ $department->name }}'; open = false" 
                                    class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center group"
                                >
                                    @if($department->name == 'Software Development')
                                        <i class="fas fa-code mr-2 text-orange-500 group-hover:text-white"></i>
                                    @elseif($department->name == 'Network Engineering')
                                        <i class="fas fa-network-wired mr-2 text-orange-500 group-hover:text-white"></i>
                                    @elseif($department->name == 'Data Analysis')
                                        <i class="fas fa-chart-bar mr-2 text-sm text-orange-500 group-hover:text-white"></i>
                                    @elseif($department->name == 'Technical Support')
                                        <i class="fas fa-headset mr-2 text-sm text-orange-500 group-hover:text-white"></i>
                                    @elseif($department->name == 'Quality Assurance')
                                        <i class="fas fa-check-circle mr-2 text-sm text-orange-500 group-hover:text-white"></i>
                                    @elseif($department->name == 'UX/UI')
                                        <i class="fas fa-paint-brush mr-2 text-sm text-orange-500 group-hover:text-white"></i>
                                    @else
                                        <i class="fas fa-building mr-2 text-sm text-orange-500 group-hover:text-white"></i>
                                    @endif
                                    {{ $department->name }}
                                </li>
                            @endforeach
                        </ul>

                        <!-- Hidden Input to Submit the Selected Value -->
                        <input type="hidden" name="department" :value="selected === 'Select Department' ? '' : selected">
                    </div>
                </div>

<!-- Project Manager Dropdown -->
<div class="lg:col-span-1">
    <div x-data="{ open: false, selected: '{{ request('project_manager_name') ?? 'Select Project Manager' }}' }" class="relative">
        <label for="project_manager_name" class="block text-xs font-medium text-gray-700">Project Manager</label>
        <button 
            @click="open = !open" 
            type="button" 
            aria-haspopup="listbox" 
            :aria-expanded="open" 
            class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500"
        >
            <span class="block truncate" x-text="selected"></span>
            <span class="flex items-center">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a 1 1 0 01-1.414 0l-4-4a 1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </span>
        </button>

        <!-- Dropdown Menu -->
        <ul 
            x-show="open" 
            @click.away="open = false" 
            class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm" 
            role="listbox"
            x-transition
            x-cloak
        >
            <li 
                @click="selected = 'Select Project Manager'; open = false" 
                class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center group"
            >
                <i class="fas fa-user mr-2 text-orange-500 group-hover:text-white"></i> Select Project Manager
            </li>
            @foreach($projectManagers as $manager)
                <li 
                    @click="selected = '{{ $manager->user->name }}'; open = false" 
                    class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center group"
                >
                    <i class="fas fa-user-tie mr-2 text-orange-500 group-hover:text-white"></i>
                    {{ $manager->user->name }}
                </li>
            @endforeach
        </ul>

        <!-- Hidden Input to Submit the Selected Value -->
        <input type="hidden" name="project_manager_name" :value="selected === 'Select Project Manager' ? '' : selected">
    </div>
</div>


                <!-- Status Dropdown -->
                <div class="lg:col-span-1">
                    <div x-data="{ open: false, selected: '{{ request('status') ?? 'Select Status' }}' }" class="relative">
                        <label for="status" class="block text-xs font-medium text-gray-700">Status</label>
                        <button 
                            @click="open = !open" 
                            type="button" 
                            aria-haspopup="listbox" 
                            :aria-expanded="open" 
                            class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500"
                        >
                            <span class="block truncate" x-text="selected"></span>
                            <span class="flex items-center">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a 1 1 0 01-1.414 0l-4-4a 1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>

                        <!-- Dropdown Menu -->
                        <ul 
                            x-show="open" 
                            @click.away="open = false" 
                            class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm" 
                            role="listbox"
                            x-transition
                            x-cloak
                        >
                            <li 
                                @click="selected = 'Select Status'; open = false" 
                                class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center group"
                            >
                                <i class="fas fa-tasks mr-2 text-orange-500 group-hover:text-white"></i> Select Status
                            </li>
                            <li 
                                @click="selected = 'In Progress'; open = false" 
                                class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center group"
                            >
                                <i class="fas fa-spinner mr-2 text-orange-500 group-hover:text-white"></i> In Progress
                            </li>
                            <li 
                                @click="selected = 'Pending'; open = false" 
                                class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center group"
                            >
                                <i class="fas fa-hourglass-half mr-2 text-orange-500 group-hover:text-white"></i> Pending
                            </li>
                            <li 
                                @click="selected = 'Completed'; open = false" 
                                class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center group"
                            >
                                <i class="fas fa-check-circle mr-2 text-orange-500 group-hover:text-white"></i> Completed
                            </li>
                        </ul>

                        <!-- Hidden Input to Submit the Selected Value -->
                        <input type="hidden" name="status" :value="selected === 'Select Status' ? '' : selected">
                    </div>
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
                <thead class="bg-gray-200 uppercase text-[10px] sm:text-[10px] leading-tight text-gray-600">
                    <tr>
                        <th class="py-3 sm:py-4 px-2 sm:px-4 text-left">
                            <i class="fas fa-hashtag"></i> Project Name
                        </th>
                        <th class="py-3 sm:py-4 px-2 sm:px-4 text-left">
                            <i class="fas fa-building"></i> Department
                        </th>
                        <th class="py-3 sm:py-4 px-2 sm:px-4 text-left">
                            <i class="fas fa-user"></i> Project Manager
                        </th>
                        <th class="py-3 sm:py-4 px-2 sm:px-4 text-left">
                            <i class="fas fa-info-circle"></i> Status
                        </th>
                        <th class="py-3 sm:py-4 px-2 sm:px-4 text-left">
                            <i class="fas fa-calendar-alt"></i> Start Date
                        </th>
                        <th class="py-3 sm:py-4 px-2 sm:px-4 text-left">
                            <i class="fas fa-calendar-alt"></i> End Date
                        </th>
                        <th class="py-3 sm:py-4 px-2 sm:px-4 text-center">
                            <i class="fas fa-tools"></i> Actions
                        </th>
                    </tr>
                </thead>
                
                <tbody class="text-black text-xs sm:text-xs font-normal">
                    @foreach($projects as $project)
                        <tr class="border-b border-gray-200 hover:bg-gray-100 {{ $loop->iteration % 2 == 0 ? 'bg-gray-200' : '' }}">
                            <td class="py-2 sm:py-3 px-4 sm:px-6">{{ $project->name }}</td>
                            <td class="py-2 sm:py-3 px-4 sm:px-6">{{ $project->department->name ?? 'N/A' }}</td>
                            <td class="py-2 sm:py-3 px-4 sm:px-6">{{ $project->projectManager->user->name ?? 'N/A' }}</td>
                            <td class="py-2 sm:py-3 px-4 sm:px-6">{{ $project->status }}</td>
                            <td class="py-2 sm:py-3 px-4 sm:px-6">{{ $project->start_date->format('Y-m-d') ?? 'N/A' }}</td>
                            <td class="py-2 sm:py-3 px-4 sm:px-6">{{ $project->end_date->format('Y-m-d') ?? 'N/A' }}</td>
                            <td class="py-2 sm:py-3 px-4 sm:px-6 flex space-x-4">
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
