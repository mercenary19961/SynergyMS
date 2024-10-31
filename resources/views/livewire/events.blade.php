<div class="bg-white rounded-lg shadow-lg p-4">
    <h2 class="text-xl font-semibold text-orange-500 mb-4 flex items-center">
        <i class="fas fa-calendar-alt mr-2"></i> Nearest Event    </h2>
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
