<div class="bg-white rounded-lg shadow-lg p-4">
    <div class="flex items-center justify-between mb-4">
        <!-- Left Side: Title and Icon -->
        <h2 class="text-xl font-semibold text-orange-500 flex items-center">
            <i class="fas fa-calendar-alt mr-2"></i> Nearest Event
        </h2>
        
        <!-- Right Side: Events Button -->
        <a href="{{ route('admin.events.index') }}" class="bg-orange-500 text-white text-sm px-2 py-2 rounded hover:bg-orange-600 transition inline-flex items-center">
             Events
        </a>
    </div>

    <!-- Event List -->
    <ul class="space-y-2">
        @if(!empty($events))
            @foreach($events as $event)
                <li class="p-3 border border-gray-200 rounded-md bg-gray-50">
                    <span class="text-gray-600 font-semibold text-sm">{{ $event['event'] }}</span><br>
                    <span class="text-gray-500 text-xs">({{ \Carbon\Carbon::parse($event['date'])->diffForHumans() }})</span>
                </li>
            @endforeach
        @else
            <li class="text-gray-500">No upcoming events.</li>
        @endif
    </ul>
</div>
