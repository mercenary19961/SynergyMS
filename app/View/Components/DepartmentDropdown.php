<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Department;

class DepartmentDropdown extends Component
{
    public $departments;

    public function __construct()
    {
        // Fetch first 6 departments by id order
        $this->departments = Department::orderBy('id', 'asc')->limit(6)->get();
    }

    public function render()
    {
        return view('components.department-dropdown')->with('departments', $this->departments);
    }
}
