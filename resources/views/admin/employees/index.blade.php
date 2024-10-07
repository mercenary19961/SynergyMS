{{-- resources/views/admin/employees/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    {{-- Initialize viewMode based on the 'view' query parameter with default 'grid' --}}
    <div 
        class="flex-1 p-6 bg-gray-100 overflow-auto" 
        x-data="employeeView('{{ request('view', 'grid') }}')"
    >
        <!-- Loading Indicator -->
        <div x-show="isLoading" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="loader ease-linear rounded-full border-8 border-t-8 border-gray-200 h-16 w-16"></div>
        </div>

        <!-- Header Row -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h1 class="text-2xl font-semibold mb-4 md:mb-0">Employees</h1>
            
            <div class="flex space-x-2">
                <!-- Grid View Button -->
                <button 
                    @click="setViewMode('grid')"
                    :class="viewMode === 'grid' 
                        ? 'bg-orange-500 text-white' 
                        : 'bg-white text-gray-700 hover:bg-orange-500 hover:text-white'"
                    class="px-4 py-2 rounded transition"
                >
                    <i class="fas fa-th"></i>
                </button>

                <!-- List View Button -->
                <button 
                    @click="setViewMode('list')"
                    :class="viewMode === 'list' 
                        ? 'bg-orange-500 text-white' 
                        : 'bg-white text-gray-700 hover:bg-orange-500 hover:text-white'"
                    class="px-4 py-2 rounded transition"
                >
                    <i class="fas fa-list"></i>
                </button>
                
                <!-- Add Employee Button -->
                <a href="{{ route('admin.employees.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i> Add Employee
                </a>
            </div>
        </div>

        <!-- Search Row -->
        <form method="GET" action="{{ route('admin.employees.index') }}" class="mb-6" @submit="isLoading = true">
            <div class="flex flex-col md:flex-row md:items-end md:space-x-4 space-y-4 md:space-y-0">
                <div class="flex-1">
                    <label for="employee_id" class="block text-sm font-medium text-gray-700">Employee ID</label>
                    <input type="number" name="employee_id" id="employee_id" value="{{ request('employee_id') }}" placeholder="Employee ID" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">
                </div>
                
                <div class="flex-1">
                    <label for="employee_name" class="block text-sm font-medium text-gray-700">Employee Name</label>
                    <input type="text" name="employee_name" id="employee_name" value="{{ request('employee_name') }}" placeholder="Employee Name" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">
                </div>
                
                <div class="flex-1">
                    <div x-data="{ open: false, selected: '{{ request('position') ?? 'Select Position' }}' }" class="relative">
                        <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
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
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
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
                                @click="selected = 'Select Position'; open = false" 
                                class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white"
                            >
                                Select Position
                            </li>
                            @foreach($positions as $position)
                                <li 
                                    @click="selected = '{{ $position }}'; open = false" 
                                    class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white"
                                >
                                    {{ $position }}
                                </li>
                            @endforeach
                        </ul>

                        <!-- Hidden Input to Submit the Selected Value -->
                        <input type="hidden" name="position" :value="selected === 'Select Position' ? '' : selected">
                    </div>
                </div>
                
                <div class="flex-shrink-0 flex space-x-2">
                    <button type="submit" class="w-full md:w-auto bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition flex items-center">
                        <i class="fas fa-search mr-2"></i> Search
                    </button>
                    
                    <a href="{{ route('admin.employees.index') }}" class="w-full md:w-auto bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition flex items-center justify-center">
                        <i class="fas fa-times mr-2"></i> Clear
                    </a>
                </div>
            </div>
        </form>


        <!-- Employee Display -->
        <div>
            <!-- Grid View -->
            <div x-show="viewMode === 'grid'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($employees as $employee)
                    <div x-data="{ openDropdown: false }" class="bg-white p-4 rounded-lg shadow flex flex-col items-center relative">
                        <div class="absolute top-2 right-2">
                            <button @click="openDropdown = !openDropdown" class="text-gray-500 hover:text-gray-700 focus:outline-none" aria-haspopup="true" aria-expanded="openDropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div 
                                x-show="openDropdown" 
                                @click.away="openDropdown = false" 
                                @keydown.escape="openDropdown = false"
                                class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg py-1 z-50 transition-colors duration-200"
                                x-transition
                                x-cloak
                            >
                                <a href="{{ route('admin.employees.edit', $employee->id) }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-orange-500 hover:text-white flex items-center">
                                    <i class="fas fa-pen mr-2"></i> Edit
                                </a>
                                <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST" class="px-4 py-2 text-sm text-gray-700 hover:bg-orange-500 hover:text-white flex items-center">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        @click.prevent="if (confirm('Are you sure you want to delete this employee?')) $el.closest('form').submit();" 
                                        class="w-full text-left flex items-center"
                                    >
                                        <i class="fas fa-trash mr-2"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>

                        <img loading="lazy" src="{{ $employee->image ? asset('storage/' . $employee->image) : asset('images/default_user_image.png') }}" class="rounded-full w-24 h-24 object-cover">
                        <h3 class="mt-4 text-lg font-semibold">{{ $employee->user->name }}</h3>
                        <p class="text-gray-600">{{ $employee->position }}</p>
                    </div>
                @empty
                    <p class="text-center col-span-full text-gray-500">No employees found.</p>
                @endforelse
            </div>

            <!-- Pagination for Grid View -->
            <div x-show="viewMode === 'grid'" class="mt-4 flex justify-center">
                {{ $employees->appends(request()->except('page'))->appends(['view' => request('view', 'grid')])->links('pagination::tailwind') }}
            </div>

            <!-- List View -->
            <div x-show="viewMode === 'list'" class="space-y-4">
                <table class="min-w-full bg-white rounded-lg shadow">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-2 px-4 text-left">Name</th>
                            <th class="py-2 px-4 text-left">Employee ID</th>
                            <th class="py-2 px-4 text-left">Email</th>
                            <th class="py-2 px-4 text-left">Mobile</th>
                            <th class="py-2 px-4 text-left">Join Date</th>
                            <th class="py-2 px-4 text-left">Role</th>
                            <th class="py-2 px-4 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                            <tr class="border-t" x-data="{ openDropdown: false }">
                                <td class="py-2 px-4">
                                    <div class="flex items-center">
                                        <img loading="lazy" src="{{ $employee->image ? asset('storage/' . $employee->image) : asset('images/default_user_image.png') }}" class="rounded-full w-8 h-8 object-cover mr-2">
                                        <span>{{ $employee->user->name }}</span>
                                    </div>
                                </td>
                                <td class="py-2 px-4 text-center">{{ $employee->id }}</td>
                                <td class="py-2 px-4">{{ $employee->user->email }}</td>
                                <td class="py-2 px-4">{{ $employee->phone ?? 'N/A' }}</td>
                                <td class="py-2 px-4">{{ $employee->date_of_joining->format('d M Y') }}</td>
                                <td class="py-2 px-4">{{ $employee->position }}</td>
                                <td class="py-2 px-4 relative text-center">
                                    <button @click.prevent="openDropdown = !openDropdown" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div 
                                        x-show="openDropdown" 
                                        class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg py-1 z-50 transition-colors duration-200"
                                        @click.away="openDropdown = false" 
                                        @keydown.escape="openDropdown = false"
                                        x-transition
                                        x-cloak
                                    >
                                        <a href="{{ route('admin.employees.edit', $employee->id) }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-orange-500 hover:text-white flex items-center">
                                            <i class="fas fa-pen mr-2"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST" class="px-4 py-2 text-sm text-gray-700 hover:bg-orange-500 hover:text-white flex items-center">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                @click.prevent="if (confirm('Are you sure you want to delete this employee?')) $el.closest('form').submit();" 
                                                class="w-full text-left flex items-center"
                                            >
                                                <i class="fas fa-trash mr-2"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            <!-- Pagination for List View -->
            <div x-show="viewMode === 'list'" class="mt-4 flex justify-center">
                {{ $employees->appends(request()->except('page'))->appends(['view' => request('view', 'list')])->links('pagination::tailwind') }}
            </div>

            </div>
        </div>
    </div>

    <!-- Tailwind CSS Loader Styles -->
    <style>
        [x-cloak] { display: none !important; }
        .loader {
            border-top-color: #f97316;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>

    <!-- Alpine.js Component Script -->
    <script>
        function employeeView(initialView) {
            return {
                viewMode: initialView || 'grid', // Default to 'grid' if no view is provided
                isLoading: false,

                setViewMode(mode) {
                    if (this.viewMode !== mode) {
                        this.viewMode = mode;
                        this.updateURL(mode);
                    }
                },

                updateURL(mode) {
                    // Update the 'view' parameter in the URL
                    let url = new URL(window.location);
                    url.searchParams.set('view', mode);
                    
                    // Preserve existing query parameters and update the browser's history
                    window.history.replaceState({}, '', url);
                }
            }
        }
    </script>

@endsection
