@php
    $searchPages = [
        ['name' => 'Admin Dashboard', 'route' => route('admin.dashboard')],
        ['name' => 'Employees', 'route' => route('admin.employees.index')],
        ['name' => 'Attendance', 'route' => route('admin.attendance.index')],
        ['name' => 'Departments', 'route' => route('admin.departments.index')],
        ['name' => 'Tickets', 'route' => route('admin.tickets.index')],
        ['name' => 'Project Managers', 'route' => route('admin.project-managers.index')],
        ['name' => 'Clients', 'route' => route('admin.clients.index')],
        ['name' => 'Projects', 'route' => route('admin.projects.index')],
        ['name' => 'Human Resources', 'route' => route('admin.human-resources.index')],
    ];
@endphp

<script>
    window.searchPages = @json($searchPages);
</script>

<header class="bg-gradient-to-r from-pink-600 to-orange-500 p-4 flex justify-between items-center shadow-md">
    <div class="flex items-center space-x-4">
        <!-- Sidebar Toggle Button -->
        <button @click="toggleSidebar" 
                class="text-white focus:outline-none transition-transform duration-300">
                <i :class="open ? 'fa-solid fa-bars-staggered' : 'fa-solid fa-bars'" 
                    class="fa-lg transition-transform duration-200 hover:scale-110"></i>
        </button>
        
        <!-- Logo and App Name -->
        <div id="logo-container" class="flex items-center space-x-2 ml-0">
            <a href="{{ route('dashboard.redirect') }}" class="flex items-center space-x-2 group transition-all duration-500 hover:scale-105">
                <img src="{{ asset('images/logo sms.png') }}" alt="Logo" class="w-8 h-8 animate-spin-slow transition-all duration-500">
                <span class="text-xl font-poppins hidden xxs:inline text-white transition-all duration-500 group-hover:scale-105 group-hover:translate-y-[-1px]">
                    <span class="transition-all duration-500 group-hover:text-orange-300">S</span>ynergy
                    <span class="transition-all duration-500 group-hover:text-orange-300">MS</span>
                </span>
            </a>
        </div>

    </div>

    <!-- Middle Section: Search Field -->
    <div x-data="searchComponent()" class="flex-1 mx-4 relative max-w-lg"> 
        <input
            type="text"
            placeholder="Search..."
            x-model="query"
            @input="filterSuggestions"
            @keydown.arrow-down.prevent="highlightNext"
            @keydown.arrow-up.prevent="highlightPrevious"
            @keydown.enter.prevent="navigateToHighlighted"
            class="w-full px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
        >
        
        <!-- Suggestions Dropdown -->
        <ul
            x-show="showSuggestions && filteredPages.length > 0"
            x-transition
            class="absolute left-0 right-0 bg-white border border-gray-300 rounded-md mt-1 max-h-60 overflow-y-auto z-20 w-full"
        >
            <template x-for="(page, index) in filteredPages" :key="index">
                <li
                    :class="{'bg-orange-500 text-white': index === highlightedIndex, 'text-gray-700': index !== highlightedIndex}"
                    @click="navigate(page.route)"
                    @mouseenter="highlightedIndex = index"
                    @mouseleave="highlightedIndex = -1"
                    class="px-4 py-2 cursor-pointer"
                >
                    <span x-text="page.name"></span>
                </li>
            </template>
        </ul>
    </div>

    <!-- Right Side: User Profile Dropdown -->
    <div class="relative flex items-center space-x-2">
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

        <!-- User Name and Dropdown Button -->
        <button id="profile-button" class="flex items-center space-x-1 focus:outline-none">
            <span class="text-white hidden md:inline">{{ $user->name ?? 'Guest' }}</span>
            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a 1 1 0 01-1.414 0l-4-4a 1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <div id="profile-dropdown" 
            class="profile-dropdown absolute right-0 top-full mt-2 w-40 bg-white text-black rounded-lg shadow-lg z-50 hidden">
            <a href="{{ route('profile') }}" class="group px-4 py-2 text-black hover:bg-orange-500 hover:text-white flex items-center">
                <i class="fas fa-user mr-2 text-orange-500 group-hover:text-white"></i> Profile
            </a>
            {{-- <a href="#" class="group px-4 py-2 text-black hover:bg-orange-500 hover:text-white flex items-center">
                <i class="fas fa-cog mr-2 text-orange-500 group-hover:text-white"></i> Settings
            </a>
            <a href="#" class="group px-4 py-2 text-black hover:bg-orange-500 hover:text-white flex items-center">
                <i class="fas fa-bell mr-2 text-orange-500 group-hover:text-white"></i> Notifications
            </a> --}}
            <a href="{{ route('support')}}" class="group px-4 py-2 text-black hover:bg-orange-500 hover:text-white flex items-center">
                <i class="fas fa-question-circle mr-2 text-orange-500 group-hover:text-white"></i> Help & Support
            </a>

            <!-- Logout Form -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="group w-full text-left px-4 py-2 text-black hover:bg-orange-500 hover:text-white flex items-center">
                    <i class="fas fa-sign-out-alt mr-2 text-orange-500 group-hover:text-white"></i> Logout
                </button>
            </form>
        </div>
    </div>
        
</header>


<!-- Alpine.js Component Script -->
<script>
    function searchComponent() {
        return {
            query: '',
            filteredPages: [],
            showSuggestions: false,
            highlightedIndex: -1,

            filterSuggestions() {
                if (this.query.length === 0) {
                    this.filteredPages = [];
                    this.showSuggestions = false;
                    this.highlightedIndex = -1;
                    return;
                }

                // Filter the pages based on the query
                const queryLower = this.query.toLowerCase();
                this.filteredPages = window.searchPages.filter(page => 
                    page.name.toLowerCase().includes(queryLower)
                );

                this.showSuggestions = this.filteredPages.length > 0;
                this.highlightedIndex = -1;
            },

            highlightNext() {
                if (this.filteredPages.length === 0) return;
                if (this.highlightedIndex < this.filteredPages.length - 1) {
                    this.highlightedIndex++;
                }
            },

            highlightPrevious() {
                if (this.filteredPages.length === 0) return;
                if (this.highlightedIndex > 0) {
                    this.highlightedIndex--;
                }
            },

            navigateToHighlighted() {
                if (this.highlightedIndex >= 0 && this.highlightedIndex < this.filteredPages.length) {
                    const selectedPage = this.filteredPages[this.highlightedIndex];
                    window.location.href = selectedPage.route;
                }
            },

            navigate(route) {
                window.location.href = route;
            }
        }
    }
</script>
