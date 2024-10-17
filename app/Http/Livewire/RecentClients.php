<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Client;

class RecentClients extends Component
{
    public $recentClients;
    public $pollingInterval = 10000; // 10 seconds

    public function mount()
    {
        $this->refreshRecentClients();
    }

    public function render()
    {
        return view('livewire.recent-clients');
    }

    public function refreshRecentClients()
    {
        // Fetch the most recent clients
        $this->recentClients = Client::with('user')
            ->latest()
            ->limit(5)
            ->get();
    }

    public function getListeners()
    {
        return [
            'refreshRecentClients' => 'refreshRecentClients',
        ];
    }
}
