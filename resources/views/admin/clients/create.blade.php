@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    @include('partials.sidebar')

    <div class="flex-1 p-6 bg-gray-100">
        <x-title-with-back title="Add New Client" />

        @include('components.form.errors')

        <!-- Form for Creating Client and User -->
        <form action="{{ route('admin.clients.store') }}" method="POST" enctype="multipart/form-data">
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
                        <i class="fas fa-camera mr-2"></i> Profile Image
                    </label>
                    <input type="file" name="image" id="image" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 mt-6">
                <!-- Company Name -->
                <div class="mb-2">
                    <label for="company_name" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-building mr-2"></i> Company Name
                    </label>
                    <input type="text" name="company_name" id="company_name" placeholder="Enter company name" value="{{ old('company_name') }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('company_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Industry -->
                <div class="mb-2">
                    <label for="industry" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-industry mr-2"></i> Industry
                    </label>
                    <input type="text" name="industry" id="industry" placeholder="Enter industry" value="{{ old('industry') }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('industry')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Number -->
                <div class="mb-2">
                    <label for="contact_number" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-phone-alt mr-2"></i> Contact Number
                    </label>
                    <input type="text" name="contact_number" id="contact_number" placeholder="Enter contact number" value="{{ old('contact_number') }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('contact_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="mb-2">
                    <label for="address" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-map-marker-alt mr-2"></i> Address
                    </label>
                    <input type="text" name="address" id="address" placeholder="Enter address" value="{{ old('address') }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Website -->
                <div class="mb-2">
                    <label for="website" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-globe mr-2"></i> Website
                    </label>
                    <input type="url" name="website" id="website" placeholder="Enter website URL" value="{{ old('website') }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('website')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <x-form.button-submit label="Add Client" />
        </form>
    </div>
</div>
@endsection
