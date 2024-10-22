<!-- Sidebar -->
<div id="sidebar"
     x-data="{ isHovering: false }"
     @mouseover="if (!open && hoverEnabled && window.innerWidth >= 1024) { open = true; isHovering = true; }" 
     @mouseleave="if (hoverEnabled && window.innerWidth >= 1024) { open = false; isHovering = false; }"
     :class="{
         'w-60 min-h-screen overflow-hidden border-r bg-zinc-800 lg:shadow-lg transition-all duration-300 fixed lg:relative z-50': open || window.innerWidth >= 1024 && isHovering, 
         'w-12 min-h-screen overflow-hidden border-r bg-gradient-to-b from-pink-600 to-zinc-800 lg:shadow-lg transition-all duration-300 fixed lg:relative z-50': !open && !isHovering && window.innerWidth >= 1024,
         'hidden lg:block lg:w-12': !open && window.innerWidth < 1024
     }"
     class="sidebar transition-all duration-300">

    <!-- Sidebar content -->
    <div class="p-2 flex items-center space-x-2 mb-4">
        <img src="{{ asset('images/logo sms.png') }}" alt="Logo" class="w-6 h-6 ms-1 animate-spin-slow">
        <h3 x-show="open" class="text-white font-roboto text-sm">MAIN</h3>
    </div>
    
    <nav class="mt-1 space-y-1 py-1 ms-1">
        <!-- Dashboard -->
        @role('Super Admin')
        <a href="{{ route('admin.dashboard') }}" 
            class="relative flex items-center space-x-3 p-2 text-gray-300 hover:bg-zinc-900 rounded-md transition-colors duration-200"
            :class="{
                'bg-gradient-to-r from-zinc-800 to-zinc-900': open && '{{ request()->routeIs('admin.dashboard') }}', // Apply background only when open and route is active
                'hover:bg-zinc-900': !'{{ request()->routeIs('admin.dashboard') }}' // Apply hover color when not active
            }">
            <i class="fa-solid fa-gauge fa-lg"
                :class="{
                    'text-white': !open && '{{ request()->routeIs('admin.dashboard') }}', // Change icon to white when sidebar is closed and dashboard is active
                    'text-orange-500': open && '{{ request()->routeIs('admin.dashboard') }}', // Orange icon when sidebar is open and dashboard is active
                    'text-gray-300': !'{{ request()->routeIs('admin.dashboard') }}' // Default color when not active
                }">
            </i>
            <span x-show="open" class="text-sm font-medium hover:text-white">Admin Dashboard</span>
        </a>
        @endrole

        <!-- Employee Dashboard -->
        {{-- @role('Employee') --}}
        <a href="{{ route('employee.dashboard') }}" 
            class="relative flex items-center space-x-3 p-2 text-gray-300 hover:bg-zinc-900 rounded-md transition-colors duration-200"
            :class="{
                'bg-gradient-to-r from-zinc-800 to-zinc-900': open && '{{ request()->routeIs('employee.dashboard') }}',
                'hover:bg-zinc-900': !'{{ request()->routeIs('employee.dashboard') }}'
            }">
            <i class="fa-solid fa-users fa-md"></i>
            <span x-show="open" class="text-sm font-medium hover:text-white">Employee Dashboard</span>
        </a>
        {{-- @endrole --}}

        <!-- Managing Sectors Dropdown -->
        @role('Super Admin|HR')
        <div x-data="{ openDropdown: {{ request()->routeIs('admin.employees.*') || request()->routeIs('admin.attendance.*') || request()->routeIs('admin.departments.*') || request()->routeIs('admin.tickets.*') || request()->routeIs('admin.project-managers.*') || request()->routeIs('admin.clients.*') || request()->routeIs('admin.projects.*') || request()->routeIs('admin.human-resources.*') ? 'true' : 'false' }} }" 
            class="p-2 text-gray-300">
            <button @click="openDropdown = !openDropdown" class="w-full text-left flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fa-solid fa-bezier-curve fa-md mr-2 hover:text-white"></i>
                    <span x-show="open" class="text-sm hover:text-white">Managing Sectors</span>
                </div>
                <i :class="{ 'rotate-180': openDropdown }" x-show="open" class="fa-solid fa-chevron-down text-xxs transition-transform duration-200 ease-in-out"></i>
            </button>

            <!-- Dropdown items with icons -->
            <div x-show="open && openDropdown" 
                x-transition:enter="transition ease-out duration-300" 
                x-transition:enter-start="opacity-0 transform scale-90" 
                x-transition:enter-end="opacity-100 transform scale-100" 
                x-transition:leave="transition ease-in duration-300" 
                x-transition:leave-start="opacity-100 transform scale-100" 
                x-transition:leave-end="opacity-0 transform scale-90" 
                class="mt-2 space-y-1 bg-zinc-900 rounded-lg">

                <!-- Manage Employees (Visible to Admin and HR) -->
                <a href="{{ route('admin.employees.index') }}" 
                class="block py-2 px-4 text-xs text-gray-300 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.employees.*') ? 'text-orange-500' : '' }}">
                    <i class="fa-solid fa-user-tie fa-md mr-2"></i> Manage Employees
                </a>

                <!-- Manage Attendance (Visible to Admin and HR) -->
                <a href="{{ route('admin.attendance.index') }}" 
                class="block py-2 px-4 text-xs text-gray-300 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.attendance.*') ? 'text-orange-500' : '' }}">
                    <i class="fa-solid fa-calendar-check fa-md mr-2"></i> Manage Attendance
                </a>

                <!-- Manage Project Managers (Visible to Admin and HR) -->
                <a href="{{ route('admin.project-managers.index') }}" 
                class="block py-2 px-4 text-xs text-gray-300 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.project-managers.*') ? 'text-orange-500' : '' }}">
                    <i class="fa-solid fa-user-cog fa-md mr-2"></i> Manage Project Managers
                </a>

                <!-- Manage Clients (Visible to Admin and HR) -->
                <a href="{{ route('admin.clients.index') }}" 
                class="block py-2 px-4 text-xs text-gray-300 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.clients.*') ? 'text-orange-500' : '' }}">
                    <i class="fa-solid fa-handshake fa-md mr-2"></i> Manage Clients
                </a>

                <!-- Other management links (only visible to Admins) -->
                @role('Super Admin')
                <a href="{{ route('admin.departments.index') }}" 
                class="block py-2 px-4 text-xs text-gray-300 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.departments.*') ? 'text-orange-500' : '' }}">
                    <i class="fa-solid fa-building fa-md mr-2"></i> Manage Departments
                </a>

                <a href="{{ route('admin.tickets.index') }}" 
                class="block py-2 px-4 text-xs text-gray-300 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.tickets.*') ? 'text-orange-500' : '' }}">
                    <i class="fa-solid fa-ticket-alt fa-md mr-2"></i> Manage Tickets
                </a>

                <a href="{{ route('admin.projects.index') }}" 
                class="block py-2 px-4 text-xs text-gray-300 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.projects.*') ? 'text-orange-500' : '' }}">
                    <i class="fa-solid fa-folder fa-md mr-2"></i> Manage Projects
                </a>

                <a href="{{ route('admin.human-resources.index') }}" 
                class="block py-2 px-4 text-xs text-gray-300 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.human-resources.*') ? 'text-orange-500' : '' }}">
                    <i class="fa-solid fa-users-cog fa-md mr-2"></i> Manage Human Resources
                </a>
                @endrole

            </div>
        </div>
        @endrole

    </nav>
</div>

<!-- Overlay for small screens -->
<div x-show="open && window.innerWidth < 1024" 
     class="fixed inset-0 bg-black bg-opacity-80 transition-opacity duration-300"
     @click="open = false; localStorage.setItem('sidebarOpen', false);">
</div>
