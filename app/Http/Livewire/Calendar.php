<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Event; // Replace this with your events model if different
use Carbon\Carbon;

class Calendar extends Component
{
    public $events = [];

    public function mount()
    {
        // Fetch events from the database and format them for FullCalendar
        $this->events = Event::all()->map(function ($event) {
            return [
                'title' => $event->name, // assuming your event model has 'name' field
                'start' => $event->start_date->toIso8601String(),
                'end' => $event->end_date ? $event->end_date->toIso8601String() : null,
            ];
        });
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}
