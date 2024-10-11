<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('SynergyMS', 'Laravel') }}</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap" rel="stylesheet">

    <!-- Livewire Styles -->
    @livewireStyles

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Meta Tags for SEO -->
    <meta name="description" content="Your site description">
    <meta name="keywords" content="Laravel, Blade, TailwindCSS">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- x-cloak Style -->
    <style>
        [x-cloak] { display: none !important; }
        /* Loader Styles */
        .loader {
            border-top-color: #3498db;
            animation: spin 1s ease-in-out infinite;
        }
    
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="font-montserrat antialiased bg-gray-100 font-normal">
    <!-- Global Alpine.js state -->
    <div class="min-h-screen flex flex-col" 
         x-data="{ 
            open: localStorage.getItem('sidebarOpen') === 'true', 
            hoverEnabled: localStorage.getItem('sidebarOpen') === 'false',
            toggleSidebar() {
                if (window.innerWidth >= 1024) {
                    // Toggle open state for large screens
                    this.open = !this.open;
                    localStorage.setItem('sidebarOpen', this.open);
                    this.hoverEnabled = !this.open;
                } else {
                    // For small screens, just toggle open without hover
                    this.open = !this.open; 
                }
            }
         }"

         // Ensure that when resizing from small to large, the sidebar opens
         @resize.window="if (window.innerWidth >= 1024) { 
            open = true;  // Automatically open on large screens
            localStorage.setItem('sidebarOpen', true);
            hoverEnabled = false;
         } else {
            open = false; // Automatically close on small screens
         }">
        
        <!-- Navigation -->
        @if (!isset($hideHeader) || !$hideHeader)
            @include('partials.header')
        @endif

        <div class="flex">
            <!-- Sidebar -->
            @include('partials.sidebar')

            <!-- Main Content Area -->
            <div class="flex-1 relative">
                <!-- Flash Messages -->
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
                     class="fixed inset-0 bg-black bg-opacity-50 transition-opacity duration-300"
                     @click="open = false; localStorage.setItem('sidebarOpen', false);"></div>
            </div>
        </div>

        <!-- Footer -->
        @include('partials.footer')

    </div>
</body>

</html>
