@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <div class="flex-1 p-6 bg-gray-100">
        <x-title-with-back title="Client Details" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="bg-white p-6 rounded-lg shadow-lg space-y-6 relative text-sm">
                <div class="border-b pb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex justify-center md:justify-start md:col-span-1">
                        @if($client->user->image)
                            <img 
                                src="{{ asset('storage/' . $client->user->image) }}" 
                                alt="Client Image" 
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
                    
                    <div class="md:col-span-2">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-orange-600">
                                <i class="fas fa-info-circle mr-2"></i>General Information
                            </h2>
                            <a href="{{ route('admin.clients.edit', $client->id) }}" 
                               class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                        </div>
                        <div class="grid grid-cols-1 gap-2 text-gray-600">
                            <div>
                                <p><strong><i class="fas fa-user mr-2"></i>Client Name:</strong> {{ $client->user->name }}</p>
                            </div>
                            <div>
                                <p><strong><i class="fas fa-building mr-2"></i>Company Name:</strong> {{ $client->company_name }}</p>
                            </div>
                            <div>
                                <p><strong><i class="fas fa-industry mr-2"></i>Industry:</strong> {{ $client->industry }}</p>
                            </div>
                            <div>
                                <p><strong><i class="fas fa-phone-alt mr-2"></i>Contact Number:</strong> {{ $client->contact_number }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-b pb-4">
                    <h2 class="text-xl font-semibold text-orange-600 mb-4">
                        <i class="fas fa-briefcase mr-2"></i>Professional Information
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6 text-gray-600">
                        <div>
                            <p><strong><i class="fas fa-map-marker-alt mr-2"></i>Address:</strong> {{ $client->address }}</p>
                        </div>
                        <div>
                            <p><strong><i class="fas fa-globe mr-2"></i>Website:</strong> <a href="{{ $client->website }}" target="_blank" class="text-blue-500 hover:underline">{{ $client->website }}</a></p>
                        </div>
                        <div>
                            <p><strong><i class="fas fa-tasks mr-2"></i>Assigned Projects:</strong> {{ $client->projects->count() }}</p>
                        </div>
                    </div>

                    @if($client->projects->count() > 0)
                        <h3 class="text-lg font-semibold mt-6 mb-2 text-gray-600">
                            <i class="fas fa-project-diagram mr-2"></i>Assigned Projects
                        </h3>
                        <ul class="list-disc pl-6 space-y-1">
                            @foreach($client->projects as $project)
                                <li>{{ $project->name }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">No projects assigned.</p>
                    @endif
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-orange-600 mb-4">
                    <i class="fas fa-users mr-2"></i>Client Projects ({{ $client->projects->count() }})
                </h2>
                @if($client->projects->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100 text-left text-gray-600 uppercase text-xs leading-normal">
                                    <th class="py-3 px-4"><i class="fas fa-hashtag"></i></th>
                                    <th class="py-3 px-4"><i class="fas fa-briefcase"></i> Project Name</th>
                                    <th class="py-3 px-4"><i class="fas fa-calendar-alt"></i> Start Date</th>
                                    <th class="py-3 px-4"><i class="fas fa-calendar-alt"></i> End Date</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 text-sm">
                                @foreach($client->projects as $index => $project)
                                    <tr class="border-b border-gray-200">
                                        <td class="py-3 px-4">{{ $index + 1 }}</td>
                                        <td class="py-3 px-4">{{ $project->name }}</td>
                                        <td class="py-3 px-4">{{ $project->start_date->format('Y-m-d') }}</td>
                                        <td class="py-3 px-4">{{ $project->end_date ? $project->end_date->format('Y-m-d') : 'Ongoing' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">No projects found for this client.</p>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
