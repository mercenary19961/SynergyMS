@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    @include('partials.sidebar')

    <div class="flex-1 p-6 bg-gray-100">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-green-700 hover:text-green-500 focus:outline-none" onclick="this.closest('div').remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold">Clients</h1>
            <a href="{{ route('admin.clients.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition inline-flex items-center">
                <i class="fas fa-plus-circle mr-2"></i> Add New Client
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 text-left">#</th>
                        <th class="py-2 px-4 text-left">User</th>
                        <th class="py-2 px-4 text-left">Company Name</th>
                        <th class="py-2 px-4 text-left">Industry</th>
                        <th class="py-2 px-4 text-left">Contact Number</th>
                        <th class="py-2 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                        <tr class="border-t {{ $loop->odd ? 'bg-gray-100' : 'bg-white' }}">
                            <td class="py-2 px-4">{{ $client->id }}</td>
                            <td class="py-2 px-4">{{ $client->user->name }}</td>
                            <td class="py-2 px-4">{{ $client->company_name }}</td>
                            <td class="py-2 px-4">{{ $client->industry }}</td>
                            <td class="py-2 px-4">{{ $client->contact_number }}</td>
                            <td class="py-2 px-4 flex space-x-4">
                                <a href="{{ route('admin.clients.show', $client->id) }}" class="transform hover:text-blue-500 hover:scale-110">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.clients.edit', $client->id) }}" class="transform hover:text-yellow-500 hover:scale-110">
                                    <i class="fas fa-pen fa-md000"></i>
                                </a>
                                <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="w-2 ml-2 transform hover:text-red-500 hover:scale-110 delete-btn">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $clients->links('pagination::tailwind') }}
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
