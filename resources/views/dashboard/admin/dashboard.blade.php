@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Example Cards -->
        <div class="bg-white shadow-lg rounded-lg p-4">
            <h2 class="text-lg font-bold mb-2">Users Management</h2>
            <p>Manage all users, create new users, and update roles.</p>
            <a href="{{ route('admin.users.index') }}" class="text-blue-500 hover:underline mt-4 inline-block">Manage Users</a>
        </div>

        <div class="bg-white shadow-lg rounded-lg p-4">
            <h2 class="text-lg font-bold mb-2">Roles Management</h2>
            <p>Define roles and permissions for the users.</p>
            <a href="{{ route('admin.roles.index') }}" class="text-blue-500 hover:underline mt-4 inline-block">Manage Roles</a>
        </div>

        <div class="bg-white shadow-lg rounded-lg p-4">
            <h2 class="text-lg font-bold mb-2">Settings</h2>
            <p>Configure system settings and application options.</p>
            <a href="{{ route('admin.settings.index') }}" class="text-blue-500 hover:underline mt-4 inline-block">Settings</a>
        </div>
        
        <!-- Add more cards as needed for other sections -->
    </div>
</div>
@endsection
