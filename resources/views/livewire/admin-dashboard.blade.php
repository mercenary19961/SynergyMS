<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Timesheet Card -->
    <div class="bg-white p-6 rounded shadow text-center">
        <h2 class="text-xl font-semibold mb-4">Total Users</h2>
        <div class="text-4xl font-bold mb-4">{{ $totalUsers }}</div>
    </div>

    <!-- Tickets Card -->
    <div class="bg-white p-6 rounded shadow text-center">
        <h2 class="text-xl font-semibold mb-4">Recent Tickets</h2>
        <ul>
            @foreach($recentTickets as $ticket)
                <li>{{ $ticket->title }} - {{ $ticket->created_at->format('M d, Y') }}</li>
            @endforeach
        </ul>
    </div>
</div>
