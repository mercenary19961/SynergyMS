@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <div class="flex-1 p-6 bg-gray-100">
        <!-- Dynamic Title with Back Button -->
        <x-title-with-back title="Add New HR Employee" />

        <!-- Include Validation Errors -->
        @include('components.form.errors')

        <!-- Form for Creating HR Employee -->
        <form action="{{ route('admin.human-resources.store') }}" method="POST" enctype="multipart/form-data" x-data="employeeForm({{ $departments->toJson() }})">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700"><i class="fas fa-user text-gray-600 mr-1"></i> Name</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" value="{{ old('name') }}" placeholder="Enter Employee Name">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700"><i class="fas fa-envelope text-gray-600 mr-1"></i> Email</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" value="{{ old('email') }}" placeholder="Enter Email">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700"><i class="fas fa-lock text-gray-600 mr-1"></i> Password</label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" placeholder="Enter Password">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @include('components.form.gender')

                <!-- Contact Number -->
                <div class="mb-2">
                    <label for="contact_number" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-phone-alt mr-2"></i> Contact Number
                    </label>
                    <input type="text" name="contact_number" id="contact_number" placeholder="Starts with country code e.g. +962" value="{{ old('contact_number') }}" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('contact_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Company Email -->
                <div class="mb-2">
                    <label for="company_email" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-envelope mr-2"></i> Company Email
                    </label>
                    <input type="email" name="company_email" id="company_email" placeholder="Enter company email" value="{{ old('company_email') }}" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('company_email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Profile Image -->
                <div class="mb-2">
                    <label for="image" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-camera mr-2"></i> Image
                    </label>
                    <input type="file" name="image" id="image" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Department Dropdown -->
                <div class="relative mb-4">
                    <label for="department_id" class="block text-sm font-medium text-gray-700"><i class="fas fa-building text-gray-600 mr-1"></i> Department</label>
                    <button 
                        @click="open = !open" 
                        type="button" 
                        class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500"
                    >
                        <span class="block truncate" x-text="selectedDepartment || 'Select Department'"></span>
                        <span class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a 1 1 0 111.414 1.414l-4 4a 1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>

                    <ul 
                        x-show="open" 
                        @click.away="open = false" 
                        class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                        role="listbox"
                    >
                        @foreach($departments as $department)
                            <li 
                                @click="selectedDepartment = '{{ $department->name }}'; selectedDepartmentId = '{{ $department->id }}'; updatePositions({{ $department->positions->pluck('name', 'id') }}); open = false"
                                class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white"
                            >
                                {{ $department->name }}
                            </li>
                        @endforeach
                    </ul>

                    <input type="hidden" name="department_id" :value="selectedDepartmentId">
                    @error('department_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Position Dropdown -->
                <div class="relative mb-4">
                    <label for="position_id" class="block text-sm font-medium text-gray-700"><i class="fas fa-briefcase text-gray-600 mr-1"></i> Position</label>
                    <button 
                        @click="openPosition = !openPosition" 
                        type="button" 
                        class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500"
                    >
                        <span class="block truncate" x-text="selectedPosition || 'Select Position'"></span>
                        <span class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a 1 1 0 111.414 1.414l-4 4a 1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>

                    <ul 
                        x-show="openPosition" 
                        @click.away="openPosition = false" 
                        class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                        role="listbox"
                    >
                        <template x-for="(positionName, positionId) in positions" :key="positionId">
                            <li 
                                @click="selectedPosition = positionName; selectedPositionId = positionId; openPosition = false" 
                                class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white"
                            >
                                <span x-text="positionName"></span>
                            </li>
                        </template>
                    </ul>

                    <input type="hidden" name="position_id" :value="selectedPositionId">
                    @error('position_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Submit Button -->
            <x-form.button-submit label="Add HR Employee" />
        </form>
    </div>
</div>

<script>
function employeeForm(departments) {
    return {
        open: false,
        openPosition: false,
        selectedDepartment: '',
        selectedDepartmentId: '',
        selectedPosition: '',
        selectedPositionId: '',
        positions: [],
        updatePositions(positions) {
            this.positions = positions;
            this.selectedPosition = ''; 
            this.selectedPositionId = ''; 
        }
    }
}


</script>
@endsection
