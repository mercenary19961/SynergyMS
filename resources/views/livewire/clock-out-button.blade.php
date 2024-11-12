<div wire:poll.60s="checkClockOut">
    @if ($autoClockOut)
        <button class="bg-gray-500 text-white px-4 py-2 rounded" disabled>
            Clocked Out Automatically (Total Hours: {{ $hoursWorked }})
        </button>
    @elseif ($hoursWorked >= 6)
        <form wire:submit.prevent="checkClockOut">
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                Clock Out (Total Hours: {{ $hoursWorked }})
            </button>
        </form>
    @else
        <button class="bg-gray-500 text-white px-4 py-2 rounded" disabled>
            Clock Out (Available after 6 hours)
        </button>
    @endif
</div>
