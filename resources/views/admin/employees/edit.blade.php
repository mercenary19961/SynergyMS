@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100 overflow-auto">
        <h1 class="mb-4 text-2xl font-semibold">Edit Employee</h1>

        @include('components.form.errors')

        <!-- Display Current Employee Image -->
        @if ($employee->image)
            <div class="mb-2">
                <label class="block text-sm font-medium text-gray-700">Current Image</label>
                <img src="{{ asset('storage/' . $employee->image) }}" alt="Employee Image" class="mt-1 w-32 h-32 rounded-md object-cover">
            </div>
        @endif

        <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data" x-data="employeeForm({{ $departments->toJson() }}, {{ $employee->department->positions->pluck('name') }})">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" value="{{ old('name', $employee->user->name) }}" placeholder="Enter Employee Name">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" value="{{ old('email', $employee->user->email) }}" placeholder="Enter Email">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" placeholder="Enter New Password (leave blank if no change)">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gender Dropdown -->
                @include('components.form.gender')

                <!-- Salary -->
                <div class="mb-4">
                    <label for="salary" class="block text-sm font-medium text-gray-700">Salary</label>
                    <input type="number" name="salary" id="salary" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" value="{{ old('salary', $employee->salary) }}" placeholder="Enter Salary">
                    @error('salary')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nationality -->
                <div class="mb-4">
                    <label for="nationality" class="block text-sm font-medium text-gray-700">Nationality</label>
                    <input type="text" name="nationality" id="nationality" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" value="{{ old('nationality', $employee->nationality) }}" placeholder="Enter Nationality">
                    @error('nationality')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Age -->
                <div class="mb-4">
                    <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                    <input type="number" name="age" id="age" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" value="{{ old('age', $employee->age) }}" placeholder="Enter Age">
                    @error('age')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" id="phone" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" value="{{ old('phone', $employee->phone) }}" placeholder="Enter Phone Number">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" id="address" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" placeholder="Enter Address" value="{{ old('address', $employee->address) }}">
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Department Dropdown -->
                <div class="relative mb-4">
                    <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
                    <button 
                        @click="open = !open" 
                        type="button" 
                        class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500"
                    >
                        <span class="block truncate" x-text="selectedDepartment || 'Select Department'"></span>
                        <span class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>

                    <!-- Department Dropdown Menu -->
                    <ul 
                        x-show="open" 
                        @click.away="open = false" 
                        class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                        role="listbox"
                    >
                        @foreach($departments as $department)
                            <li 
                                @click="selectedDepartment = '{{ $department->name }}'; $refs.department_id.value = '{{ $department->id }}'; updatePositions({{ $department->positions->pluck('name') }}); open = false"
                                class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white"
                            >
                                {{ $department->name }}
                            </li>
                        @endforeach
                    </ul>

                    <!-- Hidden Input to store selected department id -->
                    <input type="hidden" name="department_id" x-ref="department_id" :value="{{ old('department_id', $employee->department_id) }}">
                    @error('department_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Position Dropdown -->
                <div class="relative mb-4">
                    <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                    <button 
                        @click="openPosition = !openPosition" 
                        type="button" 
                        class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500"
                    >
                        <span class="block truncate" x-text="selectedPosition || 'Select Position'"></span>
                        <span class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>

                    <!-- Position Dropdown Menu -->
                    <ul 
                        x-show="openPosition" 
                        @click.away="openPosition = false" 
                        class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                        role="listbox"
                    >
                        <template x-for="position in positions" :key="position">
                            <li 
                                @click="selectedPosition = position; openPosition = false" 
                                class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white"
                            >
                                <span x-text="position"></span>
                            </li>
                        </template>
                    </ul>
                    <input type="hidden" name="position" :value="selectedPosition">
                    @error('position')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Employee Image Upload -->
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Employee Image</label>
                    <input type="file" name="image" id="image" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none">
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Date of Birth -->
                <div class="mb-4">
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" value="{{ old('date_of_birth', $employee->date_of_birth->format('Y-m-d')) }}" min="1960-01-01" max="2010-01-01">
                    @error('date_of_birth')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date of Joining -->
                <div class="mb-4">
                    <label for="date_of_joining" class="block text-sm font-medium text-gray-700">Date of Joining</label>
                    <input type="date" name="date_of_joining" id="date_of_joining" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" value="{{ old('date_of_joining', $employee->date_of_joining->format('Y-m-d')) }}">
                    @error('date_of_joining')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">
                    <i class="fas fa-save mr-2"></i>Update Employee
                </button>
                <a href="{{ route('admin.employees.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    function employeeForm(departments, positions) {
        return {
            open: false,
            openPosition: false,
            selectedDepartment: '{{ old('department_id', $employee->department->name) }}',
            selectedPosition: '{{ old('position', $employee->position) }}',
            positions: positions || [],
            updatePositions(positions) {
                this.positions = positions;
                this.selectedPosition = ''; // Reset position selection when department changes
            }
        }
    }
</script>

@endsection
