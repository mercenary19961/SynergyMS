@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    @include('partials.sidebar')

    <div class="flex-1 p-6 bg-gray-100">
        <h1 class="mb-4 text-2xl font-semibold">Create Project Manager</h1>

        <!-- Error Message -->
        @if($errors->any())
            <div x-data="{ show: true }" x-show="show" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Whoops!</strong>
                <span class="block sm:inline">There were some problems with your input.</span>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-red-700 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Form for Creating Project Manager -->
        <form action="{{ route('admin.project-managers.store') }}" method="POST" x-data="projectManagerForm()">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- User Selection -->
                <div class="relative mb-4">
                    <label for="user_id" class="block text-sm font-medium text-gray-700">User</label>
                    <button type="button" @click="openUser = !openUser" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm px-3 py-2 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <span class="block truncate" x-text="selectedUser || 'Select User'"></span>
                        <span class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                            </svg>
                        </span>
                    </button>
                    <ul x-show="openUser" @click.away="openUser = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto">
                        @foreach($users as $user)
                            <li @click="selectedUser = '{{ $user->name }}'; $refs.user_id.value = '{{ $user->id }}'; openUser = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">
                                {{ $user->name }}
                            </li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="user_id" x-ref="user_id" value="{{ old('user_id') }}">
                    @error('user_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Department Selection -->
                <div class="relative mb-4">
                    <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
                    <button type="button" @click="openDepartment = !openDepartment" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm px-3 py-2 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <span class="block truncate" x-text="selectedDepartment || 'Select Department'"></span>
                        <span class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                            </svg>
                        </span>
                    </button>
                    <ul x-show="openDepartment" @click.away="openDepartment = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto">
                        @foreach($departments as $department)
                            <li @click="selectedDepartment = '{{ $department->name }}'; $refs.department_id.value = '{{ $department->id }}'; openDepartment = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">
                                {{ $department->name }}
                            </li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="department_id" x-ref="department_id" value="{{ old('department_id') }}">
                    @error('department_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Experience Years -->
                <div class="mb-4">
                    <label for="experience_years" class="block text-sm font-medium text-gray-700">Experience Years</label>
                    <input type="number" name="experience_years" id="experience_years" placeholder="Enter years of experience" value="{{ old('experience_years') }}" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('experience_years')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Number -->
                <div class="mb-4">
                    <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                    <input type="text" name="contact_number" id="contact_number" placeholder="Starts with country code e.g. +962" value="{{ old('contact_number') }}" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('contact_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-between mt-4">
                <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">
                    <i class="fas fa-save mr-2"></i>Create Project Manager
                </button>
                <a href="{{ route('admin.project-managers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    function projectManagerForm() {
        return {
            openUser: false,
            openDepartment: false,
            selectedUser: '{{ old('user_id') }}',
            selectedDepartment: '{{ old('department_id') }}'
        }
    }
</script>
@endsection
