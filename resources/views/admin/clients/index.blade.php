{{-- resources/views/admin/clients/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">
        <h1 class="mb-4 text-2xl font-semibold">Clients</h1>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Add New Client Button -->
        <a href="{{ route('admin.clients.create') }}" class="btn btn-primary mb-3">Add New Client</a>

        <!-- Clients Table -->
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
                        <tr class="border-t">
                            <td class="py-2 px-4">{{ $client->id }}</td>
                            <td class="py-2 px-4">{{ $client->user->name }}</td>
                            <td class="py-2 px-4">{{ $client->company_name }}</td>
                            <td class="py-2 px-4">{{ $client->industry }}</td>
                            <td class="py-2 px-4">{{ $client->contact_number }}</td>
                            <td class="py-2 px-4">
                                <a href="{{ route('admin.clients.edit', $client->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST" style="display:inline-block;">
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
