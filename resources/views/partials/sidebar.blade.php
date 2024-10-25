<!-- Sidebar -->
<div id="sidebar"
     x-data="{ isHovering: false }"
     @mouseover="if (!open && hoverEnabled && window.innerWidth >= 1024) { open = true; isHovering = true; }" 
     @mouseleave="if (hoverEnabled && window.innerWidth >= 1024) { open = false; isHovering = false; }"
     :class="{
         'w-60 min-h-screen overflow-hidden  bg-zinc-800 lg:shadow-lg transition-all duration-300 fixed lg:relative z-50': open || window.innerWidth >= 1024 && isHovering, 
         'w-12 min-h-screen overflow-hidden  bg-gradient-to-b from-pink-600 to-zinc-800 lg:shadow-lg transition-all duration-300 fixed lg:relative z-50': !open && !isHovering && window.innerWidth >= 1024,
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
                'bg-gradient-to-r from-zinc-800 to-zinc-900': open && '{{ request()->routeIs('admin.dashboard') }}',
                'hover:bg-zinc-900': !'{{ request()->routeIs('admin.dashboard') }}' 
            }">
            <i class="fa-solid fa-gauge fa-lg"
                :class="{
                    'text-white': !open && '{{ request()->routeIs('admin.dashboard') }}',
                    'text-orange-500': open && '{{ request()->routeIs('admin.dashboard') }}',
                    'text-gray-300': !'{{ request()->routeIs('admin.dashboard') }}'
                }">
            </i>
            <span x-show="open" class="text-sm font-medium hover:text-white">Admin Dashboard</span>
        </a>
        @endrole

        <!-- Employee Dashboard -->
        @role('Employee')
        <a href="{{ route('employee.dashboard') }}" 
            class="relative flex items-center space-x-3 p-2 text-gray-300 hover:bg-zinc-900 rounded-md transition-colors duration-200"
            :class="{
                'bg-gradient-to-r from-zinc-800 to-zinc-900': open && '{{ request()->routeIs('employee.dashboard') }}',
                'hover:bg-zinc-900': !'{{ request()->routeIs('employee.dashboard') }}'
            }">
            <i class="fa-solid fa-users fa-md"></i>
            <span x-show="open" class="text-sm font-medium hover:text-white">Employee Dashboard</span>
        </a>
        @endrole

        <!-- Project Manager Dashboard -->
        @role('Project Manager')
        <a href="{{ route('project-manager.dashboard') }}" 
            class="relative flex items-center space-x-3 p-2 text-gray-300 hover:bg-zinc-900 rounded-md transition-colors duration-200"
            :class="{
                'bg-gradient-to-r from-zinc-800 to-zinc-900': open && '{{ request()->routeIs('projectManager.dashboard') }}',
                'hover:bg-zinc-900': !'{{ request()->routeIs('projectManager.dashboard') }}'
            }">
            <i class="fa-solid fa-clipboard-list fa-md"></i>
            <span x-show="open" class="text-sm font-medium hover:text-white">Project Manager Dashboard</span>
        </a>
        @endrole

        <!-- Client Dashboard -->
        @role('Client')
        <a href="{{ route('client.dashboard') }}" 
            class="relative flex items-center space-x-3 p-2 text-gray-300 hover:bg-zinc-900 rounded-md transition-colors duration-200"
            :class="{
                'bg-gradient-to-r from-zinc-800 to-zinc-900': open && '{{ request()->routeIs('client.dashboard') }}',
                'hover:bg-zinc-900': !'{{ request()->routeIs('client.dashboard') }}'
            }">
            <i class="fa-solid fa-user-tie fa-md"></i>
            <span x-show="open" class="text-sm font-medium hover:text-white">Client Dashboard</span>
        </a>
        @endrole

        <!-- Manage Employees -->
        @role('Super Admin|HR|Project Manager|Client')
        <a href="{{ route('admin.employees.index') }}" 
            class="relative flex items-center space-x-3 p-2 text-gray-300 hover:bg-zinc-900 rounded-md transition-colors duration-200"
            :class="{
                'bg-gradient-to-r from-zinc-800 to-zinc-900': open && '{{ request()->routeIs('admin.employees.index') }}',
                'hover:bg-zinc-900': !'{{ request()->routeIs('admin.employees.index') }}'
            }">
            <i class="fa-solid fa-user-tie fa-md"></i>
            <span x-show="open" class="text-sm font-medium hover:text-white">Employees</span>
        </a>
        @endrole

        <!-- Manage Attendance -->
        @role('Super Admin|HR|Project Manager')
        <a href="{{ route('admin.attendance.index') }}" 
            class="relative flex items-center space-x-3 p-2 text-gray-300 hover:bg-zinc-900 rounded-md transition-colors duration-200"
            :class="{
                'bg-gradient-to-r from-zinc-800 to-zinc-900': open && '{{ request()->routeIs('admin.attendance.index') }}',
                'hover:bg-zinc-900': !'{{ request()->routeIs('admin.attendance.index') }}'
            }">
            <i class="fa-solid fa-calendar-check fa-md"></i>
            <span x-show="open" class="text-sm font-medium hover:text-white">Attendance</span>
        </a>
        @endrole

        <!-- Manage Project Managers -->
        @role('Super Admin|HR|Project Manager|Client')
        <a href="{{ route('admin.project-managers.index') }}" 
            class="relative flex items-center space-x-3 p-2 text-gray-300 hover:bg-zinc-900 rounded-md transition-colors duration-200"
            :class="{
                'bg-gradient-to-r from-zinc-800 to-zinc-900': open && '{{ request()->routeIs('admin.project-managers.index') }}',
                'hover:bg-zinc-900': !'{{ request()->routeIs('admin.project-managers.index') }}'
            }">
            <i class="fa-solid fa-user-cog fa-md"></i>
            <span x-show="open" class="text-sm font-medium hover:text-white">Project Managers</span>
        </a>
        @endrole

        <!-- Manage Clients -->
        @role('Super Admin|HR|Project Manager|Client')
        <a href="{{ route('admin.clients.index') }}" 
            class="relative flex items-center space-x-3 p-2 text-gray-300 hover:bg-zinc-900 rounded-md transition-colors duration-200"
            :class="{
                'bg-gradient-to-r from-zinc-800 to-zinc-900': open && '{{ request()->routeIs('admin.clients.index') }}',
                'hover:bg-zinc-900': !'{{ request()->routeIs('admin.clients.index') }}'
            }">
            <i class="fa-solid fa-handshake fa-md"></i>
            <span x-show="open" class="text-sm font-medium hover:text-white">Clients</span>
        </a>
        @endrole

        <!-- Manage Departments -->
        @role('Super Admin|HR|Project Manager|Client')
        <a href="{{ route('admin.departments.index') }}" 
            class="relative flex items-center space-x-3 p-2 text-gray-300 hover:bg-zinc-900 rounded-md transition-colors duration-200"
            :class="{
                'bg-gradient-to-r from-zinc-800 to-zinc-900': open && '{{ request()->routeIs('admin.departments.index') }}',
                'hover:bg-zinc-900': !'{{ request()->routeIs('admin.departments.index') }}'
            }">
            <i class="fa-solid fa-building fa-md"></i>
            <span x-show="open" class="text-sm font-medium hover:text-white">Departments</span>
        </a>
        @endrole

        <!-- Manage Tickets -->
        @role('Super Admin|HR|Project Manager|Client')
        <a href="{{ route('admin.tickets.index') }}" 
            class="relative flex items-center space-x-3 p-2 text-gray-300 hover:bg-zinc-900 rounded-md transition-colors duration-200"
            :class="{
                'bg-gradient-to-r from-zinc-800 to-zinc-900': open && '{{ request()->routeIs('admin.tickets.index') }}',
                'hover:bg-zinc-900': !'{{ request()->routeIs('admin.tickets.index') }}'
            }">
            <i class="fa-solid fa-ticket-alt fa-md"></i>
            <span x-show="open" class="text-sm font-medium hover:text-white">Tickets</span>
        </a>
        @endrole

        <!-- Manage Projects -->
        @role('Super Admin|HR|Project Manager|Client')
        <a href="{{ route('admin.projects.index') }}" 
            class="relative flex items-center space-x-3 p-2 text-gray-300 hover:bg-zinc-900 rounded-md transition-colors duration-200"
            :class="{
                'bg-gradient-to-r from-zinc-800 to-zinc-900': open && '{{ request()->routeIs('admin.projects.index') }}',
                'hover:bg-zinc-900': !'{{ request()->routeIs('admin.projects.index') }}'
            }">
            <i class="fa-solid fa-folder fa-md"></i>
            <span x-show="open" class="text-sm font-medium hover:text-white">Projects</span>
        </a>
        @endrole

        <!-- Manage Human Resources -->
        @role('Super Admin|HR|Project Manager|Client')
        <a href="{{ route('admin.human-resources.index') }}" 
            class="relative flex items-center space-x-3 p-2 text-gray-300 hover:bg-zinc-900 rounded-md transition-colors duration-200"
            :class="{
                'bg-gradient-to-r from-zinc-800 to-zinc-900': open && '{{ request()->routeIs('admin.human-resources.index') }}',
                'hover:bg-zinc-900': !'{{ request()->routeIs('admin.human-resources.index') }}'
            }">
            <i class="fa-solid fa-users-cog fa-md"></i>
            <span x-show="open" class="text-sm font-medium hover:text-white">Human Resources</span>
        </a>
        @endrole
    </nav>
</div>

<!-- Overlay for small screens -->
<div x-show="open && window.innerWidth < 1024" 
     class="fixed inset-0 bg-black bg-opacity-80 transition-opacity duration-300"
     @click="open = false; localStorage.setItem('sidebarOpen', false);">
</div>
