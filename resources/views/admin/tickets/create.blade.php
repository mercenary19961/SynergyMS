@extends('layouts.app')

@section('content')
<div class="flex flex-col h-screen">

    <div class="flex-1 p-6 bg-gray-100 overflow-auto">
        <x-title-with-back title="Add New Ticket" />

        @include('components.form.errors')

        <form action="{{ route('admin.tickets.store') }}" method="POST" x-data="ticketForm()">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Issuer (User) Field -->
                <div class="mb-4">
                    <label for="ticket_issuer" class="block text-sm font-bold text-gray-700">
                        <i class="fas fa-user mr-2 text-orange-500"></i> Ticket Issuer
                    </label>
                    <input 
                    type="number" 
                    name="user_id" 
                    id="ticket_issuer"
                    class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none"
                    placeholder="Enter User ID">
                    @error('user_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="title" class="block text-sm font-bold text-gray-700">
                        <i class="fas fa-file-alt mr-2 text-orange-500"></i> Title
                    </label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" value="{{ old('title') }}" placeholder="Enter Ticket Title">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-bold text-gray-700">
                        <i class="fas fa-align-left mr-2 text-orange-500"></i> Description
                    </label>
                    <textarea name="description" id="description" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" placeholder="Enter Ticket Description">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="relative mb-4">
                    <label for="status" class="block text-sm font-bold text-gray-700">
                        <i class="fas fa-tasks mr-2 text-orange-500"></i> Status
                    </label>
                    <button type="button" class="mt-1 w-full bg-gray-200 border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between focus:outline-none" disabled>
                        <span class="block truncate">Open</span>
                    </button>
                    <input type="hidden" name="status" value="Open">
                </div>

                <!-- Livewire Priority Dropdown -->
                <livewire:priority-dropdown />

            </div>

            <x-form.button-submit label="Create Ticket" />
        </form>
    </div>
    <x-footer />
</div>

<script>
    function ticketForm() {
        return {
            openStatus: false,
            openPriority: false,
            openProjectManager: false,
            selectedStatus: '{{ old('status') }}',
            selectedPriority: '{{ old('priority') }}',
        }
    }
</script>

@endsection
