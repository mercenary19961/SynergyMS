@extends('layouts.app')

@section('content')
<div class="flex flex-col h-screen">
    <div class="flex-1 p-6 bg-gray-100">
        <x-title-with-back title="Project Manager Details" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="bg-white p-6 rounded-lg shadow-lg space-y-6 relative text-sm">
                <div class="border-b pb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex justify-center md:justify-start md:col-span-1">
                        @if($projectManager->user->image)
                            <img 
                                src="{{ asset('storage/' . $projectManager->user->image) }}" 
                                alt="Manager Image" 
                                class="rounded-full h-32 w-32 object-cover"
                            >
                        @else
                            <img 
                                src="{{ asset('images/default_user_image.png') }}" 
                                alt="Default Image" 
                                class="rounded-full h-32 w-32 object-cover"
                            >
                        @endif
                    </div>
                    
                    <!-- General Information (2/3 width) -->
                    <div class="md:col-span-2">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-orange-600">
                                <i class="fas fa-info-circle mr-2"></i>General Information
                            </h2>
                            @role('Super Admin|HR')
                            <a href="{{ route('admin.project-managers.edit', $projectManager->id) }}" 
                               class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            @endrole
                        </div>
                        <div class="grid grid-cols-1 gap-2 text-gray-600">
                            <div class="">
                                <p><strong><i class="fas fa-user mr-2 "></i>User Name:</strong> {{ $projectManager->user->name }}</p>
                            </div>
                            <div>
                                <p><strong><i class="fas fa-envelope mr-2"></i>Email:</strong> {{ $projectManager->user->email }}</p>
                            </div>
                            <div>
                                <p><strong><i class="fas fa-venus-mars mr-2"></i>Gender:</strong> {{ ucfirst($projectManager->user->gender) }}</p>
                            </div>
                            <div>
                                <p><strong><i class="fas fa-phone-alt mr-2"></i>Contact Number:</strong> {{ $projectManager->contact_number }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Professional Information -->
                <div class="border-b pb-4">
                    <h2 class="text-xl font-semibold text-orange-600 mb-4">
                        <i class="fas fa-briefcase mr-2"></i>Professional Information
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6 text-gray-600">
                        <div>
                            <p><strong><i class="fas fa-building mr-3 text-gray-600"></i>Department:</strong> {{ $projectManager->department->name }}</p>
                        </div>
                        <div>
                            <p><strong><i class="fas fa-history mr-2"></i>Experience Years:</strong> {{ $projectManager->experience_years }} years</p>
                        </div>
                        <div>
                            <p><strong><i class="fas fa-tasks mr-2"></i>Assigned Projects:</strong> {{ $projectManager->projects->count() }}</p>
                        </div>
                    </div>

                    <!-- Display assigned projects -->
                    @if($projectManager->projects->count() > 0)
                        <h3 class="text-lg font-semibold mt-6 mb-2 text-gray-600">
                            <i class="fas fa-project-diagram mr-2"></i>Assigned Projects
                        </h3>
                        <ul class="list-disc pl-6 space-y-1">
                            @foreach($projectManager->projects as $project)
                                <li>{{ $project->name }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">No projects assigned.</p>
                    @endif
                </div>
            </div>

            <!-- Right Column: Employees Managed by this Manager -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-orange-600 mb-4">
                    <i class="fas fa-users mr-2"></i>Employees in Department ({{ $projectManager->department->employees->count() }})
                </h2>
                @if($projectManager->department->employees->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100 text-left text-gray-600 uppercase text-xs leading-normal">
                                    <th class="py-3 px-4"><i class="fas fa-hashtag"></i></th>
                                    <th class="py-3 px-4"><i class="fas fa-user"></i> Employee Name</th>
                                    <th class="py-3 px-4"><i class="fas fa-briefcase"></i> Position</th>
                                    <th class="py-3 px-4"><i class="fas fa-phone-alt"></i> Contact</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 text-sm">
                                @foreach($projectManager->department->employees as $index => $employee)
                                    <tr class="border-b border-gray-200 cursor-pointer hover:bg-gray-100"
                                        onclick="window.location='{{ route('admin.employees.show', $employee->id) }}'">
                                        <td class="py-3 px-4">{{ $index + 1 }}</td>
                                        <td class="py-3 px-4 flex items-center">
                                            @if($employee->user && $employee->user->image)
                                                <img loading="lazy" src="{{ asset('storage/' . $employee->user->image) }}" alt="{{ $employee->user->name }}" class="rounded-full w-10 h-10 object-cover mr-2">
                                            @else
                                                <img src="{{ asset('images/default_user_image.png') }}" alt="{{ $employee->user->name }}" class="h-10 w-10 rounded-full mr-2">
                                            @endif
                                            {{ $employee->user->name }}
                                        </td>
                                        <td class="py-3 px-4">{{ $employee->position->name }}</td>
                                        <td class="py-3 px-4">{{ $employee->phone }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">No employees found in this department.</p>
                @endif
            </div>

        </div>
    </div>
    <x-footer />
</div>
@endsection
