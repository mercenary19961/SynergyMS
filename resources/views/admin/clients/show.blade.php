{{-- resources/views/admin/clients/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    @include('partials.sidebar')

    <div class="flex-1 p-6 bg-gray-100">
        <h1 class="mb-4 text-2xl font-semibold">Client Details</h1>

        <div class="bg-white p-6 rounded-lg shadow">
            <p><strong>User:</strong> {{ $client->user->name }}</p>
            <p><strong>Company Name:</strong> {{ $client->company_name }}</p>
            <p><strong>Industry:</strong> {{ $client->industry }}</p>
            <p><strong>Contact Number:</strong> {{ $client->contact_number }}</p>
            <p><strong>Address:</strong> {{ $client->address }}</p>
            <p><strong>Website:</strong> <a href="{{ $client->website }}" class="text-blue-500" target="_blank">{{ $client->website }}</a></p>

            <a href="{{ route('admin.clients.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition inline-flex items-center mt-4">
                <i class="fas fa-arrow-left mr-2"></i> Back to Clients
            </a>
        </div>
    </div>
</div>
@endsection
