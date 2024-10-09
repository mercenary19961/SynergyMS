@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    @include('partials.sidebar')

    <div class="flex-1 p-6 bg-gray-100">
        <x-title-with-back title="Department Details" route="admin.departments.index" />

        <!-- Department Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Department Description Section -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold mb-4">Department Description</h2>
                <p>{{ $department->description }}</p>
            </div>

            <!-- Positions Section -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold mb-4">Positions</h2>
                @if($department->positions->isEmpty())
                    <p>No positions found in this department.</p>
                @else
                    <ul class="list-disc pl-5">
                        @foreach($department->positions as $position)
                            <li>{{ $position->name }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Employees Section -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold mb-4">Employees</h2>
                @if($department->employees->isEmpty())
                    <p>No employees found in this department.</p>
                @else
                    <ul class="list-disc pl-5">
                        @foreach($department->employees as $employee)
                            <li>{{ $employee->user->name }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Project Managers Section -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold mb-4">Project Managers</h2>
                @if($department->project_managers->isEmpty())
                    <p>No project managers found in this department.</p>
                @else
                    <ul class="list-disc pl-5">
                        @foreach($department->project_managers as $manager)
                            <li>{{ $manager->user->name }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
