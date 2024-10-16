<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('SynergyMS', 'Laravel') }}</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Livewire Styles -->
    @livewireStyles

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body class="font-montserrat antialiased bg-gray-100 font-normal"
      x-data="{ isLoading: true }"
      @load.window="isLoading = false">
    
    <!-- Loading Spinner -->
    <div x-show="isLoading" class="fixed inset-0 bg-gray-100 flex items-center justify-center z-50">
        <div class="loader"></div>
    </div>

    <!-- Global Alpine.js state for Sidebar -->
    <div class="min-h-screen flex flex-col"
         x-cloak
         x-data="{ 
            open: localStorage.getItem('sidebarOpen') === 'true', 
            hoverEnabled: localStorage.getItem('sidebarOpen') === 'false',
            toggleSidebar() {
                if (window.innerWidth >= 1024) {
                    this.open = !this.open;
                    localStorage.setItem('sidebarOpen', this.open);
                    this.hoverEnabled = !this.open;
                } else {
                    this.open = !this.open;
                }
            }
         }"
         @resize.window="if (window.innerWidth >= 1024) { 
            open = true;  
            localStorage.setItem('sidebarOpen', true);
            hoverEnabled = false;
         } else {
            open = false;
         }">

        @if (!request()->routeIs('login'))
            @if (!isset($hideHeader) || !$hideHeader)
                <!-- Include fixed header -->
                <div class="fixed-header w-full">
                    @include('partials.header')
                </div>
            @endif

            <div class="flex">
                <!-- Sidebar only shows when open -->
                <div class="fixed-sidebar" 
                     :class="{'w-60': open, 'w-12': !open}" 
                     x-show="open || window.innerWidth >= 1024" 
                     x-transition:enter="transition ease-out duration-300" 
                     x-transition:enter-start="opacity-0 transform -translate-x-full" 
                     x-transition:enter-end="opacity-100 transform translate-x-0" 
                     x-transition:leave="transition ease-in duration-300" 
                     x-transition:leave-start="opacity-100 transform translate-x-0" 
                     x-transition:leave-end="opacity-0 transform -translate-x-full">
                    @include('partials.sidebar')
                </div>

                <!-- Main content area with dynamic margin based on sidebar state -->
                <div :class="{'main-content open': open, 'main-content closed': !open}" class="main-content flex-1 relative">
                    @if (session('status'))
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
                                <span class="block sm:inline">{{ session('status') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Main Content -->
                    <main class="flex-1">
                        @yield('content')
                    </main>

                    <!-- Overlay for small screens when sidebar is open -->
                    <div x-show="open && window.innerWidth < 1024" 
                        class="overlay"
                        @click="open = false; localStorage.setItem('sidebarOpen', false);"></div>
                </div>
            </div>

        @else
            <main class="flex-1">
                @yield('content')
            </main>
        @endif

        @include('partials.footer')

    </div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</body>
</html>
