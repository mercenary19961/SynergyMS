<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class EmployeeSummaryCard extends Component
{
    public $title;
    public $icon;
    public $route;
    public $countType;
    public $count;
    public $pollingInterval = 5000;

    public function mount($title, $icon, $route, $countType)
    {
        $this->title = $title;
        $this->icon = $icon;
        $this->route = $route;
        $this->countType = $countType;
        $this->count = $this->getCount();
    }

    public function render()
    {
        return view('livewire.employee-summary-card');
    }

    public function getCount()
    {
        $user = Auth::user();
        $employeeDetail = $user->employeeDetail;

        if (!$employeeDetail) {
            return 0;
        }

        switch ($this->countType) {
            case 'assignedProjects':
                $count = $employeeDetail->projects()->count();
                break;
            case 'tasks':
                $count = $employeeDetail->tasks()->count();
                break;
            case 'assignedTickets':
                $count = $employeeDetail->tickets()->count();
                break;
            case 'attendingEvents':
                $count = $user->attendingEvents()->count();
                break;
            default:
                $count = 0;
        }

        return $count;
    }

    // Livewire method to refresh the count
    public function refreshCount()
    {
        $this->count = $this->getCount();
    }

    public function getListeners()
    {
        return [
            'refreshCount' => 'refreshCount',
        ];
    }
}
