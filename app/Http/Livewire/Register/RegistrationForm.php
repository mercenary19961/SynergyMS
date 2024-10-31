<?php

namespace App\Http\Livewire\Register;

use Livewire\Component;
use App\Models\User;
use App\Models\Client;
use App\Models\ProjectManager;
use App\Models\HumanResources;
use App\Models\EmployeeDetail;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Livewire\WithFileUploads;

class RegistrationForm extends Component
{
    use WithFileUploads;

    public $name, $email, $password, $gender, $role_id, $image;
    public $company_name_display, $industry_display, $address_display, $website, $contact_number;
    public $department_id, $experience_years_display, $position_display, $salary_display, $date_of_joining_display;
    public $selectedRole = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'gender' => 'required|in:male,female',
        'role_id' => 'required|integer|exists:roles,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
    ];

    public function updatedRoleId($value)
    {
        $this->selectedRole = $value;
    }

    public function submit()
    {
        // Step 1: Validate the common user data
        $this->validate();

        // Step 2: Image handling and storage
        $imagePath = null;
        if ($this->image) {
            $roleStorageMap = [
                2 => 'clients',
                3 => 'project_managers',
                4 => 'human_resources',
                5 => 'employee_images',
            ];
            $storageFolder = $roleStorageMap[$this->role_id] ?? 'others';
            $imagePath = $this->image->store($storageFolder, 'public');
        }

        // Step 3: Create the User record
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'gender' => $this->gender,
            'profile_image' => $imagePath,
        ]);

        // Step 4: Assign the Role to the User
        $role = Role::find($this->role_id);
        if ($role) {
            $user->assignRole($role);
        }

        // Step 5: Role-specific data handling
        switch ($this->role_id) {
            case 2: // Client
                $this->validate([
                    'company_name_display' => 'required|string|max:255',
                    'industry_display' => 'required|string|max:255',
                    'address_display' => 'required|string|max:255',
                    'contact_number' => 'required|string|max:15',
                    'website' => 'nullable|url',
                ]);

                Client::create([
                    'user_id' => $user->id,
                    'company_name' => $this->company_name_display,
                    'industry' => $this->industry_display,
                    'address' => $this->address_display,
                    'contact_number' => $this->contact_number,
                    'website' => $this->website,
                ]);
                break;

            case 3: // Project Manager
                $this->validate([
                    'department_id' => 'required|integer',
                    'experience_years_display' => 'required|integer|min:0',
                    'contact_number' => 'required|string|max:15',
                ]);

                ProjectManager::create([
                    'user_id' => $user->id,
                    'department_id' => $this->department_id,
                    'experience_years' => $this->experience_years_display,
                    'contact_number' => $this->contact_number,
                ]);
                break;

            case 4: // HR
                $this->validate([
                    'department_id' => 'required|integer',
                    'position_display' => 'required|string',
                    'contact_number' => 'required|string|max:15',
                    'company_email_display' => 'required|email',
                ]);

                HumanResources::create([
                    'user_id' => $user->id,
                    'department_id' => $this->department_id,
                    'position' => $this->position_display,
                    'contact_number' => $this->contact_number,
                    'company_email' => $this->company_email_display,
                ]);
                break;

            case 5: // Employee
                $this->validate([
                    'department_id' => 'required|integer',
                    'position_display' => 'required|string',
                    'salary_display' => 'required|numeric',
                    'date_of_joining_display' => 'required|date',
                    'address_display' => 'required|string',
                    'nationality' => 'required|string',
                    'age' => 'required|integer|min:0',
                    'date_of_birth' => 'required|date',
                ]);

                EmployeeDetail::create([
                    'user_id' => $user->id,
                    'department_id' => $this->department_id,
                    'position' => $this->position_display,
                    'salary' => $this->salary_display,
                    'date_of_joining' => $this->date_of_joining_display,
                    'address' => $this->address_display,
                    'nationality' => $this->nationality,
                    'age' => $this->age,
                    'date_of_birth' => $this->date_of_birth,
                ]);
                break;
        }

        // Step 6: Flash success message and reset form
        session()->flash('status', 'User and role-specific details saved successfully!');
        $this->reset();
    }

    public function render()
    {
        $roles = Role::whereIn('id', [2, 3, 4, 5])->get();
        return view('livewire.register.registration-form', compact('roles'));
    }
}
