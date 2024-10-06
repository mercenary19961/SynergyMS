{{-- resources/views/admin/clients/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">
        <h1 class="mb-4 text-2xl font-semibold">Edit Client</h1>

        <!-- Form -->
        <form action="{{ route('admin.clients.update', $client->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- User Selection -->
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700">User</label>
                <select name="user_id" id="user_id" required class="w-full px-2 py-2 border rounded">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $client->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Company Name -->
            <div class="mt-4">
                <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                <input type="text" name="company_name" id="company_name" value="{{ $client->company_name }}" required class="w-full px-2 py-2 border rounded" />
            </div>

            <!-- Industry -->
            <div class="mt-4">
                <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
                <input type="text" name="industry" id="industry" value="{{ $client->industry }}" required class="w-full px-2 py-2 border rounded" />
            </div>

            <!-- Contact Number -->
            <div class="mt-4">
                <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                <input type="text" name="contact_number" id="contact_number" value="{{ $client->contact_number }}" required class="w-full px-2 py-2 border rounded" />
            </div>

            <!-- Address -->
            <div class="mt-4">
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <input type="text" name="address" id="address" value="{{ $client->address }}" required class="w-full px-2 py-2 border rounded" />
            </div>

            <!-- Website -->
            <div class="mt-4">
                <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                <input type="url" name="website" id="website" value="{{ $client->website }}" required class="w-full px-2 py-2 border rounded" />
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Update Client</button>
            </div>
        </form>
    </div>
</div>
@endsection
