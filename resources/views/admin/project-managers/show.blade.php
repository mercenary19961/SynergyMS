{{-- resources/views/admin/project-managers/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">
        <x-title-with-back title="Project Manager's Details" route="admin.project-managers.index" />

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-semibold mb-4">Details</h2>
            <p><strong>User Name:</strong> {{ $projectManager->user->name }}</p>
            <p><strong>Department:</strong> {{ $projectManager->department->name }}</p>
            <p><strong>Experience Years:</strong> {{ $projectManager->experience_years }}</p>
            <p><strong>Contact Number:</strong> {{ $projectManager->contact_number }}</p>
            <p><strong>Assigned Projects:</strong> {{ $projectManager->assigned_projects_count }}</p>

            <!-- Show Assigned Projects (Optional) -->
            @if($projectManager->projects->count() > 0)
                <h3 class="text-lg font-semibold mt-6 mb-2">Assigned Projects</h3>
                <ul class="list-disc pl-6">
                    @foreach($projectManager->projects as $project)
                        <li>{{ $project->name }}</li>
                    @endforeach
                </ul>
            @else
                <p>No projects assigned.</p>
            @endif

            <a href="{{ route('admin.project-managers.index') }}" class="mt-6 inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                <i class="fas fa-arrow-left mr-2"></i>Back to Project Managers
            </a>
        </div>
    </div>
</div>
@endsection
