@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <div class="flex-1 p-6 bg-gray-100 overflow-auto">
        <x-title-with-back title="Add New Employee" />

        @include('components.form.errors')

        <form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data" x-data="employeeForm({{ $departments->toJson() }})">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Employee Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-user text-gray-600 mr-1"></i> Name
                    </label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" value="{{ old('name') }}" placeholder="Enter Employee Name">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-envelope text-gray-600 mr-1"></i> Email
                    </label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" value="{{ old('email') }}" placeholder="Enter Email">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-lock text-gray-600 mr-1"></i> Password
                    </label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" placeholder="Enter Password">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Salary -->
                <div class="mb-4">
                    <label for="salary" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-money-bill-wave text-gray-600 mr-1"></i> Salary
                    </label>
                    <input type="number" name="salary" id="salary" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" value="{{ old('salary') }}" placeholder="Enter Salary">
                    @error('salary')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @include('components.form.gender')

                <!-- Nationality -->
                <div class="mb-4">
                    <label for="nationality" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-flag text-gray-600 mr-1"></i> Nationality
                    </label>
                    <input type="text" name="nationality" id="nationality" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" value="{{ old('nationality') }}" placeholder="Enter Nationality">
                    @error('nationality')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Age -->
                <div class="mb-4">
                    <label for="age" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-calendar-alt text-gray-600 mr-1"></i> Age
                    </label>
                    <input type="number" name="age" id="age" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" value="{{ old('age') }}" placeholder="Enter Age">
                    @error('age')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-phone text-gray-600 mr-1"></i> Phone
                    </label>
                    <input type="text" name="phone" id="phone" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" value="{{ old('phone') }}" placeholder="Enter Phone Number">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-map-marker-alt text-gray-600 mr-1"></i> Address
                    </label>
                    <input type="text" name="address" id="address" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" placeholder="Enter Address" value="{{ old('address') }}">
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Department Dropdown -->
                <div class="relative mb-4">
                    <label for="department_id" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-building text-gray-600 mr-1"></i> Department
                    </label>
                    <button @click="open = !open" type="button" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <span class="block truncate" x-text="selectedDepartment.name || 'Select Department'"></span>
                        <span class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a 1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>

                    <ul x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                        <template x-for="department in departments" :key="department.id">
                            <li @click="selectDepartment(department)" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">
                                <span x-text="department.name"></span>
                            </li>
                        </template>
                    </ul>

                    <input type="hidden" name="department_id" x-ref="department_id" :value="selectedDepartment.id">
                    @error('department_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Position Dropdown -->
                <div class="relative mb-4">
                    <label for="position" class="block text-sm font-medium text-gray-700"><i class="fas fa-briefcase text-gray-600 mr-1"></i> Position</label>
                    <button 
                        @click="openPosition = !openPosition" 
                        type="button" 
                        class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500"
                    >
                        <span class="block truncate" x-text="selectedPosition.name || 'Select Position'"></span>
                        <span class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a 1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>
                
                    <ul x-show="openPosition" @click.away="openPosition = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                        <template x-for="position in positions" :key="position.id">
                            <li @click="selectPosition(position)" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">
                                <span x-text="position.name"></span>
                            </li>
                        </template>
                    </ul>
                
                    <!-- Hidden input for position_id -->
                    <input type="hidden" name="position_id" x-ref="position_id" :value="selectedPosition.id">
                    @error('position_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                

                <!-- Employee Image -->
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-camera text-gray-600 mr-1"></i> Employee Image
                    </label>
                    <input type="file" name="image" id="image" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none">
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>                

                <!-- Date of Birth -->
                <div class="mb-4">
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-birthday-cake text-gray-600 mr-1"></i> Date of Birth
                    </label>
                    <input type="date" name="date_of_birth" id="date_of_birth" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" value="{{ old('date_of_birth') }}" min="1960-01-01" max="2010-01-01">
                    @error('date_of_birth')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date of Joining -->
                <div class="mb-4">
                    <label for="date_of_joining" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-calendar-check text-gray-600 mr-1"></i> Date of Joining
                    </label>
                    <input type="date" name="date_of_joining" id="date_of_joining" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" value="{{ old('date_of_joining') }}">
                    @error('date_of_joining')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <x-form.button-submit label="Add Employee" />
        </form>
    </div>
</div>

<script>
function employeeForm(departments) {
    return {
        open: false,
        openPosition: false,
        selectedDepartment: '',
        selectedPosition: null,
        departments: departments,
        positions: [],

        // When a department is selected, fetch its positions
        selectDepartment(department) {
            this.selectedDepartment = department;
            this.positions = department.positions;
            this.selectedPosition = null; // Reset selected position
        },

        // Select a position
        selectPosition(position) {
            this.selectedPosition = position;
        },
    };
}


    document.addEventListener('DOMContentLoaded', function() {
        const dobField = document.getElementById('date_of_birth');
        if (!dobField.value) {
            dobField.value = '1990-01-01';
        }
    });
</script>

@endsection
