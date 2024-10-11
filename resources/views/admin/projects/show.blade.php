@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">
        <x-title-with-back title="Project Details" />

        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
            
            <!-- Project Name -->
            <div class="lg:col-span-1">
                <label class="block text-sm font-medium text-orange-500">
                    <i class="fas fa-tasks text-gray-700 mr-1"></i> Project Name
                </label>
                <p class="mt-1 block w-full border border-gray-300 rounded-md p-1.5 bg-white">{{ $project->name }}</p>
            </div>

            <!-- Department -->
            <div class="lg:col-span-1">
                <label class="block text-sm font-medium text-orange-500">
                    <i class="fas fa-building text-gray-700 mr-1"></i> Department
                </label>
                <p class="mt-1 block w-full border border-gray-300 rounded-md p-1.5 bg-white">{{ $project->department->name ?? 'N/A' }}</p>
            </div>

            <!-- Client -->
            <div class="lg:col-span-1">
                <label class="block text-sm font-medium text-orange-500">
                    <i class="fas fa-handshake text-gray-700 mr-1"></i> Client
                </label>
                <p class="mt-1 block w-full border border-gray-300 rounded-md p-1.5 bg-white">{{ $project->client->company_name ?? 'N/A' }}</p>
            </div>

            <!-- Status -->
            <div class="lg:col-span-1">
                <label class="block text-sm font-medium text-orange-500">
                    <i class="fas fa-tasks text-gray-700 mr-1"></i> Status
                </label>
                <p class="mt-1 block w-full border border-gray-300 rounded-md p-1.5 bg-white">{{ $project->status }}</p>
            </div>

            <!-- Start Date -->
            <div class="lg:col-span-1">
                <label class="block text-sm font-medium text-orange-500">
                    <i class="fas fa-calendar-alt text-gray-700 mr-1"></i> Start Date
                </label>
                <p class="mt-1 block w-full border border-gray-300 rounded-md p-1.5 bg-white">{{ $project->start_date ? $project->start_date->format('M d, Y') : 'N/A' }}</p>
            </div>

            <!-- End Date -->
            <div class="lg:col-span-1">
                <label class="block text-sm font-medium text-orange-500">
                    <i class="fas fa-calendar-alt text-gray-700 mr-1"></i> End Date
                </label>
                <p class="mt-1 block w-full border border-gray-300 rounded-md p-1.5 bg-white">{{ $project->end_date ? $project->end_date->format('M d, Y') : 'N/A' }}</p>
            </div>

            <!-- Description -->
            <div class="lg:col-span-2">
                <label class="block text-sm font-medium text-orange-500">
                    <i class="fas fa-align-left text-gray-700 mr-1"></i> Description
                </label>
                <p class="mt-1 block w-full border border-gray-300 rounded-md p-1.5 bg-white">{{ $project->description ?? 'No description available' }}</p>
            </div>

            <!-- Project Manager -->
            <div class="lg:col-span-1">
                <label class="block text-sm font-medium text-orange-500">
                    <i class="fas fa-user-tie text-gray-700 mr-1"></i> Project Manager
                </label>
                <p class="mt-1 block w-full border border-gray-300 rounded-md p-1.5 bg-white">{{ $project->projectManager->user->name ?? 'N/A' }}</p>
            </div>

        </div>

        <!-- Actions -->
        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('admin.projects.edit', $project->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                <i class="fas fa-edit mr-2"></i>Edit Project
            </a>

            <form method="POST" action="{{ route('admin.projects.destroy', $project->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition" onclick="return confirm('Are you sure you want to delete this project?')">
                    <i class="fas fa-trash-alt mr-2"></i>Delete Project
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
