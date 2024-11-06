<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class Calendar extends Component
{
    public $events = [];

    public function mount()
    {
        $user = Auth::user();

        $this->events = Event::query()
            ->where(function ($query) use ($user) {
                // If the user has the "HR" role, show all events
                if ($user->hasRole('HR')) {
                    return;
                }

                // General events visible to all
                $query->where('is_general', true);

                // Events targeted to the user's roles
                $userRoles = $user->getRoleNames(); // Get all role names assigned to the user
                $query->orWhereIn('target_role', $userRoles);

                // Events targeted to the user's department
                if ($user->employeeDetail && $user->employeeDetail->department_id) {
                    $query->orWhere('target_department_id', $user->employeeDetail->department_id);
                }
            })
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->name,
                    'start' => $event->start_date->toIso8601String(),
                    'end' => $event->end_date ? $event->end_date->toIso8601String() : null,
                ];
            })
            ->toArray();
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}
