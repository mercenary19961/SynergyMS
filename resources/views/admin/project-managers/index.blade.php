{{-- resources/views/admin/project-managers/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">
        <h1 class="mb-4 text-2xl font-semibold">Project Managers</h1>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Add New Project Manager Button -->
        <a href="{{ route('admin.project-managers.create') }}" class="btn btn-primary mb-3">Add New Project Manager</a>

        <!-- Project Managers Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 text-left">#</th>
                        <th class="py-2 px-4 text-left">User Name</th>
                        <th class="py-2 px-4 text-left">Department</th>
                        <th class="py-2 px-4 text-left">Experience Years</th>
                        <th class="py-2 px-4 text-left">Contact Number</th>
                        <th class="py-2 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projectManagers as $projectManager)
                        <tr class="border-t">
                            <td class="py-2 px-4">{{ $projectManager->id }}</td>
                            <td class="py-2 px-4">{{ $projectManager->user->name }}</td>
                            <td class="py-2 px-4">{{ $projectManager->department->name }}</td>
                            <td class="py-2 px-4">{{ $projectManager->experience_years }}</td>
                            <td class="py-2 px-4">{{ $projectManager->contact_number }}</td>
                            <td class="py-2 px-4">
                                <a href="{{ route('admin.project-managers.edit', $projectManager->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.project-managers.destroy', $projectManager->id) }}" method="POST" style="display:inline-block;">
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
