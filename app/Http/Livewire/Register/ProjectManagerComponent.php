<?php

// App/Http/Livewire/Register/ProjectManagerComponent.php

namespace App\Http\Livewire\Register;

use Livewire\Component;
use App\Models\ProjectManager;
use App\Models\Department;

class ProjectManagerComponent extends Component
{
    public $department_id, $assigned_projects = 0, $experience_years, $contact_number, $user_id;
    public $departments;

    protected $listeners = ['roleFormSubmitted' => 'submitProjectManagerDetails'];

    public function mount()
    {
        $this->departments = Department::all();
    }

    public function submitProjectManagerDetails($userId, $roleId)
    {
        if ($roleId == 3) {
            $this->user_id = $userId;
            $this->validate([
                'department_id' => 'required|integer',
                'experience_years' => 'nullable|integer',
                'contact_number' => 'required|string|max:15',
            ]);

            ProjectManager::create([
                'user_id' => $this->user_id,
                'department_id' => $this->department_id,
                'assigned_projects' => $this->assigned_projects,
                'experience_years' => $this->experience_years,
                'contact_number' => $this->contact_number,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.register.project-manager-component');
    }
}
