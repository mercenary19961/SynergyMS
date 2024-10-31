<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\EmployeeDetail;
use App\Models\Client;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\Attendance;
use App\Models\ProjectManager;
use Illuminate\Support\Facades\Log;


class SummaryCard extends Component
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
        return view('livewire.summary-card');
    }

    public function getCount()
    {
        switch ($this->countType) {
            case 'employees':
                $count = EmployeeDetail::count();
                break;
            case 'clients':
                $count = Client::count();
                break;
            case 'project_managers':
                $count = ProjectManager::count();
                break;
            case 'projects':
                $count = Project::count();
                break;
            case 'tickets':
                $count = Ticket::count();
                break;
            case 'today_clockins':
                $count = Attendance::whereDate('attendance_date', now()->toDateString())
                                    ->whereNotNull('clock_in')
                                    ->count();
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
