@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <div class="flex-1 p-6 bg-gray-100">
        <x-title-with-back title="Event Details" />

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
@endsection
