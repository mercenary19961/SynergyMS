{{-- resources/views/admin/tickets/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">
        <h1 class="mb-4 text-2xl font-semibold">Tickets</h1>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Add New Ticket Button -->
        <a href="{{ route('admin.tickets.create') }}" class="btn btn-primary mb-3">Add New Ticket</a>

        <!-- Tickets Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 text-left">#</th>
                        <th class="py-2 px-4 text-left">Title</th>
                        <th class="py-2 px-4 text-left">Status</th>
                        <th class="py-2 px-4 text-left">Priority</th>
                        <th class="py-2 px-4 text-left">Employee</th>
                        <th class="py-2 px-4 text-left">Project</th>
                        <th class="py-2 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                        <tr class="border-t">
                            <td class="py-2 px-4">{{ $ticket->id }}</td>
                            <td class="py-2 px-4">{{ $ticket->title }}</td>
                            <td class="py-2 px-4">{{ $ticket->status }}</td>
                            <td class="py-2 px-4">{{ $ticket->priority }}</td>
                            <td class="py-2 px-4">{{ $ticket->employee->user->name }}</td>
                            <td class="py-2 px-4">{{ $ticket->project->name }}</td>
                            <td class="py-2 px-4">
                                <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
