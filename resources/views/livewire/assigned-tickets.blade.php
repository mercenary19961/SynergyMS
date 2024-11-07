<div class="bg-white p-4 rounded shadow">
    <h2 class="font-semibold text-lg mb-4">Assigned Tickets</h2>
    <ul>
        @foreach($tickets as $ticket)
            <li class="mb-2">
                <p class="font-semibold">{{ $ticket->title }}</p>
                <p class="text-sm text-gray-500">{{ $ticket->description }}</p>
            </li>
        @endforeach
    </ul>
</div>
