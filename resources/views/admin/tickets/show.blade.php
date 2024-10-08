@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">
        <!-- Back Button -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold">{{ $ticket->title }} Details</h1>
            <a href="{{ route('admin.tickets.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        <!-- Ticket Information Card -->
        <div class="bg-white shadow-lg rounded-lg p-6 max-w-3xl mx-auto">
            <h2 class="text-xl font-semibold mb-4 border-b pb-2">Ticket Information</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <!-- Title -->
                <div>
                    <p class="font-semibold text-gray-700 mb-2">Title:</p>
                    <p class="mb-2">{{ $ticket->title }}</p>
                </div>
                <!-- Status -->
                <div>
                    <p class="font-semibold text-gray-700 mb-2">Status:</p>
                    <p class="mb-2">{{ $ticket->status }}</p>
                </div>
                <!-- Priority -->
                <div>
                    <p class="font-semibold text-gray-700 mb-2">Priority:</p>
                    <p class="mb-2">{{ $ticket->priority }}</p>
                </div>
                <!-- Employee -->
                <div>
                    <p class="font-semibold text-gray-700 mb-2">Employee:</p>
                    <p class="mb-2">{{ $ticket->employee->user->name }}</p>
                </div>
                <!-- Project -->
                <div class="sm:col-span-2">
                    <p class="font-semibold text-gray-700 mb-2">Project:</p>
                    <p class="mb-2">{{ $ticket->project->name }}</p>
                </div>
            </div>

            <!-- Description Section -->
            <div class="mt-6">
                <p class="font-semibold text-gray-700 mb-2">Description:</p>
                <p class="text-gray-700 mb-2">{{ $ticket->description }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
