@extends('layouts.app')

@section('content')
<div class="flex flex-col h-screen">
    <div class="flex-1 p-6 bg-gray-100">
        <x-title-with-back title="Project Details" />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Project Info Section -->
            <div class="bg-white shadow-lg rounded-lg p-6 col-span-1 lg:col-span-2">
                <h2 class="text-2xl font-bold text-orange-500 mb-4">
                    <i class="fas fa-project-diagram mr-2"></i> {{ $project->name }}
                </h2>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <!-- Department -->
                    <div>
                        <p class="text-sm font-semibold text-gray-700">
                            <i class="fas fa-building text-gray-700 mr-1"></i> Department
                        </p>
                        <p class="mt-1 text-sm text-gray-600">{{ $project->department->name ?? 'N/A' }}</p>
                    </div>

                    <!-- Client -->
                    <div>
                        <p class="text-sm font-semibold text-gray-700">
                            <i class="fas fa-handshake text-gray-700 mr-1"></i> Client
                        </p>
                        <p class="mt-1 text-sm text-gray-600">{{ $project->client->company_name ?? 'N/A' }}</p>
                    </div>

                    <!-- Status -->
                    <div>
                        <p class="text-sm font-semibold text-gray-700">
                            <i class="fas fa-tasks text-gray-700 mr-1"></i> Status
                        </p>
                        <p class="mt-1 text-sm font-semibold 
                        @if($project->status == 'Pending') text-orange-500 
                        @elseif($project->status == 'In Progress') text-yellow-500 
                        @elseif($project->status == 'Completed') text-green-500 
                        @else text-gray-500 @endif">
                        {{ $project->status }}</p>
                    </div>

                    <!-- Start Date -->
                    <div>
                        <p class="text-sm font-semibold text-gray-700">
                            <i class="fas fa-calendar-alt text-gray-700 mr-1"></i> Start Date
                        </p>
                        <p class="mt-1 text-sm text-gray-600">{{ $project->start_date ? $project->start_date->format('M d, Y') : 'N/A' }}</p>
                    </div>

                    <!-- End Date -->
                    <div>
                        <p class="text-sm font-semibold text-gray-700">
                            <i class="fas fa-calendar-alt text-gray-700 mr-1"></i> End Date
                        </p>
                        <p class="mt-1 text-sm text-gray-600">{{ $project->end_date ? $project->end_date->format('M d, Y') : 'N/A' }}</p>
                    </div>

                    <!-- Project Manager -->
                    <div>
                        <p class="text-sm font-semibold text-gray-700">
                            <i class="fas fa-user-tie text-gray-700 mr-1"></i> Project Manager
                        </p>
                        <p class="mt-1 text-sm text-gray-600">{{ $project->projectManager->user->name ?? 'N/A' }}</p>
                    </div>

                    <!-- Description -->
                    <div class="lg:col-span-2">
                        <p class="text-sm font-semibold text-gray-700">
                            <i class="fas fa-align-left text-gray-700 mr-1"></i> Description
                        </p>
                        <p class="mt-1 text-sm text-gray-600">{{ $project->description ?? 'No description available' }}</p>
                    </div>
                </div>
            </div>

            <!-- Tasks Section -->
            <div class="bg-white shadow-lg rounded-lg p-6 col-span-1 lg:col-span-2">
                <h2 class="text-2xl font-bold text-orange-500 mb-4">
                    <i class="fas fa-tasks mr-2"></i> Tasks
                </h2>
                @if($project->tasks->isEmpty())
                    <p class="text-sm text-gray-600">No tasks available for this project.</p>
                @else
                    <div class="space-y-4">
                        @foreach($project->tasks as $task)
                            <div class="p-4 border border-gray-300 rounded-md bg-gray-50">
                                <p class="text-sm font-semibold text-gray-700">{{ $task->name }}</p>
                                <p class="text-xs text-gray-500">Assigned To: 
                                    <span class="font-medium text-gray-700">{{ $task->employee->name ?? 'N/A' }}</span>
                                </p>
                                <p class="text-xs text-gray-500">Status: 
                                    <span class="font-medium 
                                        @if($task->status == 'Pending') text-orange-500 
                                        @elseif($task->status == 'In Progress') text-yellow-500 
                                        @elseif($task->status == 'Completed') text-green-500 
                                        @else text-gray-500 @endif">
                                        {{ ucfirst($task->status) }}
                                    </span>
                                </p>
                                <p class="text-xs text-gray-500">Priority: 
                                    <span class="font-medium 
                                        @if($task->priority == 'High') text-red-500 
                                        @elseif($task->priority == 'Medium') text-yellow-500 
                                        @elseif($task->priority == 'Low') text-green-500 
                                        @else text-gray-500 @endif">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="lg:col-span-1 flex flex-col justify-center space-y-4">
                @if(auth()->user()->hasRole('Super Admin') || auth()->user()->id === $project->projectManager->user->id)
                    <!-- Edit Project Button -->
                    <a href="{{ route('admin.projects.edit', $project->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition text-center">
                        <i class="fas fa-edit mr-2"></i>Edit Project
                    </a>

                    <!-- Delete Project Button -->
                    <form method="POST" action="{{ route('admin.projects.destroy', $project->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition text-center" onclick="return confirm('Are you sure you want to delete this project?')">
                            <i class="fas fa-trash-alt mr-2"></i>Delete Project
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    <x-footer />
</div>
@endsection
