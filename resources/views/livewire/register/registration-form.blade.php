<div class="flex flex-col md:flex-row justify-center items-start min-h-screen bg-gray-100 px-6">
    <!-- Left Column: Common User Details -->
    <div class="bg-white p-10 rounded-lg shadow-lg max-w-md w-full mr-10 mt-12">
        <h2 class="text-3xl pb-3 mb-2 font-bold text-center bg-gradient-to-r from-pink-600 to-orange-500 bg-clip-text text-transparent">Registration</h2>
        <p class="text-center text-gray-500 mb-6">Add a new user</p>

        @if (session()->has('status'))
            <div class="mb-4 text-sm font-medium text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form wire:submit.prevent="submit" enctype="multipart/form-data">
            <!-- Common User Fields -->

            <!-- Name Field -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" wire:model="name" id="name" class="w-full px-4 py-2 border rounded-lg">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Email Field -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" wire:model="email" id="email" class="w-full px-4 py-2 border rounded-lg">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Password Field -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" wire:model="password" id="password" class="w-full px-4 py-2 border rounded-lg">
                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Gender Field -->
            <div class="mb-4">
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                <select wire:model="gender" id="gender" class="w-full px-4 py-2 border rounded-lg">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                @error('gender') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Role Selection Field -->
            <div class="mb-4">
                <label for="role_id" class="block text-sm font-medium text-gray-700">Role</label>
                <select wire:model="role_id" id="role_id" class="w-full px-4 py-2 border rounded-lg">
                    <option value="">Select Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
                @error('role_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Profile Image Field -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Profile Image</label>
                <input type="file" wire:model="image" id="image" class="w-full px-4 py-2 border rounded-lg">
                @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                @if ($image)
                    <div class="mt-2">
                        <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="h-20 w-20 object-cover rounded-full">
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-2 rounded-lg bg-gradient-to-r from-orange-500 to-pink-500 text-white hover:from-orange-600 hover:to-pink-600">Register</button>
        </form>
    </div>

    <!-- Right Column: Role-Specific Fields -->
    <div class="bg-white p-10 rounded-lg shadow-lg max-w-md w-full mt-12">
        @if ($role_id == 2)
            @livewire('register.client-component')
        @elseif ($role_id == 3)
            @livewire('register.project-manager-component')
        @elseif ($role_id == 4)
            @livewire('register.hr-component')
        @elseif ($role_id == 5)
            @livewire('register.employee-component')
        @endif
    </div>

</div>
