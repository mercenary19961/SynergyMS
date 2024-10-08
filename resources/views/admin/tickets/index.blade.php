@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-green-700 hover:text-green-500 focus:outline-none" onclick="this.closest('div').remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Header Row -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold">Tickets</h1>
            <a href="{{ route('admin.tickets.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition inline-flex items-center">
                <i class="fas fa-plus-circle mr-2"></i> Add New Ticket
            </a>
        </div>

        <!-- Tickets Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead class="bg-gray-200 font-light text-gray-800">
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
                        <tr class="border-t text-sm font-normal {{ $loop->odd ? 'bg-gray-100' : 'bg-white' }}">
                            <td class="py-2 px-4">{{ $ticket->id }}</td>
                            <td class="py-2 px-4">{{ $ticket->title }}</td>
                            <td class="py-2 px-4">{{ $ticket->status }}</td>
                            <td class="py-2 px-4">{{ $ticket->priority }}</td>
                            <td class="py-2 px-4">{{ $ticket->employee->user->name }}</td>
                            <td class="py-2 px-4">{{ $ticket->project->name }}</td>
                            <td class="py-2 px-4 flex space-x-4">
                                <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="transform hover:text-blue-500 hover:scale-110">
                                    <i class="fas fa-eye fa-md"></i>
                                </a>
                                <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="transform hover:text-orange-500 hover:scale-110">
                                    <i class="fas fa-pen fa-md"></i>
                                </a>
                                <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="w-4 ml-2 transform hover:text-red-500 hover:scale-110 delete-btn">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $tickets->links('pagination::tailwind') }}
        </div>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#737373',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

@endsection
