@extends('layouts.app')

@section('content')
<!-- Use flex-col on small screens and flex-row on medium+ screens -->
<div class="flex h-screen">
    @include('partials.sidebar')

    <!-- Content area with responsive padding and flex-grow to take remaining space -->
    <div class="flex-grow p-4 md:p-6 bg-gray-100 overflow-auto">
        <x-title-with-back title="Edit Project Manager" />

        @include('components.form.errors')

        <!-- Form for Editing Project Manager and User -->
        <form action="{{ route('admin.project-managers.update', $projectManager->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Responsive grid for form fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                
                <!-- Profile Image, spanning two columns on larger screens and one on smaller screens -->
                <div class="mb-4 col-span-1 md:col-span-2 flex justify-center">
                    <div class="text-center">
                        <!-- Hidden file input -->
                        <input type="file" name="image" id="image" class="hidden">
                        
                        <!-- Display current image or default -->
                        @if($projectManager->user->image)
                            <img 
                                src="{{ asset('storage/' . $projectManager->user->image) }}" 
                                alt="Image" 
                                class="mt-2 h-32 w-32 rounded-full object-cover cursor-pointer" 
                                id="image_preview"
                            >
                        @else
                            <img 
                                src="{{ asset('images/default_user_image.png') }}" 
                                alt="DefaultImage" 
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
                    <label for="user_name" class="block text-sm font-medium text-gray-700">User Name</label>
                    <input type="text" name="user_name" id="user_name" value="{{ old('user_name', $projectManager->user->name) }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('user_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- User Email -->
                <div class="mb-4">
                    <label for="user_email" class="block text-sm font-medium text-gray-700">User Email</label>
                    <input type="email" name="user_email" id="user_email" value="{{ old('user_email', $projectManager->user->email) }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('user_email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- User Password (optional) -->
                <div class="mb-4">
                    <label for="user_password" class="block text-sm font-medium text-gray-700">Password (Leave blank to keep current)</label>
                    <input type="password" name="user_password" id="user_password" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('user_password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- User Password Confirmation -->
                <div class="mb-4">
                    <label for="user_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="user_password_confirmation" id="user_password_confirmation" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('user_password_confirmation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @include('components.form.gender')

                <x-department-dropdown :selectedDepartment="$projectManager->department" />

                <!-- Experience Years -->
                <div class="mb-4">
                    <label for="experience_years" class="block text-sm font-medium text-gray-700">Experience Years</label>
                    <input type="number" name="experience_years" id="experience_years" value="{{ old('experience_years', $projectManager->experience_years) }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('experience_years')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Number -->
                <div class="mb-4">
                    <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                    <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number', $projectManager->contact_number) }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                    @error('contact_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <x-form.button-submit label="Update Project Manager" />
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
