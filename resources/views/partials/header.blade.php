<header class="bg-gradient-to-r from-pink-600 to-orange-500 p-4 flex justify-between items-center shadow-md">
    <!-- Left Side: Logo and App Name -->
    <div class="flex items-center space-x-4">
        <!-- Sidebar Toggle Button -->
        <button @click="open = !open" class="text-white focus:outline-none transition-transform duration-300">
            <i :class="open ? 'fa-solid fa-list fa-lg transition-transform duration-200 hover:scale-110 ' : 'fa-solid fa-bars fa-lg transition-transform duration-200 hover:scale-110'"></i>
        </button>
        
        <!-- Logo and App Name -->
        <div :class="open ? 'flex items-center space-x-2 ml-4' : 'flex items-center space-x-2 ml-0'" class="transition-all duration-300">
            <img src="{{ asset('images/logo sms.png') }}" alt="Logo" class="w-8 h-8">
            <span class="text-white text-xl font-poppins hidden xxs:inline">SynergyMS</span>
        </div>
    </div>

    <!-- Right Side: User Profile Dropdown -->
    <div class="relative flex items-center space-x-2" x-data="{ openDropdown: false }">
        <!-- User Profile Image or Lottie Animation -->
        <div class="relative">
            @php
                $user = Auth::user();
                $isSuperAdmin = $user && $user->hasRole('Super Admin');
            @endphp

            @if($isSuperAdmin)
                <!-- Lottie Animation for Super Admin -->
                <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
                <dotlottie-player 
                    src="https://lottie.host/4c4c8f6b-cd11-4818-8620-bae9aef03b1c/RdIZRfrOvp.json" 
                    background="transparent" 
                    speed="1" 
                    style="width: 40px; height: 40px;" 
                    loop autoplay>
                </dotlottie-player>
            @else
                <!-- User's Profile Image for other roles -->
                @php
                    $profileImage = $user && $user->image ? asset('storage/' . $user->image) : asset('images/default_user_image.png');
                @endphp
                <img src="{{ $profileImage }}" alt="User Image" class="w-10 h-10 rounded-full">
            @endif

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
            <a href="#" class="group block px-4 py-2 text-black hover:bg-orange-500 hover:text-white flex items-center">
                <i class="fas fa-user mr-2 text-orange-500 group-hover:text-white"></i> Profile
            </a>
            <a href="#" class="group block px-4 py-2 text-black hover:bg-orange-500 hover:text-white flex items-center">
                <i class="fas fa-cog mr-2 text-orange-500 group-hover:text-white"></i> Settings
            </a>
            <a href="#" class="group block px-4 py-2 text-black hover:bg-orange-500 hover:text-white flex items-center">
                <i class="fas fa-bell mr-2 text-orange-500 group-hover:text-white"></i> Notifications
            </a>
            <a href="#" class="group block px-4 py-2 text-black hover:bg-orange-500 hover:text-white flex items-center">
                <i class="fas fa-question-circle mr-2 text-orange-500 group-hover:text-white"></i> Help & Support
            </a>

            <!-- Logout Form -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="group w-full text-left block px-4 py-2 text-black hover:bg-orange-500 hover:text-white flex items-center">
                    <i class="fas fa-sign-out-alt mr-2 text-orange-500 group-hover:text-white"></i> Logout
                </button>
            </form>
        </div>
    </div>
</header>
