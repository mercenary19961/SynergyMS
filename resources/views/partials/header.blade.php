<header class="bg-gradient-to-r from-pink-600 to-orange-500 p-4 flex justify-between items-center shadow-md">
    <!-- Left Side: Logo and App Name -->
    <div class="flex items-center space-x-4">
        <!-- Sidebar Toggle Button -->
        <button @click="open = !open" class="text-white focus:outline-none transition-transform duration-300">
            <i :class="open ? 'fa-solid fa-list fa-lg transition-transform duration-200 hover:scale-110 ' : 'fa-solid fa-bars fa-lg transition-transform duration-200 hover:scale-110'"></i>
        </button>
        
        <!-- Logo and App Name -->
        <div :class="open ? 'flex items-center space-x-2 ml-4' : 'flex items-center space-x-2 ml-0'" class="transition-all duration-300"> <!-- Adjusted margin based on state -->
            <img src="{{ asset('images/logo sms.png') }}" alt="Logo" class="w-8 h-8">
            <span class="text-white text-xl font-poppins hidden xxs:inline">SynergyMS</span> <!-- Hidden on smaller screens -->
        </div>
    </div>

    <!-- Right Side: User Profile Dropdown -->
    <div class="relative flex items-center space-x-2" x-data="{ openDropdown: false }">
        <!-- User Profile Image Container -->
        <div class="relative">
            @php
                $user = Auth::user();
                $profileImage = $user && $user->image ? asset('storage/' . $user->image) : asset('images/default_user_image.png');
            @endphp
            <!-- Display the user's profile image or a default image -->
            <img src="{{ $profileImage }}" alt="User Image" class="w-8 h-8 rounded-full">

            <!-- Online Indicator -->
            <div class="absolute bottom-0 right-0 bg-green-500 border-2 border-white w-3 h-3 rounded-full"></div>
        </div>

        <!-- User Name and Dropdown -->
        <button @click="openDropdown = !openDropdown" class="flex items-center space-x-1 focus:outline-none">
            <span class="text-white hidden md:inline">{{ $user->name ?? 'Guest' }}</span>
            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a 1 1 0 01-1.414 0l-4-4a 1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <div x-show="openDropdown" 
            @click.away="openDropdown = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="absolute right-0 top-10 mt-2 w-40 bg-white text-black rounded-lg shadow-lg z-10">
        <a href="#" class="block px-4 py-2 text-black hover:bg-orange-500 hover:text-white">Profile</a>
        <a href="#" class="block px-4 py-2 text-black hover:bg-orange-500 hover:text-white">Settings</a>
        <a href="#" class="block px-4 py-2 text-black hover:bg-orange-500 hover:text-white">Notifications</a>
        <a href="#" class="block px-4 py-2 text-black hover:bg-orange-500 hover:text-white">Help & Support</a>
    
        <!-- Logout Form -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left block px-4 py-2 text-black hover:bg-orange-500 hover:text-white">Logout</button>
        </form>
    </div>
    </div>
</header>
