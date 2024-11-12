<div class="bg-white p-3 rounded shadow-lg h-[32rem]">
    <div class="flex justify-center items-center mb-6">
        <i class="fas fa-briefcase text-orange-500 mr-2"></i>
        <h2 class="font-semibold text-lg">Assigned Projects</h2>
    </div>
    
    <div class="overflow-x-auto">
        <ul class="flex space-x-4">
            @forelse($projects as $project)
                <li class="bg-gray-50 p-4 rounded shadow flex flex-col justify-between min-w-[300px] h-[24rem]">
                    <!-- Project Title and Description -->
                    <div class="flex flex-col flex-grow">
                        <p class="font-semibold text-lg text-orange-600">{{ $project->name }}</p>
                        <p class="text-sm text-gray-500 flex-grow">{{ $project->description }}</p>
                        
                        <!-- Project Information: Client, Deadline, Project Leader -->
                        <div class="mt-4">
                            <p class="text-gray-700 text-sm"><strong>Client:</strong> <span class="text-gray-500">{{ $project->client->user->name }}</span></p>
                            <p class="text-gray-700 text-sm"><strong>Deadline:</strong> <span class="text-gray-500">{{ $project->end_date->format('d M Y') }}</span></p>
                            <p class="text-gray-700 text-sm"><strong>Project Leader:</strong></p>
                            <div class="flex items-center mt-1">
                                <img src="{{ asset('storage/' . $project->projectManager->user->image) }}" alt="Leader Image" class="w-8 h-8 rounded-full border-2 border-gray-300">
                                <span class="ml-2 text-gray-500 text-sm">{{ $project->projectManager->user->name }}</span>
                            </div>
                        </div>
                        
                        <!-- Team Members Section -->
                        <div class="mt-4">
                            <p class="text-gray-700 text-sm"><strong>Team:</strong></p>
                            <div class="flex -space-x-2 mt-1">
                                @foreach($project->tasks->unique('employee.id') as $task)
                                    <img src="{{ asset('storage/' . $task->employee->user->image) }}" alt="{{ $task->employee->name }}" title="{{ $task->employee->name }}" class="w-8 h-8 rounded-full border-2 border-gray-300">
                                @endforeach
                                @if($project->tasks->unique('employee.id')->count() > 5)
                                    <span class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center text-xs">+{{ $project->tasks->unique('employee.id')->count() - 5 }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- View Project Button -->
                    <div class="flex justify-center mt-auto pt-4">
                        <a href="{{ route('admin.projects.show', $project->id) }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-full text-center">View Project</a>
                    </div>
                </li>
            @empty
                <!-- Message when no projects are assigned -->
                <div class="flex flex-col items-center justify-center w-full h-[24rem] text-center bg-gray-50 rounded p-6">
                    <p class="text-gray-500 mb-4">You are not assigned to any projects currently. Please wait for a project manager to assign a project.</p>
                </div>
            @endforelse
        </ul>
    </div>
</div>
