@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <div class="flex-1 p-6 bg-gray-100">
        <x-title-with-back title="Profile" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column: User Information -->
            <div class="bg-white p-6 rounded-lg shadow-lg space-y-6 relative text-sm h-full">
                <div class="border-b pb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex justify-center md:justify-start md:col-span-1">
                        @if($user->image)
                            <img 
                                src="{{ asset('storage/' . $user->image) }}" 
                                alt="User Image" 
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
                        </div>
                        <div class="grid grid-cols-1 gap-2 text-gray-600">
                            <div class="mb-2">
                                <p><strong><i class="fas fa-user mr-2"></i> Name:</strong> {{ $user->name }}</p>
                            </div>
                            <div class="mb-2">
                                <p><strong><i class="fas fa-envelope mr-2"></i> Email:</strong> {{ $user->email }}</p>
                            </div>
                            <div class="mb-2">
                                <p><strong><i class="fas fa-venus-mars mr-2"></i> Gender:</strong> {{ ucfirst($user->gender) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Employee Specific Information -->
                @if($user->hasRole('Employee'))
                    <div class="bg-white mt-6 p-6 rounded-lg shadow-lg">
                        <h2 class="text-xl font-semibold text-orange-600 mb-4">
                            <i class="fas fa-briefcase mr-2"></i> Employee Details
                        </h2>
                        <div class="grid grid-cols-1 gap-2 text-gray-600">
                            <div>
                                <p><strong><i class="fas fa-building mr-2"></i> Department:</strong> {{ $user->employeeDetail->department->name }}</p>
                            </div>
                            <div>
                                <p><strong><i class="fas fa-user-tie mr-2"></i> Position:</strong> {{ $user->employeeDetail->position->name }}</p>
                            </div>
                            <div>
                                <p><strong><i class="fas fa-money-bill-wave mr-2"></i> Salary:</strong> ${{ number_format($user->employeeDetail->salary, 2) }}</p>
                            </div>
                            <div>
                                <p><strong><i class="fas fa-calendar-alt mr-2"></i> Date of Joining:</strong> {{ $user->employeeDetail->date_of_joining->format('d-m-Y') }}</p>
                            </div>
                            <div>
                                <p><strong><i class="fas fa-flag mr-2"></i> Nationality:</strong> {{ $user->employeeDetail->nationality }}</p>
                            </div>
                            <div>
                                <p><strong><i class="fas fa-calendar-day mr-2"></i> Date of Birth:</strong> {{ $user->employeeDetail->date_of_birth->format('d-m-Y') }}</p>
                            </div>
                            <div>
                                <p><strong><i class="fas fa-map-marker-alt mr-2"></i> Address:</strong> {{ $user->employeeDetail->address }}</p>
                            </div>
                            <div>
                                <p><strong><i class="fas fa-user-clock mr-2"></i> Age:</strong> {{ $user->employeeDetail->age }}</p>
                            </div>
                            <div>
                                <p><strong><i class="fas fa-phone mr-2"></i> Phone:</strong> {{ $user->employeeDetail->phone }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- HR Section for Super Admin or HR -->
                @if($user->hasRole('Super Admin') || $user->hasRole('HR'))
                    <div class="bg-white mt-6 p-6 rounded-lg shadow-lg">
                        <h2 class="text-xl font-semibold text-orange-600 mb-4">
                            <i class="fas fa-users mr-2"></i>HR Employees ({{ $humanResources->count() }})
                        </h2>
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-100 text-left text-gray-600 uppercase text-xs leading-normal">
                                        <th class="py-3 px-4"><i class="fas fa-hashtag"></i></th>
                                        <th class="py-3 px-4"><i class="fas fa-user"></i> Name</th>
                                        <th class="py-3 px-4"><i class="fas fa-briefcase"></i> Position</th>
                                        <th class="py-3 px-4"><i class="fas fa-phone-alt"></i> Contact</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700 text-sm">
                                    @foreach($humanResources as $index => $humanResource)
                                        <tr class="border-b border-gray-200 cursor-pointer hover:bg-gray-100" 
                                            onclick="window.location='{{ route('admin.human-resources.show', $humanResource->id) }}'">
                                            <td class="py-3 px-4">{{ $index + 1 }}</td>
                                            <td class="py-3 px-4 flex items-center">
                                                @if($humanResource->user && $humanResource->user->image)
                                                    <img loading="lazy" src="{{ asset('storage/' . $humanResource->user->image) }}" alt="{{ $humanResource->user->name }}" class="rounded-full w-10 h-10 object-cover mr-2">
                                                @else
                                                    <img src="{{ asset('images/default_user_image.png') }}" alt="{{ $humanResource->user->name }}" class="h-10 w-10 rounded-full mr-2">
                                                @endif
                                                {{ $humanResource->user->name }}
                                            </td>
                                            <td class="py-3 px-4">{{ $humanResource->position->name }}</td>
                                            <td class="py-3 px-4">{{ $humanResource->contact_number }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column: Role-Based Display -->
            @if($user->hasRole('Super Admin'))
                <!-- Display clients for Super Admin -->
                <div class="bg-white p-6 rounded-lg shadow-lg h-full flex-grow">
                    <h2 class="text-xl font-semibold text-orange-600 mb-4">
                        <i class="fas fa-users mr-2"></i>Clients ({{ $clients->count() }})
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100 text-left text-gray-600 uppercase text-xs leading-normal">
                                    <th class="py-3 px-4"><i class="fas fa-hashtag"></i></th>
                                    <th class="py-3 px-4"><i class="fas fa-user-tie"></i> Client Name</th>
                                    <th class="py-3 px-4"><i class="fas fa-building"></i> Company Name</th>
                                    <th class="py-3 px-4 "><i class="fas fa-phone-alt"></i> Number</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 text-sm">
                                @foreach($clients as $index => $client)
                                    <tr class="border-b border-gray-200 cursor-pointer hover:bg-gray-100"
                                        onclick="window.location='{{ route('admin.clients.show', $client->id) }}'">
                                        <td class="py-3 px-4">{{ $index + 1 }}</td>
                                        <td class="py-3 px-4 flex items-center">
                                            @if($client->user && $client->user->image)
                                                <img loading="lazy" src="{{ asset('storage/' . $client->user->image) }}" alt="{{ $client->user->name }}" class="rounded-full w-10 h-10 object-cover mr-2">
                                            @else
                                                <img src="{{ asset('images/default_user_image.png') }}" alt="{{ $client->user->name }}" class="h-10 w-10 rounded-full mr-2">
                                            @endif
                                            {{ $client->user->name }}
                                        </td>
                                        <td class="py-3 px-4">{{ $client->company_name }}</td>
                                        <td class="py-3 px-4">{{ $client->contact_number }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @elseif($user->hasRole('Project Manager') && $employees->count() > 0)
                <!-- Display employees for Project Manager -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-xl font-semibold text-orange-600 mb-4">
                        <i class="fas fa-users mr-2"></i>Employees in Department ({{ $employees->count() }})
                    </h2>
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
                                @foreach($employees as $index => $employee)
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
                </div>
            @elseif($user->hasRole('Employee'))
            <!-- Projects Section for Employee -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-orange-600 mb-4">
                    <i class="fas fa-project-diagram mr-2"></i> Projects Worked On
                </h2>
                @if($user->employeeDetail->projects->isEmpty())
                    <p class="text-gray-600">No projects assigned yet.</p>
                @else
                    <div class="overflow-y-auto max-h-96"> <!-- Added vertical scrolling only -->
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100 text-left text-gray-600 uppercase text-xs leading-normal">
                                    <th class="py-3 px-4"><i class="fas fa-hashtag"></i></th>
                                    <th class="py-3 px-4"><i class="fas fa-tasks"></i> Project Name</th>
                                    <th class="py-3 px-4"><i class="fas fa-clock"></i> Status</th>
                                    <th class="py-3 px-4"><i class="fas fa-calendar-day"></i> Start Date</th>
                                    <th class="py-3 px-4"><i class="fas fa-calendar-check"></i> End Date</th>
                                </tr>
                            </thead>
                            <!-- Set a max height and overflow for vertical scrolling only -->
                            <tbody class="text-gray-700 text-sm">
                                @foreach($user->employeeDetail->projects as $index => $project)
                                    <tr class="border-b border-gray-200 cursor-pointer hover:bg-gray-100"
                                        onclick="window.location='{{ route('admin.projects.show', $project->id) }}'">
                                        <td class="py-3 px-4">{{ $index + 1 }}</td>
                                        <td class="py-3 px-4">{{ $project->name }}</td>
                                        <td class="py-3 px-4">{{ ucfirst($project->status) }}</td>
                                        <td class="py-3 px-4">{{ $project->start_date->format('d-m-Y') }}</td>
                                        <td class="py-3 px-4">{{ $project->end_date ? $project->end_date->format('d-m-Y') : 'Ongoing' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
