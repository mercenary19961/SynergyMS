@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    @include('partials.sidebar')

    <div class="flex-1 p-6 bg-gray-100">
        @include('components.form.success')
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold flex items-center">
                <i class="fas fa-user-tie mr-2 hover:text-orange-500"></i> Project Managers
            </h1>
            <a href="{{ route('admin.project-managers.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">
                <i class="fas fa-plus mr-2"></i>Add New Project Manager
            </a>
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.project-managers.index') }}" class="mb-6">
            <div class="flex flex-col md:flex-row md:items-end md:space-x-4 space-y-4 md:space-y-0">
                <!-- User Name Field -->
                <div class="flex-1">
                    <label for="name" class="block text-sm font-medium text-gray-700">User Name</label>
                    <input type="text" name="name" id="name" value="{{ request('name') }}" placeholder="User Name" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">
                </div>

                <!-- Department Dropdown -->
                <div class="flex-1">
                    <div x-data="{ open: false, selected: '{{ request('department') ?? 'Select Department' }}' }" class="relative">
                        <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
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
                                        <i class="fas fa-chart-bar mr-2 text-orange-500 group-hover:text-white"></i>
                                    @elseif($department->name == 'Technical Support')
                                        <i class="fas fa-headset mr-2 text-orange-500 group-hover:text-white"></i>
                                    @elseif($department->name == 'Quality Assurance')
                                        <i class="fas fa-check-circle mr-2 text-orange-500 group-hover:text-white"></i>
                                    @elseif($department->name == 'UX/UI')
                                        <i class="fas fa-paint-brush mr-2 text-orange-500 group-hover:text-white"></i>
                                    @else
                                        <i class="fas fa-building mr-2 text-orange-500 group-hover:text-white"></i>
                                    @endif
                                    {{ $department->name }}
                                </li>
                            @endforeach
                        </ul>

                        <!-- Hidden Input to Submit the Selected Value -->
                        <input type="hidden" name="department" :value="selected === 'Select Department' ? '' : selected">
                    </div>
                </div>

                <!-- Experience Years Field -->
                <div class="flex-1">
                    <label for="experience_years" class="block text-sm font-medium text-gray-700">Experience Years</label>
                    <input type="number" name="experience_years" id="experience_years" value="{{ request('experience_years') }}" placeholder="Minimum Experience Years" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">
                </div>

                <!-- Search and Clear Buttons -->
                <div class="flex-shrink-0 flex space-x-2">
                    <button type="submit" class="w-full md:w-auto bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition flex items-center">
                        <i class="fas fa-search mr-2"></i> Search
                    </button>

                    <a href="{{ route('admin.project-managers.index') }}" class="w-full md:w-auto bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition flex items-center justify-center">
                        <i class="fas fa-times mr-2"></i> Clear
                    </a>
                </div>
            </div>
        </form>

        <!-- Table with Project Managers -->
        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100 text-left text-gray-600 uppercase text-xs leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left"><i class="fas fa-hashtag mr-2"></i></th>
                        <th class="py-3 px-6 text-left"><i class="fas fa-user mr-2"></i>User Name</th>
                        <th class="py-3 px-6 text-left"><i class="fas fa-building mr-2"></i>Department</th>
                        <th class="py-3 px-6 text-left"><i class="fas fa-briefcase mr-2"></i>Experience Years</th>
                        <th class="py-3 px-6 text-left"><i class="fas fa-phone-alt mr-2"></i>Contact Number</th>
                        <th class="py-3 px-6 text-left"><i class="fas fa-tasks mr-2"></i>Assigned Projects</th>
                        <th class="py-3 px-6 text-center"><i class="fas fa-cogs mr-2"></i>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-black text-sm font-normal">
                    @foreach($projectManagers as $projectManager)
                        <tr class="border-b border-gray-200 hover:bg-gray-100 {{ $loop->iteration % 2 == 0 ? 'bg-gray-200' : '' }}">
                            <td class="py-3 px-6">{{ $projectManager->id }}</td>
                            <td class="py-3 px-6">{{ $projectManager->user->name }}</td>
                            <td class="py-3 px-6">{{ $projectManager->department->name }}</td>
                            <td class="py-3 px-6 text-center">{{ $projectManager->experience_years }}</td>
                            <td class="py-3 px-6">{{ $projectManager->contact_number }}</td>
                            <td class="py-3 px-6 text-center">{{ $projectManager->assigned_projects_count }}</td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center space-x-4">
                                    <a href="{{ route('admin.project-managers.show', $projectManager->id) }}" class="w-4 transform hover:text-blue-500 hover:scale-110">
                                        <i class="fas fa-eye fa-md text-orange-500 hover:text-blue-500"></i>
                                    </a>
                                    <a href="{{ route('admin.project-managers.edit', $projectManager->id) }}" class="w-4 transform hover:text-orange-500 hover:scale-110">
                                        <i class="fas fa-edit fa-md text-orange-500 hover:text-yellow-500"></i>
                                    </a>
                                    <form id="delete-form-{{ $projectManager->id }}" action="{{ route('admin.project-managers.destroy', $projectManager->id) }}" method="POST" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <x-delete-button formId="delete-form-{{ $projectManager->id }}" />
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <x-pagination>
            {{ $projectManagers->links('pagination::tailwind') }}
        </x-pagination>
    </div>
</div>

@endsection
