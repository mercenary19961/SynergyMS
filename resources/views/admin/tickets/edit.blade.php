{{-- resources/views/admin/tickets/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">
        <h1 class="mb-4 text-2xl font-semibold">Edit Ticket</h1>

        <!-- Form -->
        <form action="{{ route('admin.tickets.update', $ticket->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" required class="w-full px-3 py-2 border rounded-md" value="{{ $ticket->title }}">
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" required class="w-full px-3 py-2 border rounded-md">{{ $ticket->description }}</textarea>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" required class="w-full px-3 py-2 border rounded-md">
                        <option value="Open" {{ $ticket->status == 'Open' ? 'selected' : '' }}>Open</option>
                        <option value="In Progress" {{ $ticket->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Closed" {{ $ticket->status == 'Closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <!-- Priority -->
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                    <select name="priority" id="priority" required class="w-full px-3 py-2 border rounded-md">
                        <option value="Low" {{ $ticket->priority == 'Low' ? 'selected' : '' }}>Low</option>
                        <option value="Medium" {{ $ticket->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="High" {{ $ticket->priority == 'High' ? 'selected' : '' }}>High</option>
                    </select>
                </div>

                <!-- Employee Selection -->
                <div>
                    <label for="employee_id" class="block text-sm font-medium text-gray-700">Assigned Employee</label>
                    <select name="employee_id" id="employee_id" required class="w-full px-3 py-2 border rounded-md">
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ $ticket->employee_id == $employee->id ? 'selected' : '' }}>{{ $employee->user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Project Selection -->
                <div>
                    <label for="project_id" class="block text-sm font-medium text-gray-700">Project</label>
                    <select name="project_id" id="project_id" required class="w-full px-3 py-2 border rounded-md">
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ $ticket->project_id == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-md">Update Ticket</button>
            </div>
        </form>
    </div>
</div>
@endsection
