<?php

// App/Http/Livewire/Register/HRComponent.php

namespace App\Http\Livewire\Register;

use Livewire\Component;
use App\Models\HumanResources;
use App\Models\Department;
use App\Models\Position;

class HRComponent extends Component
{
    public $department_id, $position_id, $contact_number, $company_email, $user_id;
    public $departments, $positions;

    protected $listeners = ['roleFormSubmitted' => 'submitHRDetails'];

    public function mount()
    {
        $this->departments = Department::all();
        $this->positions = Position::all();
    }

    public function submitHRDetails($userId, $roleId)
    {
        if ($roleId == 4) {
            $this->user_id = $userId;
            $this->validate([
                'department_id' => 'required|integer',
                'position_id' => 'required|integer',
                'contact_number' => 'required|string',
                'company_email' => 'required|email',
            ]);

            HumanResources::create([
                'user_id' => $this->user_id,
                'department_id' => $this->department_id,
                'position_id' => $this->position_id,
                'contact_number' => $this->contact_number,
                'company_email' => $this->company_email,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.register.hr-component');
    }
}

