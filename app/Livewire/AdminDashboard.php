<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AdminDashboard extends Component
{
    public $totalUsers;
    public $recentTickets;

    public function mount($totalUsers, $recentTickets)
    {
        $this->totalUsers = $totalUsers;
        $this->recentTickets = $recentTickets;
    }

    public function render()
    {
        return view('livewire.admin-dashboard');
    }
}
