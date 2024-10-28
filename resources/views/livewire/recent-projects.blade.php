<div wire:poll.{{ $pollingInterval }}="refreshRecentProjects" class="bg-white p-6 rounded shadow flex flex-col h-full">
    <i class="fas fa-list-check fa-2x text-orange-500 mb-2"></i>
    <h2 class="text-xl font-semibold mb-4">Recent Projects</h2>
    
    <ul class="text-sm flex-grow">
        @foreach ($recentProjects as $project)
            <li class="mb-4">
                <!-- Project Item -->
                <a href="{{ route('admin.projects.show', $project->id) }}" class="flex flex-col w-full text-left focus:outline-none transition-transform transform hover:scale-105 p-2 rounded transition">
                    <!-- Project Name -->
                    <div class="flex-grow">
                        <span class="truncate block font-semibold text-gray-600" title="{{ $project->name }}">
                            {{ Str::limit($project->name, 40) }}
                        </span>
                    </div>
                    <!-- Client and Project Manager, with Start Time aligned to the right -->
                    <div class="flex justify-between">
                        <div class="text-gray-500 text-xs">
                            Client: {{ $project->client->user->name ?? 'N/A' }} 
                        </div>
                        <span class="text-gray-500 text-xxs whitespace-nowrap">
                            (Started {{ $project->created_at->diffForHumans() }})
                        </span>
                    </div>
                </a>

                <!-- Divider -->
                <hr class="my-2 border-gray-300">
            </li>
        @endforeach
    </ul>

    <a href="{{ route('admin.projects.index') }}" class="block bg-orange-500 text-white text-center py-2 rounded mt-4">
        View All Projects
    </a>
</div>
