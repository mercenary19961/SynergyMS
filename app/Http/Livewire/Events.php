<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Event;
use Carbon\Carbon;

class Events extends Component
{
    public $currentDate;
    public $events = [];

    public function mount()
    {
        $this->currentDate = Carbon::now();
        $this->loadEvents();
    }

    public function loadEvents()
    {
        // Fetch upcoming events from the database, ordered by start date
        $this->events = Event::where('start_date', '>=', $this->currentDate)
                             ->orderBy('start_date', 'asc')
                             ->limit(1) // limit to show only a few upcoming events
                             ->get(['name as event', 'start_date as date'])
                             ->toArray();
    }

    public function render()
    {
        return view('livewire.events');
    }
}
