@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    @include('partials.sidebar')

    <div class="flex-1 p-6 bg-gray-100">
        @include('components.form.success')

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold flex items-center">
                <i class="fas fa-users mr-2"></i> Clients
            </h1>
            <a href="{{ route('admin.clients.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">
                <i class="fas fa-plus mr-2"></i> Add New Client
            </a>
        </div>
        

        <form method="GET" action="{{ route('admin.clients.index') }}" class="mb-6">
            <div class="flex flex-col md:flex-row md:items-end md:space-x-4 space-y-4 md:space-y-0">
                <div class="flex-1">
                    <label for="name" class="block text-sm font-medium text-gray-700">Client Name</label>
                    <input type="text" name="name" id="name" value="{{ request('name') }}" placeholder="Client Name" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">
                </div>

                <div class="flex-1">
                    <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                    <input type="text" name="company_name" id="company_name" value="{{ request('company_name') }}" placeholder="Company Name" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">
                </div>

                <div class="flex-1">
                    <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
                    <input type="text" name="industry" id="industry" value="{{ request('industry') }}" placeholder="Industry" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">
                </div>

                <div class="flex-shrink-0 flex space-x-2">
                    <button type="submit" class="w-full md:w-auto bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition flex items-center">
                        <i class="fas fa-search mr-2"></i> Search
                    </button>

                    <a href="{{ route('admin.clients.index') }}" class="w-full md:w-auto bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition flex items-center justify-center">
                        <i class="fas fa-times mr-2"></i> Clear
                    </a>
                </div>
            </div>
        </form>

        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100 text-left text-gray-600 uppercase text-xs leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left"><i class="fas fa-hashtag mr-2"></i></th>
                        <th class="py-3 px-6 text-left"><i class="fas fa-user mr-2"></i>Client Name</th>
                        <th class="py-3 px-6 text-left"><i class="fas fa-building mr-2"></i>Company Name</th>
                        <th class="py-3 px-6 text-left"><i class="fas fa-industry mr-2"></i>Industry</th>
                        <th class="py-3 px-6 text-left"><i class="fas fa-phone-alt mr-2"></i>Contact Number</th>
                        <th class="py-3 px-6 text-center"><i class="fas fa-cogs mr-2"></i>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-black text-sm font-normal">
                    @foreach($clients as $client)
                        <tr class="border-b border-gray-200 hover:bg-gray-100 {{ $loop->iteration % 2 == 0 ? 'bg-gray-200' : '' }}">
                            <td class="py-3 px-6">{{ $client->id }}</td>
                            <td class="py-3 px-6">{{ $client->user->name }}</td>
                            <td class="py-3 px-6">{{ $client->company_name }}</td>
                            <td class="py-3 px-6">{{ $client->industry }}</td>
                            <td class="py-3 px-6">{{ $client->contact_number }}</td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center space-x-4">
                                    <a href="{{ route('admin.clients.show', $client->id) }}" class="w-4 transform hover:text-blue-500 hover:scale-110">
                                        <i class="fas fa-eye fa-md text-orange-500 hover:text-blue-500"></i>
                                    </a>
                                    <a href="{{ route('admin.clients.edit', $client->id) }}" class="w-4 transform hover:text-orange-500 hover:scale-110">
                                        <i class="fas fa-edit fa-md text-orange-500 hover:text-yellow-500"></i>
                                    </a>
                                    <form id="delete-form-{{ $client->id }}" action="{{ route('admin.clients.destroy', $client->id) }}" method="POST" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <x-delete-button formId="delete-form-{{ $client->id }}" />
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <x-pagination>
            {{ $clients->links('pagination::tailwind') }}
        </x-pagination>
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
