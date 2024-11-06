@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <div class="flex-1 p-6 bg-gray-100">
        
        <!-- Title Row with Event Details, Back, and Confirm Attendance Buttons -->
        <div class="flex items-center justify-between mb-4">
            <!-- Left Side: Title with Icon -->
            <div class="flex items-center space-x-2">
                <i class="fas fa-calendar-alt text-gray-600"></i>
                <h1 class="text-2xl font-semibold text-gray-800">Event Details</h1>
            </div>

            <!-- Right Side: Back and Confirm Attendance Buttons -->
            <div class="flex items-center space-x-4">
                <!-- Button Logic in Blade Template -->
                @if($toggleCount < 2)
                    <button id="attendanceButton" onclick="confirmToggle()" 
                            class="flex items-center {{ $isAttending ? 'bg-blue-500' : 'bg-green-500' }} text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                        <i class="fas fa-check mr-2"></i> 
                        <span id="attendanceButtonText">{{ $isAttending ? 'Attending' : 'Confirm Attendance' }}</span>
                    </button>
                @else
                    <!-- Show non-clickable "Not Attending" if max cancels reached -->
                    <button class="flex items-center bg-red-500 text-white px-4 py-2 rounded cursor-not-allowed">
                        <i class="fas fa-times mr-2"></i> Not Attending
                    </button>
                @endif
            
                <!-- Back Button -->
                <a href="{{ url()->previous() }}" class="flex items-center bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
            </div>
            
        </div>

        <div class="space-y-4 bg-white p-6 rounded-lg shadow-lg mb-6">
            <!-- Event Name -->
            <div class="flex flex-col md:flex-row md:space-x-4">
                <div class="md:w-1/2">
                    <label class="block text-sm font-medium text-gray-700">Event Name</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $event->name }}</p>
                </div>

                <!-- Event Description -->
                <div class="md:w-1/2">
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <p class="mt-1 text-gray-700">{{ $event->description ?? 'No description provided' }}</p>
                </div>
            </div>

            <div class="flex flex-col md:flex-row md:space-x-4">
                <!-- Start Date -->
                <div class="md:w-1/2">
                    <label class="block text-sm font-medium text-gray-700">Start Date</label>
                    <p class="mt-1 text-gray-700">{{ $event->start_date ?? 'N/A' }}</p>
                </div>

                <!-- End Date -->
                <div class="md:w-1/2">
                    <label class="block text-sm font-medium text-gray-700">End Date</label>
                    <p class="mt-1 text-gray-700">{{ $event->end_date ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="flex flex-col md:flex-row md:space-x-4">
                <!-- Sector -->
                <div class="md:w-1/2">
                    <label class="block text-sm font-medium text-gray-700">Sector</label>
                    <p class="mt-1 text-gray-700">
                        {{ $event->is_general ? 'General' : ($event->target_role ?? $event->target_department_id ? $event->target_role : 'N/A') }}
                    </p>
                </div>

                <!-- General Event Indicator -->
                <div class="md:w-1/2">
                    <label class="block text-sm font-medium text-gray-700">General Event</label>
                    <p class="mt-1 text-gray-700">{{ $event->is_general ? 'Yes' : 'No' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Check if there's a cooldown timer saved in localStorage
        const lastClickedTime = localStorage.getItem('attendanceButtonCooldown');
        if (lastClickedTime) {
            const timeElapsed = (Date.now() - parseInt(lastClickedTime, 10)) / 1000;
            if (timeElapsed < 60) {
                startCooldown(60 - timeElapsed);
            }
        }
    });

    function confirmToggle() {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to change your attendance status?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Save the current time in localStorage to track cooldown
                localStorage.setItem('attendanceButtonCooldown', Date.now());
                
                // Submit the form
                document.getElementById('toggle-attendance-form').submit();
                
                // Start cooldown immediately
                startCooldown(60);
            }
        })
    }

    function startCooldown(timeLeft) {
        const button = document.getElementById('attendanceButton');
        const buttonText = document.getElementById('attendanceButtonText');
        button.disabled = true; // Disable the button
        button.classList.add('bg-gray-400', 'cursor-not-allowed'); // Change appearance

        const countdown = setInterval(() => {
            timeLeft--;
            buttonText.textContent = `Please wait (${Math.floor(timeLeft)})`;

            if (timeLeft <= 0) {
                clearInterval(countdown);
                button.disabled = false; // Re-enable the button
                buttonText.textContent = "{{ $isAttending ? 'Attending' : 'Confirm Attendance' }}";
                button.classList.remove('bg-gray-400', 'cursor-not-allowed');
                button.classList.add('{{ $isAttending ? 'bg-blue-500' : 'bg-green-500' }}');
                localStorage.removeItem('attendanceButtonCooldown'); // Remove cooldown from localStorage
            }
        }, 1000);
    }
</script>
    
    <form id="toggle-attendance-form" action="{{ route('admin.events.attend', $event->id) }}" method="POST" style="display: none;">
        @csrf
    </form>
</form>
@endsection
