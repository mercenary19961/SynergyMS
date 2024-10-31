<div wire:poll.{{ $pollingInterval }}="refreshRecentClients" class="bg-white p-6 rounded shadow flex flex-col h-full">
    <div class="flex flex-row justify-start">
        <i class="fas fa-user-tie fa-2x text-orange-500 mb-2"></i>
        <h2 class="text-xl font-semibold mb-4 ml-4">Recent Clients</h2>
    </div>

    <ul class="text-sm flex-grow">
        @foreach ($recentClients as $client)
            <li class="mb-4">
                <!-- Client Item -->
                <a href="{{ route('admin.clients.show', $client->id) }}" class="flex items-center justify-between space-x-4 w-full text-left focus:outline-none transition-transform transform hover:scale-105 rounded transition p-2">
                    <!-- Client Image -->
                    <img src="{{ $client->user->image ? asset('storage/' . $client->user->image) : asset('default-avatar.png') }}" 
                         alt="{{ $client->user->name }}" 
                         class="w-10 h-10 rounded-full object-cover">

                    <!-- Client Name and Join Date -->
                    <div class="flex-grow">
                        <span class="truncate block font-semibold text-gray-600">
                            {{ Str::limit($client->user->name, 30) }}
                        </span>
                    </div>

                    <!-- Joined Date (on the far right) -->
                    <span class="text-gray-500 text-xxs whitespace-nowrap">
                        (Joined {{ $client->created_at->diffForHumans() }})
                    </span>
                </a>
                <!-- Divider -->
                <hr class="my-1 border-gray-300">
            </li>
        @endforeach
    </ul>
    
    <a href="{{ route('admin.clients.index') }}" class="block bg-orange-500 text-white text-center py-2 rounded mt-4">
        View All Clients
    </a>
</div>
