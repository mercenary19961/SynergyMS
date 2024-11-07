<div x-data="{ notificationOpen: @entangle('notificationOpen') }" class="relative cursor-pointer">
    <!-- Toggle Notification Dropdown -->
    <div @click="notificationOpen = !notificationOpen" wire:click="toggleNotificationDropdown">
        <!-- Notification Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white hover:text-gray-100 transition duration-200 ease-in-out" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.118V11a7.002 7.002 0 00-5-6.708V4a3 3 0 10-6 0v.292A7.002 7.002 0 002 11v3.118c0 .523-.214 1.025-.595 1.477L1 17h5m4 0v1a3 3 0 006 0v-1m-6 0h6" />
        </svg>

        <!-- Notification Badge -->
        @if($unreadNotifications > 0)
            <span class="absolute top-0 right-0 inline-block w-2.5 h-2.5 bg-red-600 rounded-full"></span>
        @endif
    </div>

    <!-- Notification Dropdown -->
    <div x-show="notificationOpen" @click.outside="notificationOpen = false" class="absolute right-0 mt-2 w-80 bg-white border border-gray-300 rounded-md shadow-lg">
        <div class="p-4">
            <!-- Render Notifications Livewire Component -->
            @livewire('notifications')
        </div>
    </div>
</div>
