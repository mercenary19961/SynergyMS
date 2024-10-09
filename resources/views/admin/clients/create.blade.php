{{-- resources/views/admin/clients/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    @include('partials.sidebar')

    <div class="flex-1 p-6 bg-gray-100">
        <h1 class="mb-4 text-2xl font-semibold">Add New Client</h1>

        @include('components.form.errors')

        <!-- Form -->
        <form action="{{ route('admin.clients.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Two-column Grid for User Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- User Name -->
                <div>
                    <label for="user_name" class="block text-sm font-medium text-gray-700">User Name</label>
                    <input type="text" name="user_name" id="user_name" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('user_name') }}" placeholder="Enter user name" required>
                </div>

                <!-- User Email -->
                <div>
                    <label for="user_email" class="block text-sm font-medium text-gray-700">User Email</label>
                    <input type="email" name="user_email" id="user_email" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('user_email') }}" placeholder="Enter user email" required>
                </div>

                <!-- User Password -->
                <div>
                    <label for="user_password" class="block text-sm font-medium text-gray-700">User Password</label>
                    <input type="password" name="user_password" id="user_password" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" placeholder="Enter password" required>
                </div>

                @include('components.form.gender')

                <!-- Profile Image -->
                <div>
                    <label for="profile_image" class="block text-sm font-medium text-gray-700">Profile Image</label>
                    <input type="file" name="profile_image" id="profile_image" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">
                </div>
            </div>

            <!-- Two-column Grid for Client Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Company Name -->
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                    <input type="text" name="company_name" id="company_name" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('company_name') }}" placeholder="Enter company name" required>
                </div>

                <!-- Industry -->
                <div>
                    <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
                    <input type="text" name="industry" id="industry" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('industry') }}" placeholder="Enter industry" required>
                </div>

                <!-- Contact Number -->
                <div>
                    <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                    <input type="text" name="contact_number" id="contact_number" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('contact_number') }}" placeholder="Enter contact number" required>
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" id="address" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('address') }}" placeholder="Enter address" required>
                </div>

                <!-- Website -->
                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                    <input type="url" name="website" id="website" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('website') }}" placeholder="Enter website URL">
                </div>
            </div>

            <!-- Submit Button and Back Button on the Same Row -->
            <div class="mt-6 flex justify-between items-center">
                <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition inline-flex items-center">
                    <i class="fas fa-save mr-2"></i> Add Client
                </button>
                <a href="{{ route('admin.clients.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
