<?php

// App/Http/Livewire/Register/EmployeeComponent.php

namespace App\Http\Livewire\Register;

use Livewire\Component;
use App\Models\EmployeeDetail;
use App\Models\Department;
use App\Models\Position;

class EmployeeComponent extends Component
{
    public $department_id, $position_id, $salary, $date_of_joining, $address, $nationality, $age, $date_of_birth, $phone, $user_id;
    public $departments, $positions;

    protected $listeners = ['roleFormSubmitted' => 'submitEmployeeDetails'];

    public function mount()
    {
        $this->departments = Department::all();
        $this->positions = Position::all();
    }

    public function submitEmployeeDetails($userId, $roleId)
    {
        if ($roleId == 5) {
            $this->user_id = $userId;
            $this->validate([
                'department_id' => 'required|integer',
                'position_id' => 'required|integer',
                'salary' => 'required|numeric',
                'date_of_joining' => 'required|date',
                'address' => 'required|string',
                'nationality' => 'required|string',
                'age' => 'required|integer|min:0',
                'date_of_birth' => 'required|date',
            ]);

            EmployeeDetail::create([
                'user_id' => $this->user_id,
                'department_id' => $this->department_id,
                'position_id' => $this->position_id,
                'salary' => $this->salary,
                'date_of_joining' => $this->date_of_joining,
                'address' => $this->address,
                'nationality' => $this->nationality,
                'age' => $this->age,
                'date_of_birth' => $this->date_of_birth,
                'phone' => $this->phone,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.register.employee-component');
    }
}
