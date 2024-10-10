{{-- resources/views/admin/clients/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<!-- Use flex-col on small screens and flex-row on medium+ screens -->
<div class="flex h-screen">
    @include('partials.sidebar')

    <!-- Content area with responsive padding and flex-grow to take remaining space -->
    <div class="flex-grow p-4 md:p-6 bg-gray-100 overflow-auto">
        <x-title-with-back title="Edit Client" />

        @include('components.form.errors')

        <!-- Form for Editing Client and User -->
        <form action="{{ route('admin.clients.update', $client->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Responsive grid for form fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">
                
                <!-- Profile Image, spanning two columns on larger screens and one on smaller screens -->
                <div class="mb-4 col-span-1 md:col-span-2 flex justify-center">
                    <div class="text-center">
                        <!-- Hidden file input -->
                        <input type="file" name="image" id="image" class="hidden">
                        
                        <!-- Display current image or default -->
                        @if($client->user->image)
                            <img 
                                src="{{ asset('storage/' . $client->user->image) }}" 
                                alt="Image" 
                                class="mt-2 h-32 w-32 rounded-full object-cover cursor-pointer" 
                                id="image_preview"
                            >
                        @else
                            <img 
                                src="{{ asset('images/default_user_image.png') }}" 
                                alt="Default Image" 
                                class="mt-2 h-32 w-32 rounded-full object-cover cursor-pointer" 
                                id="image_preview"
                            >
                        @endif
                    </div>
                    <!-- Error message -->
                    @error('image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- User Name -->
                <div class="mb-4">
                    <label for="user_name" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-user mr-2"></i> User Name
                    </label>
                    <input type="text" name="user_name" id="user_name" value="{{ old('user_name', $client->user->name) }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('user_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- User Email -->
                <div class="mb-4">
                    <label for="user_email" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-envelope mr-2"></i> User Email
                    </label>
                    <input type="email" name="user_email" id="user_email" value="{{ old('user_email', $client->user->email) }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('user_email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- User Password (optional) -->
                <div class="mb-4">
                    <label for="user_password" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-lock mr-2"></i> Password (Leave blank to keep current)
                    </label>
                    <input type="password" name="user_password" id="user_password" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('user_password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- User Password Confirmation -->
                <div class="mb-4">
                    <label for="user_password_confirmation" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-lock mr-2"></i> Confirm Password
                    </label>
                    <input type="password" name="user_password_confirmation" id="user_password_confirmation" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('user_password_confirmation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gender Dropdown -->
                @include('components.form.gender', ['user' => $client->user])

                <!-- Company Name -->
                <div class="mb-4">
                    <label for="company_name" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-building mr-2"></i> Company Name
                    </label>
                    <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $client->company_name) }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('company_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Industry -->
                <div class="mb-4">
                    <label for="industry" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-industry mr-2"></i> Industry
                    </label>
                    <input type="text" name="industry" id="industry" value="{{ old('industry', $client->industry) }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('industry')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Number -->
                <div class="mb-4">
                    <label for="contact_number" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-phone-alt mr-2"></i> Contact Number
                    </label>
                    <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number', $client->contact_number) }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('contact_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-map-marker-alt mr-2"></i> Address
                    </label>
                    <input type="text" name="address" id="address" value="{{ old('address', $client->address) }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Website -->
                <div class="mb-4">
                    <label for="website" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-globe mr-2"></i> Website
                    </label>
                    <input type="url" name="website" id="website" value="{{ old('website', $client->website) }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('website')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <x-form.button-submit label="Update Client" />
        </form>
    </div>
</div>

<script>
    // Trigger the file input when the image is clicked
    document.getElementById('image_preview').addEventListener('click', function() {
        document.getElementById('image').click();
    });

    // Display the selected image immediately
    document.getElementById('image').addEventListener('change', function(event) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('image_preview').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    });
</script>
@endsection
