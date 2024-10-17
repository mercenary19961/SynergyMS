<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;

class RecentProjects extends Component
{
    public $recentProjects;
    public $pollingInterval = 10000; // 10 seconds

    public function mount()
    {
        $this->recentProjects = $this->getRecentProjects();
    }

    public function render()
    {
        return view('livewire.recent-projects');
    }

    public function getRecentProjects()
    {
        // Fetch the most recent projects with their related client and project manager (adjust limit as needed)
        return Project::with(['client.user', 'projectManager.user']) // Adjusted to projectManager
            ->latest()
            ->limit(5)
            ->get();
    }

    // Livewire method to refresh the recent projects
    public function refreshRecentProjects()
    {
        $this->recentProjects = $this->getRecentProjects();
    }

    public function getListeners()
    {
        return [
            'refreshRecentProjects' => 'refreshRecentProjects',
        ];
    }
}

