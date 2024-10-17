<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\EmployeeDetail;

class RecentEmployees extends Component
{
    public $recentEmployees;
    public $pollingInterval = 10000; // 10 seconds

    public function mount()
    {
        $this->refreshRecentEmployees();
    }

    public function render()
    {
        return view('livewire.recent-employees');
    }

    public function refreshRecentEmployees()
    {
        // Fetch the most recent employees
        $this->recentEmployees = EmployeeDetail::with('user')
            ->latest()
            ->limit(5)
            ->get();
    }

    public function getListeners()
    {
        return [
            'refreshRecentEmployees' => 'refreshRecentEmployees',
        ];
    }
}
