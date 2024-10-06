{{-- resources/views/admin/employees/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100 overflow-auto" x-data="{ viewMode: 'grid', isLoading: false }">
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
                    @click="viewMode = 'grid'"
                    :class="viewMode === 'grid' 
                        ? 'bg-orange-500 text-white' 
                        : 'bg-white text-gray-700 hover:bg-orange-500 hover:text-white'"
                    class="px-4 py-2 rounded transition"
                >
                    <i class="fas fa-th"></i>
                </button>

                <!-- List View Button -->
                <button 
                    @click="viewMode = 'list'"
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
                    <input type="number" name="employee_id" id="employee_id" value="{{ request('employee_id') }}" placeholder="Employee ID" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                </div>
                
                <div class="flex-1">
                    <label for="employee_name" class="block text-sm font-medium text-gray-700">Employee Name</label>
                    <input type="text" name="employee_name" id="employee_name" value="{{ request('employee_name') }}" placeholder="Employee Name" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                </div>
                
                <div class="flex-1">
                    <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                    <select name="position" id="position" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                        <option value="">Select Position</option>
                        @foreach($positions as $position)
                            <option value="{{ $position }}" {{ request('position') == $position ? 'selected' : '' }}>{{ $position }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex-shrink-0 flex space-x-2">
                    <!-- Search Button -->
                    <button type="submit" class="w-full md:w-auto bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition flex items-center">
                        <i class="fas fa-search mr-2"></i> Search
                    </button>
                    
                    <!-- Clear Button -->
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
                        <!-- Three-Dot Dropdown Button Positioned at Top Right -->
                        <div class="absolute top-2 right-2">
                            <button @click="openDropdown = !openDropdown" class="text-gray-500 hover:text-gray-700 focus:outline-none" aria-haspopup="true" aria-expanded="openDropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div 
                                x-show="openDropdown" 
                                @click.away="openDropdown = false" 
                                @keydown.escape="openDropdown = false"
                                class="absolute right-0 mt-2 w-34 bg-white rounded-md shadow-lg py-1 z-50"
                                x-transition
                                x-cloak
                            >
                                <a href="{{ route('admin.employees.edit', $employee->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                                <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full text-left">Delete</button>
                                </form>
                            </div>
                        </div>

                        <img src="{{ $employee->user->image ? asset($employee->user->image) : asset('images/default_user_image.png') }}" class="rounded-full w-24 h-24 object-cover">
                        <h3 class="mt-4 text-lg font-semibold">{{ $employee->user->name }}</h3>
                        <p class="text-gray-600">{{ $employee->position }}</p>
                    </div>
                @empty
                    <p class="text-center col-span-full text-gray-500">No employees found.</p>
                @endforelse
            </div>

            <!-- List View -->
            <div x-show="viewMode === 'list'" class="space-y-4">
                @forelse($employees as $employee)
                    <div x-data="{ openDropdown: false }" class="flex items-center bg-white p-4 rounded-lg shadow relative">
                        <!-- Three-Dot Dropdown Button Positioned at Top Right -->
                        <div class="absolute top-2 right-2">
                            <button @click="openDropdown = !openDropdown" class="text-gray-500 hover:text-gray-700 focus:outline-none" aria-haspopup="true" aria-expanded="openDropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div 
                                x-show="openDropdown" 
                                @click.away="openDropdown = false" 
                                @keydown.escape="openDropdown = false"
                                class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg py-1 z-50"
                                x-transition
                                x-cloak
                            >
                                <a href="{{ route('admin.employees.edit', $employee->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                                <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full text-left">Delete</button>
                                </form>
                            </div>
                        </div>

                        <!-- Employee Image -->
                        <img src="{{ $employee->user->image ? asset('storage/' . $employee->user->image) : asset('images/default_user_image.png') }}" class="rounded-full w-16 h-16 object-cover">
                        <!-- Employee Details -->
                        <div class="ml-4 flex-1">
                            <h3 class="text-lg font-semibold">{{ $employee->user->name }}</h3>
                            <p class="text-gray-600">{{ $employee->position }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500">No employees found.</p>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $employees->links() }}
            </div>
        </div>
    </div>
    
</div>

<!-- Tailwind CSS Loader Styles -->
<style>
    [x-cloak] { display: none !important; }
    /* Loader Styles */
    .loader {
        border-top-color: #f97316;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
@endsection
