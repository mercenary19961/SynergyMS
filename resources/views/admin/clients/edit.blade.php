{{-- resources/views/admin/clients/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    @include('partials.sidebar')

    <div class="flex-1 p-6 bg-gray-100">
        <x-title-with-back title="Edit Client" route="admin.clients.index" />

        @include('components.form.errors')

        <!-- Form -->
        <form action="{{ route('admin.clients.update', $client->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Two-column Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- User Information Section -->
                <div>
                    <h2 class="text-lg font-semibold mb-2">User Information</h2>

                    <input type="hidden" name="user_id" value="{{ $client->user->id }}">

                    <!-- User Name -->
                    <div>
                        <label for="user_name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="user_name" id="user_name" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('user_name', $client->user->name) }}" required>
                    </div>

                    
                    <!-- User Email -->
                    <div>
                        <label for="user_email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="user_email" id="user_email" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('user_email', $client->user->email) }}" required>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="user_password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="user_password" id="user_password" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" placeholder="Enter new password">
                    </div>

                    <!-- Gender Dropdown -->
                    @include('components.form.gender')

                    <!-- Profile Image -->
                    <div>
                        <label for="profile_image" class="block text-sm font-medium text-gray-700">Profile Image</label>
                        <input type="file" name="profile_image" id="profile_image" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">
                        @if ($client->user->profile_image)
                            <img src="{{ asset('storage/' . $client->user->profile_image) }}" alt="Profile Image" class="mt-2 h-20 w-20 object-cover">
                        @endif
                    </div>
                </div>

                <!-- Client Information Section -->
                <div>
                    <h2 class="text-lg font-semibold mb-2">Client Information</h2>

                    <!-- Company Name -->
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                        <input type="text" name="company_name" id="company_name" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('company_name', $client->company_name) }}" required>
                    </div>

                    <!-- Industry -->
                    <div>
                        <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
                        <input type="text" name="industry" id="industry" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('industry', $client->industry) }}" required>
                    </div>

                    <!-- Contact Number -->
                    <div>
                        <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                        <input type="text" name="contact_number" id="contact_number" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('contact_number', $client->contact_number) }}" required>
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <input type="text" name="address" id="address" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('address', $client->address) }}" required>
                    </div>

                    <!-- Website -->
                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                        <input type="url" name="website" id="website" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('website', $client->website) }}">
                    </div>
                </div>
            </div>

            <x-form.button-submit label="Add Client" />
        </form>
    </div>
</div>
@endsection
