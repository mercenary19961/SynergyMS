@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <div class="flex-1 p-6 bg-gray-100 text-gray-700 text-sm">
        <x-title-with-back title="Department Details" route="admin.departments.index" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                    <h2 class="text-sm font-semibold mb-4 text-orange-500">
                        <i class="fas fa-building mr-2"></i> Department Name
                    </h2>
                    <p class="text-gray-700 text-sm"> {{ $department->name }} </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                    <h2 class="text-sm font-semibold mb-4 text-orange-500">
                        <i class="fas fa-building mr-2"></i>Department Description
                    </h2>
                    <p class="text-gray-700 text-sm">{{ $department->description }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-sm font-semibold mb-4 text-orange-500">
                        <i class="fas fa-user-tie mr-2"></i>Project Manager
                    </h2>
                    @if($department->project_manager)
                        <p>{{ $department->project_manager->user->name }}</p>
                    @else
                        <p>No project manager assigned to this department.</p>
                    @endif
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-sm font-semibold mb-4 text-orange-500">
                    <i class="fas fa-users mr-2"></i>Positions and Employees
                </h2>
                @if($department->positions && $department->positions->isEmpty())
                    <p>No positions found in this department.</p>
                @else
                    @foreach($department->positions as $position)
                        <div class="mb-6">
                            <h3 class="text-md font-semibold">{{ $position->name }}</h3>
                            <ul class="list-disc pl-5">
                                @php
                                    $employeesInPosition = $department->employees->filter(function ($employee) use ($position) {
                                        return $employee->position_id === $position->id;
                                    });
                                @endphp
                                
                                @if($employeesInPosition && $employeesInPosition->isEmpty())
                                    <li>No employees assigned to this position.</li>
                                @else
                                    @foreach($employeesInPosition as $employee)
                                        <li>{{ $employee->user->name }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
