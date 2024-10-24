@extends('layouts.app')

@section('content')
<div class="flex flex-col h-screen">
    <div class="flex-1 p-6 bg-gray-100">
        <x-title-with-back title="Add New Project Manager" />

        @include('components.form.errors')

        <!-- Form for Creating Project Manager and User -->
        <form action="{{ route('admin.project-managers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2">
                <!-- User Name -->
                <div class="mb-2">
                    <label for="user_name" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-user mr-2"></i> User Name
                    </label>
                    <input type="text" name="user_name" id="user_name" placeholder="Enter user name" value="{{ old('user_name') }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('user_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- User Email -->
                <div class="mb-2">
                    <label for="user_email" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-envelope mr-2"></i> User Email
                    </label>
                    <input type="email" name="user_email" id="user_email" placeholder="Enter user email" value="{{ old('user_email') }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('user_email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- User Password -->
                <div class="mb-2">
                    <label for="user_password" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-lock mr-2"></i> Password
                    </label>
                    <input type="password" name="user_password" id="user_password" placeholder="Enter password" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('user_password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- User Password Confirmation -->
                <div class="mb-2">
                    <label for="user_password_confirmation" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-lock mr-2"></i> Confirm Password
                    </label>
                    <input type="password" name="user_password_confirmation" id="user_password_confirmation" placeholder="Confirm password" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('user_password_confirmation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @include('components.form.gender')

                <!-- Profile Image -->
                <div class="mb-2">
                    <label for="image" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-camera mr-2"></i> Image
                    </label>
                    <input type="file" name="image" id="image" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <x-department-dropdown />

                <!-- Experience Years -->
                <div class="mb-2">
                    <label for="experience_years" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-history mr-2"></i> Experience Years
                    </label>
                    <input type="number" name="experience_years" id="experience_years" placeholder="Enter years of experience" value="{{ old('experience_years') }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('experience_years')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Number -->
                <div class="mb-2">
                    <label for="contact_number" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-phone-alt mr-2"></i> Contact Number
                    </label>
                    <input type="text" name="contact_number" id="contact_number" placeholder="Starts with country code e.g. +962" value="{{ old('contact_number') }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('contact_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <x-form.button-submit label="Add Project Manager" />
        </form>
    </div>
    <x-footer />
</div>
@endsection
