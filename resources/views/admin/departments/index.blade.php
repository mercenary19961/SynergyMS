@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    @include('partials.sidebar')

    <div class="flex-1 p-6 bg-gray-100">
        @include('components.form.success')

        <!-- Header with Title and Add Button -->
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">
                <i class="fas fa-building mr-2 text-orange-500"></i> Departments
            </h1>
        
            <a href="{{ route('admin.departments.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition inline-flex items-center">
                <i class="fas fa-plus-circle mr-2"></i> Add New Department
            </a>
        </div>

        <form method="GET" action="{{ route('admin.departments.index') }}" class="mb-6">
            <div class="flex flex-col md:flex-row md:items-end md:space-x-4 space-y-4 md:space-y-0">
                <!-- Filter by Department Name -->
                <div class="flex-1">
                    <label for="department_name" class="block text-sm font-medium text-gray-700">Department Name</label>
                    <input type="text" name="department_name" id="department_name" value="{{ request('department_name') }}" placeholder="Enter Department Name" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">
                </div>
        
                <!-- Filter by Sector with Same Styling as Project Manager Dropdown -->
                <div class="flex-1 relative" x-data="{ open: false, selected: '{{ request('sector') ? ucfirst(request('sector')) : 'Select Sector' }}' }">
                    <label for="sector" class="block text-sm font-medium text-gray-700">Sector</label>
                    <button 
                        @click="open = !open" 
                        type="button" 
                        class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500"
                    >
                        <span x-text="selected" class="block truncate"></span>
                        <span class="absolute inset-y-11 right-0 flex items-center pr-2 pointer-events-none">
                            <i class="fas fa-chevron-down text-orange-500"></i>
                        </span>
                    </button>
        
                    <ul 
                        x-show="open" 
                        @click.away="open = false" 
                        class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                    >
                        <!-- Default option -->
                        <li 
                            @click="selected = 'Select Sector'; open = false; $refs.sector.value = ''" 
                            class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center"
                        >
                            <i class="fas fa-building mr-2 text-orange-500 group-hover:text-white"></i> Select Sector
                        </li>
        
                        <!-- Dynamic Sector options -->
                        @foreach($sectors as $sector)
                            <li 
                                @click="selected = '{{ ucfirst($sector) }}'; open = false; $refs.sector.value = '{{ $sector }}'" 
                                class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center"
                            >
                                <i class="fas fa-building mr-2 text-orange-500 group-hover:text-white"></i>
                                {{ ucfirst($sector) }}
                            </li>
                        @endforeach
                    </ul>
        
                    <!-- Hidden input to store selected sector's value -->
                    <input type="hidden" name="sector" x-ref="sector" value="{{ request('sector') }}">
                </div>
        
                <!-- Filter by Project Manager -->
                <div class="flex-1 relative" x-data="{ open: false, selected: '{{ request('project_manager') ? $projectManagers->firstWhere('id', request('project_manager'))->user->name ?? 'Select Manager' : 'Select Manager' }}' }">
                    <label for="project_manager" class="block text-sm font-medium text-gray-700">Project Manager</label>
                    <button 
                        @click="open = !open" 
                        type="button" 
                        class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500"
                    >
                        <span x-text="selected" class="block truncate"></span>
                        <span class="absolute inset-y-11 right-0 flex items-center pr-2 pointer-events-none">
                            <i class="fas fa-chevron-down text-orange-500"></i>
                        </span>
                    </button>
        
                    <ul 
                        x-show="open" 
                        @click.away="open = false" 
                        class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                    >
                        <!-- Default option -->
                        <li 
                            @click="selected = 'Select Manager'; open = false; $refs.project_manager.value = ''" 
                            class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center"
                        >
                            <i class="fas fa-user-tie mr-2 text-orange-500 group-hover:text-white"></i> Select Manager
                        </li>
        
                        <!-- Dynamic Project Manager options -->
                        @foreach($projectManagers as $manager)
                            <li 
                                @click="selected = '{{ $manager->user->name }}'; open = false; $refs.project_manager.value = '{{ $manager->id }}'" 
                                class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center"
                            >
                                <i class="fas fa-user-tie mr-2 text-orange-500 group-hover:text-white"></i>
                                {{ $manager->user->name }}
                            </li>
                        @endforeach
                    </ul>
        
                    <!-- Hidden input to store selected project manager's ID -->
                    <input type="hidden" name="project_manager" x-ref="project_manager" value="{{ request('project_manager') }}">
                </div>
        
                <!-- Search and Reset Buttons -->
                <div class="flex-shrink-0 flex space-x-2">
                    <button type="submit" class="w-full md:w-auto bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                        <i class="fas fa-search mr-2"></i> Search
                    </button>
        
                    <a href="{{ route('admin.departments.index') }}" class="w-full md:w-auto bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition flex items-center justify-center">
                        <i class="fas fa-times mr-2"></i> Clear
                    </a>
                </div>
            </div>
        </form>
        
        

        <!-- Table with Departments -->
        <div class="overflow-x-auto mt-4">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead class="bg-gray-100 text-left text-gray-600 uppercase text-xs leading-normal">
                    <tr>
                        <th class="py-2 px-4"><i class="fas fa-hashtag"></i></th>
                        <th class="py-2 px-4"><i class="fas fa-building"></i> Department Name</th>
                        <th class="py-2 px-4"><i class="fas fa-sitemap"></i> Sector</th>
                        <th class="py-2 px-4"><i class="fas fa-users"></i> Project Managers</th>
                        <th class="py-2 px-4"><i class="fas fa-info-circle"></i> Description</th>
                        <th class="py-2 px-4"><i class="fas fa-tools"></i> Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @foreach($departments as $index => $department)
                        <tr class="{{ $index % 2 == 1 ? 'bg-gray-100' : 'bg-white' }} border-t">
                            <td class="py-3 px-4">{{ $department->id }}</td>
                            <td class="py-3 px-4">{{ $department->name }}</td>
                            <td class="py-3 px-4">{{ ucfirst($department->sector) }}</td>

                            <!-- Associated Project Managers Column -->
                            <td class="py-3 px-4">
                                @if($department->project_manager)
                                    {{ $department->project_manager->user->name }}
                                @else
                                    <p class="text-gray-500">No manager assigned</p>
                                @endif
                            </td>

                            <!-- Description Column with Truncated Text -->
                            <td class="py-3 px-4">
                                <div class="truncate w-48" title="{{ $department->description }}">
                                    {{ $department->description }}
                                </div>
                            </td>

                            <!-- Actions Column -->
                            <td class="py-3 px-4 flex space-x-4">
                                <a href="{{ route('admin.departments.show', $department->id) }}" class="transform hover:text-blue-500 hover:scale-110">
                                    <i class="fas fa-eye fa-md text-orange-500 hover:text-blue-500"></i>
                                </a>
                                <a href="{{ route('admin.departments.edit', $department->id) }}" class="transform hover:text-orange-500 hover:scale-110">
                                    <i class="fas fa-pen fa-md text-orange-500 hover:text-yellow-500"></i>
                                </a>
                                <form id="delete-form-{{ $department->id }}" action="{{ route('admin.departments.destroy', $department->id) }}" method="POST" class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <x-delete-button formId="delete-form-{{ $department->id }}" />
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <x-pagination>
            {{ $departments->links('pagination::tailwind') }}
        </x-pagination>
    </div>
</div>
@endsection
